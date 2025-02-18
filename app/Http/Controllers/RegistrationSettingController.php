<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationSetting\RegistrationSettingRequest;
use App\Models\RegistrationSetting;

class RegistrationSettingController extends Controller
{
    public function index()
    {
        return RegistrationSetting::all();
    }

    public function store(RegistrationSettingRequest $request)
    {
        return RegistrationSetting::create($request->validated());
    }

    public function show(RegistrationSetting $registrationSetting)
    {
        return $registrationSetting;
    }

    public function update(RegistrationSettingRequest $request, RegistrationSetting $registrationSetting)
    {
        $registrationSetting->update($request->validated());

        return $registrationSetting;
    }

    public function destroy(RegistrationSetting $registrationSetting)
    {
        $registrationSetting->delete();

        return response()->json();
    }
}
