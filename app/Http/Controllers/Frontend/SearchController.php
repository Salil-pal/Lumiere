<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->category;

        $products = Product::query();

        // search by name
        if ($query) {
            $products->where('en_name', 'LIKE', "%$query%");
        }

        // filter by category
        if ($category) {
            $products->where('category_id', $category);
        }

        if ($request->sort == 'latest') {
            $products->orderBy('created_at', 'desc');
        }

        if ($request->sort == 'low') {
            $products->orderBy('price', 'asc');
        }

        if ($request->sort == 'high') {
            $products->orderBy('price', 'desc');
        }

        if ($request->sort == 'name') {
            $products->orderBy('en_name', 'asc');
        }

        $products = $products->paginate(4);

        $categories = Category::where('status',1)->get(); // 👈 ADD THIS

        return view('front.search-results.index', compact('products','categories'));
    }
}