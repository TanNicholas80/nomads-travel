<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $req) {
        return view('pages.checkouts');
    }

    public function success(Request $req) {
        return view('pages.success_checkout');
    }
}
