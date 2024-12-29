<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationalLevelRequest;
use App\Models\EducationalLevel;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class EducationalLevelController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // TODO: Implement middleware() method.

        return [
            new Middleware(PermissionMiddleware::using('educational-level-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('educational-level-write'), only: ['update']),
        ];
    }

    public function index()
    {
        return EducationalLevel::all();
    }

    public function store(EducationalLevelRequest $request)
    {
        return EducationalLevel::create($request->validated());
    }

    public function show(EducationalLevel $educationalLevel)
    {
        return $educationalLevel;
    }

    public function update(EducationalLevelRequest $request, EducationalLevel $educationalLevel)
    {
        $educationalLevel->update($request->validated());

        return $educationalLevel;
    }

    public function destroy(EducationalLevel $educationalLevel)
    {
        $educationalLevel->delete();

        return response()->json();
    }
}
