<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class PaymentTransactionController extends Controller
{
    public function index()
    {
        return PaymentTransaction::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => ['required'],
            'user_id' => ['required', 'integer'],
            'registration_fee_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'paid_amount' => ['required', 'numeric'],
            'paid_rest' => ['required', 'numeric'],
        ]);

        return PaymentTransaction::create($data);
    }

    public function show(PaymentTransaction $paymentTransaction)
    {
        return $paymentTransaction;
    }

    public function update(Request $request, PaymentTransaction $paymentTransaction)
    {
        $data = $request->validate([
            'slug' => ['required'],
            'user_id' => ['required', 'integer'],
            'registration_fee_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'paid_amount' => ['required', 'numeric'],
            'paid_rest' => ['required', 'numeric'],
        ]);

        $paymentTransaction->update($data);

        return $paymentTransaction;
    }

    public function destroy(PaymentTransaction $paymentTransaction)
    {
        $paymentTransaction->delete();

        return response()->json();
    }
}
