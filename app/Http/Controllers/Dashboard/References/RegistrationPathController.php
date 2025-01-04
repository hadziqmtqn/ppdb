<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationPath\RegistrationPathRequest;
use App\Models\RegistrationPath;

class RegistrationPathController extends Controller
{
    public function index()
    {
        return RegistrationPath::all();
    }

    public function store(RegistrationPathRequest $request)
    {
        return RegistrationPath::create($request->validated());
    }

    public function show(RegistrationPath $registrationPath)
    {
        return $registrationPath;
    }

    public function update(RegistrationPathRequest $request, RegistrationPath $registrationPath)
    {
        $registrationPath->update($request->validated());

        return $registrationPath;
    }

    public function destroy(RegistrationPath $registrationPath)
    {
        $registrationPath->delete();

        return response()->json();
    }
}
