<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalDataRequest;
use App\Models\PersonalData;

class PersonalDataController extends Controller
{
    public function index()
    {
        return PersonalData::all();
    }

    public function store(PersonalDataRequest $request)
    {
        return PersonalData::create($request->validated());
    }

    public function show(PersonalData $personalData)
    {
        return $personalData;
    }

    public function update(PersonalDataRequest $request, PersonalData $personalData)
    {
        $personalData->update($request->validated());

        return $personalData;
    }

    public function destroy(PersonalData $personalData)
    {
        $personalData->delete();

        return response()->json();
    }
}
