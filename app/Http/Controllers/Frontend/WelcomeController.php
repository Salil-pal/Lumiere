<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('is_active', 1)
            ->latest()->take(4)
            ->get();
        $activeFilter = $request->type ?? 'featured';

        $categories = Category::withCount('products')->get();

        $featuredProducts = Product::where('is_featured', 1)->latest()->take(4)->get();
        $newProducts      = Product::where('is_new_arrival', 1)->latest()->take(4)->get();
        $bestProducts     = Product::where('is_best_selling', 1)->latest()->take(4)->get();
        $saleProducts     = Product::where('is_onsale', 1)->latest()->take(4)->get();

        return view('welcome', compact(
            'products',
            'categories',
            'featuredProducts',
            'newProducts',
            'bestProducts',
            'saleProducts',
            'activeFilter'
        ));
    }
}