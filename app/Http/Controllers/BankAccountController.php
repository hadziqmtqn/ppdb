<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankAccount\BankAccountRequest;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    public function index()
    {
        return BankAccount::all();
    }

    public function store(BankAccountRequest $request)
    {
        return BankAccount::create($request->validated());
    }

    public function show(BankAccount $bankAccount)
    {
        return $bankAccount;
    }

    public function update(BankAccountRequest $request, BankAccount $bankAccount)
    {
        $bankAccount->update($request->validated());

        return $bankAccount;
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return response()->json();
    }
}
