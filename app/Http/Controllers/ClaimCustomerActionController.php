<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;

class ClaimCustomerActionController extends Controller
{
    /**
     * Customer confirms repair offer
     */
    public function confirm(Request $request, Claim $claim)
    {
        if (!in_array($claim->status, ['quoted', 'pending_assessment', 'pending', 'confirmed_waiting_device'])) {
            return back()->with('error', 'รายการส่งซ่อมนี้ไม่ได้อยู่ในสถานะรอการยืนยันราคา');
        }

        $validated = $request->validate([
            'delivery_method' => 'required|string|in:shipping,dropoff',
        ]);

        $claim->update([
            'status' => 'confirmed_waiting_device',
            'delivery_method' => $validated['delivery_method'],
            'customer_confirmed_at' => now(),
        ]);

        // Send real-time notification to admin / system notification
        try {
            \App\Models\Notification::create([
                'user_id' => null, // Broadcast to admin
                'title' => '✅ ลูกค้ายืนยันส่งซ่อมแล้ว',
                'message' => "ลูกค้ายืนยันส่งซ่อมอุปกรณ์ {$claim->device_name} (งานเลขที่: {$claim->id})",
                'url' => route('admin.claims.show', $claim->id),
                'is_read' => false,
            ]);

            // Notify customer as well if logged in
            if ($claim->user_id) {
                \App\Models\Notification::sendToUser(
                    $claim->user_id,
                    "✅ คุณได้ยืนยันการซ่อม [{$claim->id}] เรียบร้อยแล้ว",
                    "กรุณาจัดส่งเครื่องมาที่ร้าน DDPHONE แล้วระบุเลขพัสดุในระบบติดตามงานซ่อมครับ",
                    route('tracking', ['q' => $claim->id, 'type' => 'claim'])
                );
            }
        } catch (\Throwable $e) {}

        return redirect()->route('tracking', ['q' => $claim->id, 'type' => 'claim'])
            ->with('sweet_success', 'ยืนยันการส่งซ่อมเรียบร้อยแล้ว! กรุณาจัดส่งพัสดุมาตามที่อยู่ด้านล่างแล้วแจ้งเลขพัสดุในระบบครับ');
    }

    /**
     * Customer declines repair offer
     */
    public function decline(Request $request, Claim $claim)
    {
        if (!in_array($claim->status, ['quoted', 'pending_assessment', 'pending'])) {
            return back()->with('error', 'รายการนี้ไม่สามารถยกเลิกได้แล้ว');
        }

        $claim->update([
            'status' => 'cancelled',
            'admin_notes' => ($claim->admin_notes ? $claim->admin_notes . "\n" : "") . "ลูกค้ายกเลิกรายการส่งซ่อมเมื่อ " . now()->format('d/m/Y H:i'),
        ]);

        if ($claim->user_id) {
            try {
                \App\Models\Notification::sendToUser(
                    $claim->user_id,
                    "❌ ยกเลิกรายการส่งซ่อม [{$claim->id}]",
                    "คุณได้ทำการยกเลิกรายการส่งซ่อมอุปกรณ์ {$claim->device_name} เรียบร้อยแล้ว",
                    route('tracking', ['q' => $claim->id, 'type' => 'claim'])
                );
            } catch (\Throwable $e) {}
        }

        return redirect()->route('tracking', ['q' => $claim->id, 'type' => 'claim'])
            ->with('sweet_success', 'ยกเลิกรายการส่งซ่อมเรียบร้อยแล้ว');
    }

    /**
     * Customer submits inbound tracking number
     */
    public function submitTracking(Request $request, Claim $claim)
    {
        if (in_array($claim->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'รายการส่งซ่อมนี้ไม่สามารถแจ้งเลขพัสดุได้');
        }

        $validated = $request->validate([
            'inbound_tracking_number' => 'required|string|max:100',
            'inbound_courier' => 'required|string|max:100',
        ]);

        $claim->update([
            'inbound_tracking_number' => $validated['inbound_tracking_number'],
            'inbound_courier' => $validated['inbound_courier'],
        ]);

        if ($claim->user_id) {
            try {
                \App\Models\Notification::sendToUser(
                    $claim->user_id,
                    "📦 บันทึกเลขพัสดุส่งซ่อม [{$claim->id}]",
                    "บันทึกเลขพัสดุ ({$validated['inbound_courier']}: {$validated['inbound_tracking_number']}) เรียบร้อยแล้ว ร้านจะรีบตรวจเช็คเมื่อพัสดุถึงครับ",
                    route('tracking', ['q' => $claim->id, 'type' => 'claim'])
                );
            } catch (\Throwable $e) {}
        }

        return redirect()->route('tracking', ['q' => $claim->id, 'type' => 'claim'])
            ->with('sweet_success', 'บันทึกเลขพัสดุเรียบร้อยแล้ว ทางร้านจะเร่งตรวจสอบเมื่อพัสดุมาถึงครับ');
    }
}
