<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentTransaction\PaymentRequest;
use App\Models\Payment;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentController extends Controller
{
    use ApiResponse;

    public function store(PaymentRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        dd($request->all());
    }
}
