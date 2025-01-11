<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\Education\EducationRequest;
use App\Models\Education;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;

class EducationController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('education-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('education-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('education-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Pendidikan';

        return \view('dashboard.references.education.index', compact('title'));
    }

    public function store(EducationRequest $request): JsonResponse
    {
        return Education::create($request->validated());
    }

    public function show(Education $education)
    {
        return $education;
    }

    public function update(EducationRequest $request, Education $education)
    {
        $education->update($request->validated());

        return $education;
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return response()->json();
    }
}
