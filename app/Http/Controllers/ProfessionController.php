<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfessionRequest;
use App\Models\Profession;

class ProfessionController extends Controller
{
    public function index()
    {
        return Profession::all();
    }

    public function store(ProfessionRequest $request)
    {
        return Profession::create($request->validated());
    }

    public function show(Profession $profession)
    {
        return $profession;
    }

    public function update(ProfessionRequest $request, Profession $profession)
    {
        $profession->update($request->validated());

        return $profession;
    }

    public function destroy(Profession $profession)
    {
        $profession->delete();

        return response()->json();
    }
}
