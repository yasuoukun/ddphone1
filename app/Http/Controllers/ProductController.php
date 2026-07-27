<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['images', 'brand', 'category']);

        // Smart Multi-word search across name, description, sku, brand name, category name
        if ($request->filled('q')) {
            $keywords = array_filter(explode(' ', trim($request->input('q'))));
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function($sub) use ($word) {
                        $sub->where('name', 'like', "%{$word}%")
                            ->orWhere('description', 'like', "%{$word}%")
                            ->orWhere('sku', 'like', "%{$word}%")
                            ->orWhereHas('brand', function($b) use ($word) {
                                $b->where('name', 'like', "%{$word}%");
                            })
                            ->orWhereHas('category', function($c) use ($word) {
                                $c->where('name', 'like', "%{$word}%");
                            });
                    });
                }
            });
        }

        // Filter by multiple Brand IDs (Checkboxes)
        if ($request->has('brand_ids') && is_array($request->input('brand_ids'))) {
            $query->whereIn('brand_id', $request->input('brand_ids'));
        } elseif ($request->filled('brand_id')) {
            // Backward compatibility for single brand ID query
            $query->where('brand_id', $request->input('brand_id'));
        }

        // Filter by multiple Category IDs (Checkboxes)
        if ($request->has('category_ids') && is_array($request->input('category_ids'))) {
            $query->whereIn('category_id', $request->input('category_ids'));
        } elseif ($request->filled('category_id')) {
            // Backward compatibility for single category ID query
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter by Min/Max Price
        if ($request->filled('min_price')) {
            $query->where(function($q) use ($request) {
                $q->where(function($sub) use ($request) {
                    $sub->whereNotNull('discount_price')
                        ->where('discount_price', '>=', $request->input('min_price'));
                })->orWhere(function($sub) use ($request) {
                    $sub->whereNull('discount_price')
                        ->where('price', '>=', $request->input('min_price'));
                });
            });
        }
        if ($request->filled('max_price')) {
            $query->where(function($q) use ($request) {
                $q->where(function($sub) use ($request) {
                    $sub->whereNotNull('discount_price')
                        ->where('discount_price', '<=', $request->input('max_price'));
                })->orWhere(function($sub) use ($request) {
                    $sub->whereNull('discount_price')
                        ->where('price', '<=', $request->input('max_price'));
                });
            });
        }

        // Filter for discounted/on-sale products only
        if ($request->boolean('on_sale')) {
            $query->whereNotNull('discount_price')->where('discount_price', '>', 0);
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $brands = Brand::all();
        $categories = Category::all();

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            $gridHtml = view('products.partials.product_grid', compact('products'))->render();
            $paginationHtml = $products->links()->toHtml();
            return response()->json([
                'html' => $gridHtml,
                'total' => $products->total(),
                'pagination' => $paginationHtml
            ]);
        }

        return view('products.index', compact('products', 'brands', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['images', 'brand', 'category', 'reviews.user']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        return view('products.show', compact('product', 'relatedProducts'));
    }
}
