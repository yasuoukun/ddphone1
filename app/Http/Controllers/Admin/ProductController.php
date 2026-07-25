<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->paginate(12);
        return view('central_admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('central_admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'freebie' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validatedData = $validated;
        unset($validatedData['images']);

        if (empty($validatedData['sku'])) {
            $validatedData['sku'] = Product::generateSku($validatedData['brand_id'] ?? null, $validatedData['category_id'] ?? null);
        }

        $product = Product::create($validatedData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0
                ]);
            }
        }

        return redirect()->route('central_admin.products.index')->with('success', 'เพิ่มสินค้าเรียบร้อยแล้ว');
    }

    public function generateSkuAjax(Request $request)
    {
        $brandId = $request->query('brand_id');
        $categoryId = $request->query('category_id');
        $sku = Product::generateSku($brandId, $categoryId);
        return response()->json(['sku' => $sku]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product->load('images');
        return view('central_admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'freebie' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validatedData = $validated;
        unset($validatedData['images']);
        $product->update($validatedData);

        if ($request->hasFile('images')) {
            $hasPrimary = $product->images()->where('is_primary', true)->exists();
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => !$hasPrimary && $index === 0
                ]);
                if (!$hasPrimary && $index === 0) {
                    $hasPrimary = true;
                }
            }
        }

        return redirect()->route('central_admin.products.index')->with('success', 'อัปเดตสินค้าเรียบร้อยแล้ว');
    }

    public function setImagePrimary(ProductImage $image)
    {
        ProductImage::where('product_id', $image->product_id)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        return redirect()->back()->with('success', 'ตั้งค่ารูปภาพหน้าปกเรียบร้อยแล้ว');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $wasPrimary = $image->is_primary;
        $image->delete();

        if ($wasPrimary) {
            $nextImage = ProductImage::where('product_id', $image->product_id)->first();
            if ($nextImage) {
                $nextImage->update(['is_primary' => true]);
            }
        }

        return redirect()->back()->with('success', 'ลบรูปภาพเรียบร้อยแล้ว');
    }

    public function destroy(Product $product)
    {
        foreach($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        $product->delete();
        return redirect()->route('central_admin.products.index')->with('success', 'ลบสินค้าเรียบร้อยแล้ว');
    }
}
