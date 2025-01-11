<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationRequest;
use App\Models\Education;

class EducationController extends Controller
{
    public function index()
    {
        return Education::all();
    }

    public function store(EducationRequest $request)
    {
        return Education::create($request->validated());
    }

    public function show(Education $education)
    {
        return $education;
    }

    public function update(EducationRequest $request, Education $education)
    {
        $education->update($request->validated());

        return $education;
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return response()->json();
    }
}
