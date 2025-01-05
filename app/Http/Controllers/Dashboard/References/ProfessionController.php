<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profession\ProfessionRequest;
use App\Models\Profession;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfessionController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.

        return [
            new Middleware(PermissionMiddleware::using('profession-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('profession-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('profession-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Pekerjaan';

        return \view('dashboard.references.profession.index', compact('title'));
    }

    public function store(ProfessionRequest $request): JsonResponse
    {
        try {
            $profession = new Profession();
            $profession->name = $request->input('name');
            $profession->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $profession, null, Response::HTTP_OK);
    }

    public function show(Profession $profession)
    {
        return $profession;
    }

    public function update(ProfessionRequest $request, Profession $profession)
    {
        $profession->update($request->validated());

        return $profession;
    }

    public function destroy(Profession $profession)
    {
        $profession->delete();

        return response()->json();
    }
}
