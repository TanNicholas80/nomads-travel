<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TrasactionDetail;
use App\Models\TravelPackages;
use Exception;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index(Request $req, $id) {
        $item = Transaction::with(['details', 'travel_package', 'user'])->findOrFail($id);

        return view('pages.checkouts', [
            'item' => $item,
        ]);
    }

    public function process(Request $req, $id) {
        $travel_package = TravelPackages::findOrFail($id);

        $transaction = Transaction::create([
            'travel_packages_id' => $id,
            'users_id' => Auth::user()->id,
            'additional_visa' => 0,
            'transaction_total' => $travel_package->price,
            'transaction_status' => 'IN_CART',
        ]);

        TrasactionDetail::create([
            'transactions_id' => $transaction->id,
            'username' => Auth::user()->username,
            'nationality' => 'ID',
            'is_visa' => false,
            'doe_passport' => Carbon::now()->addYears(5)
        ]);

        return redirect()->route('checkout', $transaction->id);
    }

    public function create(Request $req, $id) {
        $req->validate([
            'username' => 'required|string|exists:users,username',
            'is_visa' => 'required|boolean',
            'doe_passport' => 'required'
        ]);

        $data = $req->all();
        $data['transactions_id'] = $id;

        TrasactionDetail::create($data);

        $transaction = Transaction::with(['travel_package'])->find($id);

        if($req->is_visa) {
            $transaction->transaction_total += 190;
            $transaction->additional_visa += 190;
        }

        $transaction->transaction_total += $transaction->travel_package->price;

        $transaction->save();

        return redirect()->route('checkout', $id);
    }

    public function remove(Request $req, $detailId) {
        $item = TrasactionDetail::findOrFail($detailId);

        $transaction = Transaction::with(['details', 'travel_package'])->findOrFail($item->transactions_id);

        if($item->is_visa) {
            $transaction->transaction_total -= 190;
            $transaction->additional_visa -= 190;
        }

        $transaction->transaction_total -= $transaction->travel_package->price;
        $transaction->save();
        $item->delete();

        return redirect()->route('checkout', $item->transactions_id);
    }

    public function success(Request $req, $id) {
        $transaction = Transaction::findOrFail($id);
        $transaction->transaction_status = 'PENDING';

        $transaction->save();

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        $midtrans_params = [
            'transaction_detail' => [
                'order_id' => 'MIDTRANS-' . $transaction->id,
                'gross_amount' => (int) $transaction->transaction_total
            ],
            'customer_detail' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
            'enabled_payments' => ['gopay'],
            'vtweb' => [] 
        ];

        try {
            $payment_url = Snap::createTransaction($midtrans_params)->redirect_url;
            // Redirect Pembayaran
            header('Location: ' . $payment_url);

        } catch(Exception $e) {
            echo $e->getMessage();
        }

        return view('pages.success_checkout');
    }
}
