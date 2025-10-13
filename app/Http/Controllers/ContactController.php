<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller {
    public function index()
    {
        $company = 'Hogeschool Rotterdam';

        // Pass variable to the view
        return view('contact-page', compact('company'));
    }
}
