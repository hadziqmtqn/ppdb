<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationSchedule\RegistrationScheduleRequest;
use App\Models\RegistrationSchedule;

class RegistrationScheduleController extends Controller
{
    public function index()
    {
        return RegistrationSchedule::all();
    }

    public function store(RegistrationScheduleRequest $request)
    {
        return RegistrationSchedule::create($request->validated());
    }

    public function show(RegistrationSchedule $registrationSchedule)
    {
        return $registrationSchedule;
    }

    public function update(RegistrationScheduleRequest $request, RegistrationSchedule $registrationSchedule)
    {
        $registrationSchedule->update($request->validated());

        return $registrationSchedule;
    }

    public function destroy(RegistrationSchedule $registrationSchedule)
    {
        $registrationSchedule->delete();

        return response()->json();
    }
}
