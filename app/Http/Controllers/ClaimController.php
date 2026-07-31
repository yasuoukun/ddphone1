<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Order;

class ClaimController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'device_name' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'claim_type' => 'required|string|in:warranty,repair,setting',
            'issue_description' => 'required|string',
            'order_id_raw' => 'nullable|string|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $order = null;
        $warrantyStatus = 'unknown';

        if (!empty($validated['order_id_raw'])) {
            $order = Order::find($validated['order_id_raw']);
            if ($order) {
                $deliveryDate = $order->updated_at;
                $warrantyExpiresAt = $deliveryDate->copy()->addDays(30);
                $warrantyStatus = now()->lte($warrantyExpiresAt) ? 'in_warranty' : 'out_of_warranty';
            }
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('claims', 'public');
            }
        }

        $claim = Claim::create([
            'user_id' => auth()->id(),
            'order_id' => $order ? $order->id : null,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'device_name' => $validated['device_name'],
            'serial_number' => $validated['serial_number'],
            'claim_type' => $validated['claim_type'],
            'warranty_status' => $warrantyStatus,
            'issue_description' => $validated['issue_description'],
            'image_paths' => $imagePaths,
            'status' => 'pending',
        ]);

        // Send real-time notification to admin (stored for admin dashboard reference)
        try {
            \App\Models\Notification::create([
                'user_id' => null,
                'title' => '🔧 มีรายการแจ้งส่งซ่อม/เคลมใหม่',
                'message' => "ลูกค้า {$claim->customer_name} แจ้งซ่อม {$claim->device_name} (สิทธิ: {$claim->warranty_status})",
                'url' => route('admin.claims.show', $claim->id),
                'is_read' => false,
            ]);
        } catch (\Throwable $e) {}

        // [Option B] Notify customer immediately upon submission (only if logged in)
        if (auth()->check()) {
            try {
                $claimTypeLabel = match ($claim->claim_type) {
                    'warranty' => 'เคลมประกัน',
                    'repair'   => 'ส่งซ่อม',
                    'setting'  => 'ตั้งค่า/ลงโปรแกรม',
                    default    => 'แจ้งงาน',
                };
                \App\Models\Notification::sendToUser(
                    auth()->id(),
                    "✅ ระบบได้รับใบแจ้ง{$claimTypeLabel}ของคุณแล้ว",
                    "รหัสงาน: {$claim->id} | อุปกรณ์: {$claim->device_name} | ทีมงาน DDPHONE จะรีบตรวจสอบและแจ้งผลกลับโดยเร็วครับ",
                    route('tracking', ['q' => $claim->id, 'type' => 'claim'])
                );
            } catch (\Throwable $e) {}
        }

        return redirect()->route('tracking', ['q' => $claim->id, 'type' => 'claim'])
            ->with('sweet_success', "แจ้งส่งซ่อมเรียบร้อยแล้ว! รหัสติดตามของคุณคือ: {$claim->id} แอดมินจะรีบตรวจสอบและเสนอราคาให้ท่านทันทีครับ");
    }

    public function track(Request $request)
    {
        $q = $request->input('q');
        $type = $request->input('type', 'order'); // order or claim

        $result = null;
        if ($q) {
            if ($type === 'claim') {
                $result = Claim::find($q);
            } else {
                $result = Order::with('items.product')->find($q);
            }
        }

        return view('tracking', compact('result', 'q', 'type'));
    }
}
