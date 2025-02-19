<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationalGroup\EducationalGroupRequest;
use App\Models\EducationalGroup;

class EducationalGroupController extends Controller
{
    public function index()
    {
        return EducationalGroup::all();
    }

    public function store(EducationalGroupRequest $request)
    {
        return EducationalGroup::create($request->validated());
    }

    public function show(EducationalGroup $educationalGroup)
    {
        return $educationalGroup;
    }

    public function update(EducationalGroupRequest $request, EducationalGroup $educationalGroup)
    {
        $educationalGroup->update($request->validated());

        return $educationalGroup;
    }

    public function destroy(EducationalGroup $educationalGroup)
    {
        $educationalGroup->delete();

        return response()->json();
    }
}
