<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationalInstitutionRequest;
use App\Models\EducationalInstitution;

class EducationalInstitutionController extends Controller
{
    public function index()
    {
        return EducationalInstitution::all();
    }

    public function store(EducationalInstitutionRequest $request)
    {
        return EducationalInstitution::create($request->validated());
    }

    public function show(EducationalInstitution $educationalInstitution)
    {
        return $educationalInstitution;
    }

    public function update(EducationalInstitutionRequest $request, EducationalInstitution $educationalInstitution)
    {
        $educationalInstitution->update($request->validated());

        return $educationalInstitution;
    }

    public function destroy(EducationalInstitution $educationalInstitution)
    {
        $educationalInstitution->delete();

        return response()->json();
    }
}
