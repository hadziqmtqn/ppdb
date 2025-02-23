<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\Income\IncomeRequest;
use App\Models\Income;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class IncomeController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('income-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('income-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('income-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Penghasilan';

        return \view('dashboard.references.income.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Income::query()
                    ->withCount('fatherIncomes', 'motherIncomes', 'guardianIncomes')
                    ->orderBy('id');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['nominal'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<button type="button" data-slug="'. $row->slug .'" data-nominal="'. $row->nominal .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        if (($row->father_incomes_count == 0) && ($row->mother_incomes_count == 0) && ($row->guardian_incomes_count == 0)) {
                            $btn .= '<button type="button" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(IncomeRequest $request): JsonResponse
    {
        try {
            $income = new Income();
            $income->nominal = $request->input('nominal');
            $income->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $income, null, Response::HTTP_OK);
    }

    public function update(IncomeRequest $request, Income $income): JsonResponse
    {
        try {
            $income->nominal = $request->input('nominal');
            $income->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $income, null, Response::HTTP_OK);
    }

    public function destroy(Income $income): JsonResponse
    {
        try {
            $income->load('fatherIncomes', 'motherIncomes', 'guardianIncomes');

            if ($income->fatherIncomes->isNotEmpty() || $income->motherIncomes->isNotEmpty() || $income->guardianIncomes->isNotEmpty()) {
                return $this->apiResponse('Data tidak bisa dihapus!', null, null, Response::HTTP_BAD_REQUEST);
            }

            $income->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
