<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\Income\IncomeRequest;
use App\Models\Income;

class IncomeController extends Controller
{
    public function index()
    {
        return Income::all();
    }

    public function store(IncomeRequest $request)
    {
        return Income::create($request->validated());
    }

    public function show(Income $income)
    {
        return $income;
    }

    public function update(IncomeRequest $request, Income $income)
    {
        $income->update($request->validated());

        return $income;
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return response()->json();
    }
}
