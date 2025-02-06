<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PaymentTransactionController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return PaymentTransaction::all();
    }

    public function show(Payment $payment): View
    {
        $payment->load([
            'user.student.educationalInstitution:id,name',
            'user:id,name,username',
            'paymentTransactions.registrationFee:id,name,type_of_payment',
            'bankAccount.paymentChannel'
        ]);
        Gate::authorize('view', $payment);

        $title = 'Transaksi Pembayaran';

        return \view('dashboard.payment.payment-transaction.show', compact('title', 'payment'));
    }

    public function checkPayment(Payment $payment): JsonResponse
    {
        Gate::authorize('view', $payment);

        try {
            return $this->apiResponse('Get data success', [
                'status' => $payment->status,
                'paymentMethod' => $payment->payment_method ? str_replace('_', ' ', $payment->payment_method) : null,
                'paymentChannel' => $payment->payment_channel
            ], null, Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
