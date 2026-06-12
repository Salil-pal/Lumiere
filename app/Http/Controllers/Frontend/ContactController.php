<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first();
        return view('front.contact.index', compact('contact'));
    }
}
