<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentSetting\PaymentSettingRequest;
use App\Models\PaymentSetting;
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

class PaymentSettingController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('payment-setting-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('payment-setting-write'), only: ['store', 'update'])
        ];
    }

    public function index(): View
    {
        $title = 'Pengaturan Pembayaran';

        return \view('dashboard.payment.payment-setting.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = PaymentSetting::query()
                    ->with('educationalInstitution:id,name');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['payment_method'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
                    ->addColumn('payment_method', fn($row) => str_replace('_', ' ', $row->payment_method))
                    ->addColumn('action', function ($row) {
                        return '<button href="javascript:void(0)" data-slug="'. $row->slug .'" data-educational-institution="'. $row->educational_institution_id .'" data-payment-method="'. $row->payment_method .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(PaymentSettingRequest $request): JsonResponse
    {
        try {
            $paymentSetting = PaymentSetting::educationalInstitutionId($request->input('educational_institution_id'))
                ->firstOrFail();
            $paymentSetting->educational_institution_id = $request->input('educational_institution_id');
            $paymentSetting->payment_method = $request->input('payment_method');
            $paymentSetting->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    public function update(PaymentSettingRequest $request, PaymentSetting $paymentSetting): JsonResponse
    {
        try {
            $paymentSetting->payment_method = $request->input('payment_method');
            $paymentSetting->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }
}
