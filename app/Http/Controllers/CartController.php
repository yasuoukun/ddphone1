<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        if ($product->stock <= 0) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'สินค้าชิ้นนี้หมดชั่วคราว ไม่สามารถเพิ่มลงในตะกร้าได้'
                ], 400);
            }
            return redirect()->back()->with('error', 'สินค้าชิ้นนี้หมดชั่วคราว ไม่สามารถเพิ่มลงในตะกร้าได้');
        }

        $cart = session()->get('cart', []);
        $currentQty = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        $requestedQty = max(1, intval($request->input('quantity', 1)));

        if ($currentQty + $requestedQty > $product->stock) {
            $msg = "สินค้าชิ้นนี้เหลือในสต๊อกเพียง {$product->stock} ชิ้น ไม่สามารถเพิ่มเกินจำนวนได้";
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg
                ], 400);
            }
            return redirect()->back()->with('error', $msg);
        }

        $image = "";
        $primaryImg = $product->images->where('is_primary', true)->first() ?? $product->images->first();
        if ($primaryImg) {
            $image = $primaryImg->image_path;
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $requestedQty;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $requestedQty,
                "price" => $product->discount_price ?? $product->price,
                "image" => $image
            ];
        }
        
        session()->put('cart', $cart);
        
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => count($cart),
                'message' => 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้ว'
            ]);
        }

        return redirect()->route('cart.index')->with('sweet_success', 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้ว');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $product = Product::find($request->id);
            $newQty = max(1, intval($request->quantity));

            if ($product && $newQty > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "สินค้าในสต๊อกมีเพียง {$product->stock} ชิ้น ไม่สามารถเพิ่มเกินจำนวนได้"
                ], 400);
            }

            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = $newQty;
                session()->put('cart', $cart);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    public function view()
    {
        return view('cart.index');
    }
}
