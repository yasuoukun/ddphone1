<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Claim extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'order_id',
        'customer_name',
        'customer_phone',
        'device_name',
        'serial_number',
        'claim_type',
        'issue_description',
        'status',
        'admin_notes',
        'estimated_cost',
        'estimated_days',
        'warranty_status',
        'image_paths',
        'inbound_tracking_number',
        'inbound_courier',
        'return_tracking_number',
        'return_courier',
        'delivery_method',
        'customer_confirmed_at',
    ];

    protected $casts = [
        'image_paths' => 'array',
        'estimated_cost' => 'decimal:2',
        'estimated_days' => 'integer',
        'customer_confirmed_at' => 'datetime',
    ];

    /**
     * Check warranty status based on order delivery date (+30 days)
     */
    public function getCalculatedWarrantyInfoAttribute()
    {
        if (!$this->order) {
            return [
                'is_in_warranty' => false,
                'status_label' => 'ไม่มีข้อมูลประกัน (เครื่องนอก)',
                'days_remaining' => 0,
                'delivered_at' => null,
                'warranty_expires_at' => null,
            ];
        }

        // Determine delivery date: order updated_at if status is delivered/completed/shipped or created_at + 2 days
        $deliveryDate = $this->order->updated_at;
        $warrantyExpiresAt = $deliveryDate->copy()->addDays(30);
        $now = now();

        $isInWarranty = $now->lte($warrantyExpiresAt);
        $daysRemaining = max(0, (int) $now->diffInDays($warrantyExpiresAt, false));

        return [
            'is_in_warranty' => $isInWarranty,
            'status_label' => $isInWarranty ? "อยู่ในประกันร้าน (เหลือ {$daysRemaining} วัน)" : "หมดประกันร้านแล้ว (ซื้อเมื่อ {$deliveryDate->format('d/m/Y')})",
            'days_remaining' => $daysRemaining,
            'delivered_at' => $deliveryDate,
            'warranty_expires_at' => $warrantyExpiresAt,
        ];
    }

    /**
     * Helper for status label in Thai
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending', 'pending_assessment' => 'รอแอดมินประเมิน / เช็คประกัน',
            'quoted' => 'เสนอราคาแล้ว (รอลูกค้ายืนยัน)',
            'confirmed_waiting_device' => 'ลูกค้ายืนยันแล้ว (รอจัดส่งเครื่อง)',
            'device_received' => 'ได้รับเครื่องแล้ว (กำลังตรวจเช็ค)',
            'in_repair', 'in_progress' => 'กำลังดำเนินการซ่อม',
            'repaired_waiting_payment' => 'ซ่อมเสร็จแล้ว (รอชำระเงิน/เตรียมส่งคืน)',
            'return_shipped' => 'จัดส่งเครื่องคืนแล้ว',
            'completed' => 'เสร็จสิ้นสมบูรณ์',
            'cancelled' => 'ยกเลิกรายการ',
            default => 'กำลังดำเนินการ',
        };
    }

    /**
     * Helper for status badge CSS classes
     */
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'pending', 'pending_assessment' => 'bg-amber-100 text-amber-800 border-amber-300',
            'quoted' => 'bg-blue-100 text-blue-800 border-blue-300',
            'confirmed_waiting_device' => 'bg-purple-100 text-purple-800 border-purple-300',
            'device_received' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
            'in_repair', 'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
            'repaired_waiting_payment' => 'bg-amber-100 text-amber-800 border-amber-300',
            'return_shipped' => 'bg-sky-100 text-sky-800 border-sky-300',
            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = 'CLM-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
