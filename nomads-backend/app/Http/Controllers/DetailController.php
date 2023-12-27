<?php

namespace App\Http\Controllers;

use App\Models\TravelPackages;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Request $req, $slug) {
        $item = TravelPackages::with(['gallery'])->where('slug', $slug)->firstOrFail();
        return view('pages.detail', [
            'item' => $item
        ]);
    }
}
