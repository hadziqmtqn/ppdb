<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentChannel;
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

class PaymentChannelController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('payment-channel-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('payment-channel-write'), only: ['update']),
        ];
    }

    public function index(): View
    {
        $title = 'Saluran Pembayaran';

        return \view('dashboard.payment.payment-channel.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = PaymentChannel::query();

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

    public function update(PaymentChannel $paymentChannel): JsonResponse
    {
        try {
            $paymentChannel->is_active = !$paymentChannel->is_active;
            $paymentChannel->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $paymentChannel, null, Response::HTTP_OK);
    }
}
