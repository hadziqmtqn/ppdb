<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyRequest;
use App\Models\Family;

class FamilyController extends Controller
{
    public function index()
    {
        return Family::all();
    }

    public function store(FamilyRequest $request)
    {
        return Family::create($request->validated());
    }

    public function show(Family $family)
    {
        return $family;
    }

    public function update(FamilyRequest $request, Family $family)
    {
        $family->update($request->validated());

        return $family;
    }

    public function destroy(Family $family)
    {
        $family->delete();

        return response()->json();
    }
}
