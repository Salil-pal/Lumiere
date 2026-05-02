<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;

class AboutUsController extends Controller
{
    public function index()
    {
        $about = AboutUs::first();

        return view('front.about.index', compact('about'));
    }
}
