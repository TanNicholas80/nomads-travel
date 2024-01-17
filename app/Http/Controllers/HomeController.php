<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelPackages;

class HomeController extends Controller
{
    public function index(Request $req)
    {
        $items = TravelPackages::with(['gallery'])->get();
        return view('pages.home', [
            'items' => $items
        ]);
    }
}
