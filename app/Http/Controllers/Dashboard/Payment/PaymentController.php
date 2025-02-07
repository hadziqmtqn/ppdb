<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentTransaction\PaymentRequest;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\RegistrationFee;
use App\Models\User;
use App\Repositories\SendMessage\PaymentBillRepository;
use App\Services\XenditService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Xendit\XenditSdkException;

class PaymentController extends Controller
{
    use ApiResponse;

    protected XenditService $xenditService;
    protected PaymentBillRepository $paymentBillRepository;

    /**
     * @param XenditService $xenditService
     * @param PaymentBillRepository $paymentBillRepository
     */
    public function __construct(XenditService $xenditService, PaymentBillRepository $paymentBillRepository)
    {
        $this->xenditService = $xenditService;
        $this->paymentBillRepository = $paymentBillRepository;
    }

    public function store(PaymentRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('student.educationalInstitution');

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

            if ($request->input('pay_method') == 'PAYMENT_GATEWAY') {
                $this->updateWithXendit($payment, $amount);
            } else {
                $this->updateWithManual($payment, $amount);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Tagihan gagal dibuat!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Tagihan berhasil dibuat', null, route('payment-transaction.show', $payment->slug), Response::HTTP_OK);
    }

    /**
     * @throws XenditSdkException
     */
    private function updateWithXendit(Payment $payment, $amount)
    {
        $payment->load('user.student.educationalInstitution');

        $generateInvoice = $this->xenditService->createInvoice([
            'paymentCode' => $payment->code,
            'amount' => $amount,
            'payerEmail' => optional($payment->user)->email,
            'description' => 'Pembayaran registrasi siswa baru a/n ' . optional($payment->user)->name,
        ]);

        $expiryDate = Carbon::parse($generateInvoice['expiry_date'])
            ->timezone('Asia/Jakarta');

        $payment->checkout_link = $generateInvoice['invoice_url'];
        $payment->status = $generateInvoice['status'];
        $payment->amount = $amount;
        $payment->expires_at = $expiryDate;
        $payment->save();
    }

    private function updateWithManual(Payment $payment, $amount)
    {
        $payment->load('user.student.educationalInstitution');

        $expiryDate = Carbon::now()->addDay();
        $payment->payment_method = request()->input('pay_method');
        $payment->bank_account_id = request()->input('bank_account_id');
        $payment->amount = $amount;
        $payment->expires_at = $expiryDate;
        $payment->save();

        // TODO Send Notification
        $this->sendNotification([
            'name' => optional($payment->user)->name,
            'educationalInstitution' => optional(optional(optional($payment->user)->student)->educationalInstitution)->name,
            'invoiceNumber' => $payment->code,
            'paymentDeadline' => Carbon::parse($expiryDate)->isoFormat('DD MMM Y H:i'),
            'paymentInstruction' => "\n\n-Transafer ke Bank: "
        ]);
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            $payment = Payment::where('code', $data['external_id'])
                ->firstOrFail();
            $payment->status = $data['status'];
            $payment->payment_method = $data['payment_method'];
            $payment->payment_channel = $data['payment_channel'];
            $payment->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Webhook received', $payment->code, null, Response::HTTP_OK);
    }

    private function sendNotification(array $data)
    {
        $this->paymentBillRepository->sendMessage($data);
    }
}
