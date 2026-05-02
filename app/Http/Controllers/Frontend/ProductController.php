<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // OLD (optional use)
    public function index()
    {
        $products = Product::where('is_active', 1)
            ->latest()->take(4)
            ->get();

        return view('front.products.index', compact('products'));
    }

    // SHOP PAGE (FILTER + SORT)
    public function shop(Request $request)
    {
        $products = Product::with('brand')
            ->where('is_active', 1);

        // ------------------------
        // CATEGORY FILTER
        // ------------------------
        if ($request->filled('category')) {
            $products->where('category_id', $request->category);
        }

        // ------------------------
        // SORTING
        // ------------------------
        if ($request->filled('sort')) {

            if ($request->sort === 'price_asc') {
                $products->orderBy('price', 'asc');
            } 
            elseif ($request->sort === 'price_desc') {
                $products->orderBy('price', 'desc');
            }

        } else {
            $products->latest();
        }

        // ------------------------
        // PAGINATION
        // ------------------------
        $products = $products->paginate(12)->withQueryString();

        // ------------------------
        // CATEGORIES
        // ------------------------
        $categories = Category::withCount('products')->get();

        // ------------------------
        // CATEGORY NAME (TITLE)
        // ------------------------
        $categoryName = null;

        if ($request->filled('category')) {
            $categoryName = Category::find($request->category)?->en_category_name;
        }

        return view('front.shop.index', compact(
            'products',
            'categories',
            'categoryName'
        ));
    }

    // SINGLE PRODUCT
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('front.products.show', compact('product'));
    }
}