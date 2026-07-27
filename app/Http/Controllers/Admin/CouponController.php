<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Product;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('product')->orderBy('id', 'desc')->get();
        $products = Product::orderBy('name', 'asc')->get();
        return view('central_admin.coupons.index', compact('coupons', 'products'));
    }

    public function create()
    {
        $products = Product::orderBy('name', 'asc')->get();
        return view('central_admin.coupons.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'code' => 'required|string|unique:coupons,code|max:50',
            'product_id' => 'nullable|exists:products,id',
            'discount_amount' => 'required|numeric|min:0',
            'expires_at' => 'required|date|after_or_equal:today',
        ]);

        Coupon::create($validated);

        return redirect()->route('central_admin.coupons.index')->with('success', 'สร้างคูปองส่วนลดสำเร็จแล้ว');
    }

    public function edit(Coupon $coupon)
    {
        $products = Product::orderBy('name', 'asc')->get();
        return view('central_admin.coupons.edit', compact('coupon', 'products'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'product_id' => 'nullable|exists:products,id',
            'discount_amount' => 'required|numeric|min:0',
            'expires_at' => 'required|date|after_or_equal:today',
        ]);

        $coupon->update($validated);

        return redirect()->route('central_admin.coupons.index')->with('success', 'อัปเดตคูปองส่วนลดสำเร็จแล้ว');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('central_admin.coupons.index')->with('success', 'ลบคูปองส่วนลดเรียบร้อยแล้ว');
    }
}
