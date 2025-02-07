<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Repositories\SendMessage\PaymentCallbackRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    use ApiResponse;

    protected PaymentCallbackRepository $paymentCallbackRepository;

    /**
     * @param PaymentCallbackRepository $paymentCallbackRepository
     */
    public function __construct(PaymentCallbackRepository $paymentCallbackRepository)
    {
        $this->paymentCallbackRepository = $paymentCallbackRepository;
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

    private function success()
    {

    }
}
