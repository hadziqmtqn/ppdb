<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BankAccountController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('bank-account-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('bank-account-write'), only: ['update']),
        ];
    }

    public function index(): View
    {
        $title = 'Rekening Bank';

        return \view('dashboard.payment.bank-account.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = BankAccount::query();

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('is_active', function ($row) {
                        return '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="is-active btn btn-sm '. ($row->is_active ? 'btn-primary' : 'btn-danger').'"><i class="mdi mdi-pencil"></i></button>';
                    })
                    ->rawColumns(['is_active'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function update(BankAccount $bankAccount): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $bankAccount->is_active = !$bankAccount->is_active;
            $bankAccount->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $bankAccount, null, Response::HTTP_OK);
    }
}
