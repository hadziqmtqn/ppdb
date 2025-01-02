<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationCategory\RegistrationCategoryRequest;
use App\Models\RegistrationCategory;

class RegistrationCategoryController extends Controller
{
    public function index()
    {
        return RegistrationCategory::all();
    }

    public function store(RegistrationCategoryRequest $request)
    {
        return RegistrationCategory::create($request->validated());
    }

    public function show(RegistrationCategory $registrationCategory)
    {
        return $registrationCategory;
    }

    public function update(RegistrationCategoryRequest $request, RegistrationCategory $registrationCategory)
    {
        $registrationCategory->update($request->validated());

        return $registrationCategory;
    }

    public function destroy(RegistrationCategory $registrationCategory)
    {
        $registrationCategory->delete();

        return response()->json();
    }
}
