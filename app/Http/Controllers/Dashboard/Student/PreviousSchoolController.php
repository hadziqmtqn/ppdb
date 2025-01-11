<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreviousSchool\PreviousSchoolRequest;
use App\Models\PreviousSchool;

class PreviousSchoolController extends Controller
{
    public function index()
    {
        return PreviousSchool::all();
    }

    public function store(PreviousSchoolRequest $request)
    {
        return PreviousSchool::create($request->validated());
    }

    public function show(PreviousSchool $previousSchool)
    {
        return $previousSchool;
    }

    public function update(PreviousSchoolRequest $request, PreviousSchool $previousSchool)
    {
        $previousSchool->update($request->validated());

        return $previousSchool;
    }

    public function destroy(PreviousSchool $previousSchool)
    {
        $previousSchool->delete();

        return response()->json();
    }
}
