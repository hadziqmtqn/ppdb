<?php

namespace App\Repositories\Payment;

use App\Models\BankAccount;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BankAccountRepository
{
    use ApiResponse;

    protected BankAccount $bankAccount;

    public function __construct(BankAccount $bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    public function getByEducationalInstitutions($request): JsonResponse
    {
        try {
            $bankAccounts = $this->bankAccount
                ->with('paymentChannel:id,name,code')
                ->educationalInstitutionId($request['educational_institution_id'])
                ->active()
                ->search($request)
                ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $bankAccounts->map(function (BankAccount $bankAccount) {
            return [
                'id' => $bankAccount->id,
                'paymentChannel' => optional($bankAccount->paymentChannel)->code,
                'accountName' => $bankAccount->account_name,
                'accountNumber' => $bankAccount->account_number
            ];
        }), null, Response::HTTP_OK);
    }
}
