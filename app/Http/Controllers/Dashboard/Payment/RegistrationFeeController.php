<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\RegistrationFee\RegistrationFeeRequest;
use App\Models\RegistrationFee;

class RegistrationFeeController extends Controller
{
    public function index()
    {
        return RegistrationFee::all();
    }

    public function store(RegistrationFeeRequest $request)
    {
        return RegistrationFee::create($request->validated());
    }

    public function show(RegistrationFee $registrationFee)
    {
        return $registrationFee;
    }

    public function update(RegistrationFeeRequest $request, RegistrationFee $registrationFee)
    {
        $registrationFee->update($request->validated());

        return $registrationFee;
    }

    public function destroy(RegistrationFee $registrationFee)
    {
        $registrationFee->delete();

        return response()->json();
    }
}
