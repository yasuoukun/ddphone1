<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Payment;

/**
 * Order model representing a customer order.
 * Includes helper methods to confirm, cancel, and restore stock.
 */
class Order extends Model
{
    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_info',
        'tracking_number',
        'shipping_courier',
        'coupon_code',
        'discount_amount',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Confirm the order and mark related payment as completed.
     * Adjust product stock accordingly.
     */
    /**
     * Deduct stock when customer uploads payment slip (pending_verification).
     * This prevents overselling while waiting for admin to confirm.
     */
    public function deductStock()
    {
        $this->loadMissing('items.product');
        foreach ($this->items as $item) {
            if ($item->product) {
                $newStock = max(0, $item->product->stock - $item->quantity);
                $item->product->update(['stock' => $newStock]);
            }
        }
    }

    public function confirm()
    {
        if ($this->status !== 'confirmed') {
            $this->update(['status' => 'confirmed']);

            $payment = $this->payments()->first();
            if ($payment) {
                $payment->update(['status' => 'completed']);
            }

            // Mark collected coupon as used ONLY when payment is confirmed
            if ($this->coupon_code && $this->user_id) {
                $coupon = \App\Models\Coupon::where('code', $this->coupon_code)->first();
                if ($coupon) {
                    \App\Models\CollectedCoupon::where('user_id', $this->user_id)
                        ->where('coupon_id', $coupon->id)
                        ->update(['is_used' => true]);
                }
            }

            // NOTE: Stock is already deducted at upload-slip stage (pending_verification).
            // No double-deduction needed here.
        }
    }

    /**
     * Cancel the order and restore product stock if it was previously deducted.
     */
    public function cancelAndRestoreStock()
    {
        $oldStatus = $this->status;
        $this->update(['status' => 'cancelled']);

        $payment = $this->payments()->first();
        if ($payment) {
            $payment->update(['status' => 'failed']);
        }

        // Return stock if it was already deducted (slip uploaded or confirmed/shipped)
        if (in_array($oldStatus, ['pending_verification', 'confirmed', 'shipped'])) {
            $this->loadMissing('items.product');
            foreach ($this->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }
    }
}
