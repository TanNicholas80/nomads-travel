<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TravelPackages;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $req)
    {
        return view('pages.admin.dashboard', [
            'travel_package' => TravelPackages::count(),
            'transaction' => Transaction::count(),
            't_pending' => Transaction::where('transaction_status', 'PENDING')->count(),
            't_success' => Transaction::where('transaction_status', 'SUCCESS')->count()
        ]);
    }
}
