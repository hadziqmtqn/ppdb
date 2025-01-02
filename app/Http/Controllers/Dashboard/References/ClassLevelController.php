<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassLevelRequest;
use App\Models\ClassLevel;

class ClassLevelController extends Controller
{
    public function index()
    {
        return ClassLevel::all();
    }

    public function store(ClassLevelRequest $request)
    {
        return ClassLevel::create($request->validated());
    }

    public function show(ClassLevel $classLevel)
    {
        return $classLevel;
    }

    public function update(ClassLevelRequest $request, ClassLevel $classLevel)
    {
        $classLevel->update($request->validated());

        return $classLevel;
    }

    public function destroy(ClassLevel $classLevel)
    {
        $classLevel->delete();

        return response()->json();
    }
}
