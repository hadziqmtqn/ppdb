<?php

namespace App\Http\Controllers;

use App\Http\Requests\DistanceToSchool\DistanceToSchoolRequest;
use App\Models\DistanceToSchool;

class DistanceToSchoolController extends Controller
{
    public function index()
    {
        return DistanceToSchool::all();
    }

    public function store(DistanceToSchoolRequest $request)
    {
        return DistanceToSchool::create($request->validated());
    }

    public function show(DistanceToSchool $distanceToSchool)
    {
        return $distanceToSchool;
    }

    public function update(DistanceToSchoolRequest $request, DistanceToSchool $distanceToSchool)
    {
        $distanceToSchool->update($request->validated());

        return $distanceToSchool;
    }

    public function destroy(DistanceToSchool $distanceToSchool)
    {
        $distanceToSchool->delete();

        return response()->json();
    }
}
