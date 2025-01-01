<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolYear\SchoolYearRequest;
use App\Models\SchoolYear;

class SchoolYearController extends Controller
{
    public function index()
    {
        return SchoolYear::all();
    }

    public function store(SchoolYearRequest $request)
    {
        return SchoolYear::create($request->validated());
    }

    public function show(SchoolYear $schoolYear)
    {
        return $schoolYear;
    }

    public function update(SchoolYearRequest $request, SchoolYear $schoolYear)
    {
        $schoolYear->update($request->validated());

        return $schoolYear;
    }

    public function destroy(SchoolYear $schoolYear)
    {
        $schoolYear->delete();

        return response()->json();
    }
}
