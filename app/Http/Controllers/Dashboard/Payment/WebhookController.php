<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Repositories\SendMessage\PaymentCallbackRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

            $payment = Payment::with('user.student.educationalInstitution:id,name')
                ->where('code', $data['external_id'])
                ->first();

            if ($payment) {
                $payment->status = $data['status'];
                $payment->payment_method = !empty($data['payment_method']) ? $data['payment_method'] : null;
                $payment->payment_channel = !empty($data['payment_channel']) ? $data['payment_channel'] : null;
                $payment->paid_at = !empty($data['paid_at']) ? Carbon::parse($data['paid_at'])->timezone('Asia/Jakarta') : null;
                $payment->save();
                $payment->refresh();

                // TODO Send Message
                switch ($payment->status) {
                    case 'PAID':
                        $this->paymentCallbackRepository->success($payment);
                        break;
                    case 'CANCEL':
                        $this->paymentCallbackRepository->cancel($payment);
                        break;
                    default:
                        Log::info('Xendit response: ', $data);
                }

                return $this->apiResponse('Webhook received', $payment->code, null, Response::HTTP_OK);
            }

            Log::warning('Invoice not found: ' . $data['external_id'] . '. All Logs Webhook: ' . json_encode($data));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Invoice not found: ' . $data['external_id'], null, null, Response::HTTP_BAD_REQUEST);
    }
}
