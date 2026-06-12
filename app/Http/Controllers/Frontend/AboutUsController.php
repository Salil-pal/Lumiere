<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

use App\Models\AboutUs;

class AboutUsController extends Controller
{
    public function index()
    {
        $about = AboutUs::first();

        return view('front.about.index', compact('about'));
    }
}
