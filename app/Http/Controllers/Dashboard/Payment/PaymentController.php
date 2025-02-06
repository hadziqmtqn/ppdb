<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentTransaction\PaymentRequest;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\RegistrationFee;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class PaymentController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        Configuration::setXenditKey(config('xendit.api_key'));
    }

    public function store(PaymentRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $registrationFeeIds = $request->input('registration_fee_id', []);
            $paidAmounts = $request->input('paid_amount', []);

            DB::beginTransaction();
            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->payment_method = $request->input('pay_method') == 'MANUAL_PAYMENT' ? $request->input('pay_method') : null;
            $payment->save();

            $totalNominal = [];
            foreach ($registrationFeeIds as $id => $registrationFeeId) {
                $registrationFee = RegistrationFee::findOrFail($registrationFeeId);

                $paidAmount = $paidAmounts[$id];

                $paymentTransaction = new PaymentTransaction();
                $paymentTransaction->payment_id = $payment->id;
                $paymentTransaction->registration_fee_id = $registrationFee->id;
                $paymentTransaction->amount = $registrationFee->amount;
                $paymentTransaction->paid_amount = $paidAmount;
                $paymentTransaction->paid_rest = $registrationFee->amount - $paidAmount;
                $paymentTransaction->save();

                $totalNominal[] = $paidAmount;
            }

            $amount = array_sum($totalNominal);

            $createInvoice = new CreateInvoiceRequest([
                'external_id' => $payment->code,
                'amount' => $amount,
                'payer_email' => $user->email,
                'description' => 'Pembayaran registrasi siswa baru',
                'invoice_duration' => 172800,
            ]);

            $apiInstance = new InvoiceApi();
            $generateInvoice = $apiInstance->createInvoice($createInvoice);

            $payment->checkout_link = $generateInvoice['invoice_url'];
            $payment->amount = $amount;
            $payment->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Create invoice success', [
            'checkout_link' => $payment->checkout_link,
        ], null, Response::HTTP_OK);
    }
}
