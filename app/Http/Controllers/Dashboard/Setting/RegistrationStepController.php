<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationStep\RegistrationStepRequest;
use App\Models\RegistrationStep;

class RegistrationStepController extends Controller
{
    public function index()
    {
        return RegistrationStep::all();
    }

    public function store(RegistrationStepRequest $request)
    {
        return RegistrationStep::create($request->validated());
    }

    public function show(RegistrationStep $registrationStep)
    {
        return $registrationStep;
    }

    public function update(RegistrationStepRequest $request, RegistrationStep $registrationStep)
    {
        $registrationStep->update($request->validated());

        return $registrationStep;
    }

    public function destroy(RegistrationStep $registrationStep)
    {
        $registrationStep->delete();

        return response()->json();
    }
}
