<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Claim;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.claims.index', compact('claims'));
    }

    public function show(Claim $claim)
    {
        return view('admin.claims.show', compact('claim'));
    }

    public function update(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,pending_assessment,quoted,confirmed_waiting_device,device_received,in_repair,in_progress,repaired_waiting_payment,return_shipped,completed,cancelled',
            'warranty_status' => 'nullable|string|in:in_warranty,out_of_warranty,unknown',
            'estimated_cost' => 'nullable|numeric|min:0',
            'estimated_days' => 'nullable|integer|min:0',
            'return_tracking_number' => 'nullable|string|max:100',
            'return_courier' => 'nullable|string|max:100',
            'admin_notes' => 'nullable|string',
        ]);

        $oldStatus = $claim->status;
        $claim->update($validated);

        // Send Notification to customer if user_id is set
        if ($claim->user_id && $oldStatus !== $claim->status) {
            try {
                $statusMsg = match ($claim->status) {
                    'pending_assessment' => "ทางร้านได้รับเรื่องเรียบร้อยแล้ว กำลังอยู่ระหว่างการตรวจประเมินและเช็คประกันอุปกรณ์ {$claim->device_name}",
                    'quoted' => "ร้านค้าประเมินราคาซ่อมและสิทธิประกันแล้ว: ฿" . number_format($claim->estimated_cost ?? 0) . " กรุณาเข้ามากด ยืนยันการซ่อม",
                    'confirmed_waiting_device' => "ยืนยันการส่งซ่อมเรียบร้อยแล้ว กรุณาจัดส่งพัสดุอุปกรณ์ {$claim->device_name} มาที่ร้าน DDPHONE และแจ้งเลขพัสดุในระบบ",
                    'device_received' => "ทางร้านได้รับพัสดุอุปกรณ์ {$claim->device_name} เรียบร้อยแล้ว กำลังส่งช่างตรวจเช็คอย่างละเอียด",
                    'in_repair', 'in_progress' => "ช่างกำลังดำเนินการซ่อมอุปกรณ์ {$claim->device_name} ของท่าน",
                    'repaired_waiting_payment' => "อุปกรณ์ {$claim->device_name} ซ่อมเสร็จเรียบร้อยแล้ว (รอชำระเงิน/เตรียมจัดส่งคืน)",
                    'return_shipped' => "จัดส่งพัสดุอุปกรณ์คืนแล้ว (ขนส่ง: {$claim->return_courier} | เลขพัสดุ: {$claim->return_tracking_number})",
                    'completed' => "รายการส่งซ่อม {$claim->id} เสร็จสมบูรณ์แล้ว ขอบคุณที่ไว้วางใจ DDPHONE",
                    'cancelled' => "รายการส่งซ่อม {$claim->id} ถูกยกเลิก",
                    default => "อัปเดตสถานะงานซ่อม {$claim->id}: {$claim->status_label}",
                };

                \App\Models\Notification::sendToUser(
                    $claim->user_id,
                    "🔔 อัปเดตสถานะงานซ่อม [{$claim->id}]",
                    $statusMsg,
                    route('tracking', ['q' => $claim->id, 'type' => 'claim'])
                );
            } catch (\Throwable $e) {}
        }

        return redirect()->route('admin.claims.show', $claim->id)
            ->with('success', 'อัปเดตข้อมูลและสถานะงานซ่อมเรียบร้อยแล้ว');
    }

    public function destroy(Claim $claim)
    {
        $claim->delete();
        return redirect()->route('admin.claims.index')
            ->with('success', 'ลบรายการเคลม/ส่งซ่อมเรียบร้อยแล้ว');
    }
}
