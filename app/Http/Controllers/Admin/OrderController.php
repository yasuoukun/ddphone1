<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Only show orders where customer has uploaded payment slip / paid (excluding unpaid 'pending' drafts)
        $orders = Order::where('status', '!=', 'pending')
            ->with(['user', 'items.product.images', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user', 'payments']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status'           => 'required|in:pending,pending_verification,confirmed,shipped,delivered,cancelled',
            'tracking_number'  => 'nullable|string|max:100',
            'shipping_courier' => 'nullable|string|max:100',
        ]);

        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        // Update tracking fields first (always safe)
        $order->update([
            'tracking_number'  => $validated['tracking_number'],
            'shipping_courier' => $validated['shipping_courier'],
        ]);

        if ($newStatus === 'confirmed' && $oldStatus !== 'confirmed') {
            // confirm() handles status change, payment update, and coupon marking.
            // Stock was already deducted at slip-upload stage — no double deduction.
            $order->confirm();

        } elseif ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            // Restore stock if order had already been moved past pending
            $order->load('items.product');
            $order->cancelAndRestoreStock();

        } else {
            $order->update(['status' => $newStatus]);
        }

        return redirect()->back()->with('success', 'อัปเดตสถานะคำสั่งซื้อเรียบร้อยแล้ว');
    }
}
