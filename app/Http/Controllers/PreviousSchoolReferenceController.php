<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreviousSchoolReferenceRequest;
use App\Models\PreviousSchoolReference;

class PreviousSchoolReferenceController extends Controller
{
    public function index()
    {
        return PreviousSchoolReference::all();
    }

    public function store(PreviousSchoolReferenceRequest $request)
    {
        return PreviousSchoolReference::create($request->validated());
    }

    public function show(PreviousSchoolReference $previousSchoolReference)
    {
        return $previousSchoolReference;
    }

    public function update(PreviousSchoolReferenceRequest $request, PreviousSchoolReference $previousSchoolReference)
    {
        $previousSchoolReference->update($request->validated());

        return $previousSchoolReference;
    }

    public function destroy(PreviousSchoolReference $previousSchoolReference)
    {
        $previousSchoolReference->delete();

        return response()->json();
    }
}
