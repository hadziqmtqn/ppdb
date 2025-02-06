<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PaymentTransactionController extends Controller
{
    public function index()
    {
        return PaymentTransaction::all();
    }

    public function show(Payment $payment): View
    {
        $payment->load('user.student.educationalInstitution:id,name', 'user:id,name,username', 'paymentTransactions');
        Gate::authorize('view', $payment);

        $title = 'Transaksi Pembayaran';

        return \view('dashboard.payment.payment-transaction.show', compact('title', 'payment'));
    }
}
