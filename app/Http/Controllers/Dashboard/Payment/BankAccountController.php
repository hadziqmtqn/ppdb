<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\BankAccount\BankAccountRequest;
use App\Models\BankAccount;
use App\Models\PaymentChannel;
use App\Repositories\Payment\BankAccountRepository;
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

    protected BankAccountRepository $bankAccountRepository;

    /**
     * @param BankAccountRepository $bankAccountRepository
     */
    public function __construct(BankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('bank-account-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('bank-account-write'), only: ['update']),
            new Middleware(PermissionMiddleware::using('bank-account-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Pengaturan Pembayaran';
        $paymentChannels = PaymentChannel::active()
            ->select(['id', 'name'])
            ->get();

        return \view('dashboard.payment.bank-account.index', compact('title', 'paymentChannels'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = BankAccount::query()
                    ->with('educationalInstitution:id,name', 'paymentChannel:id,name')
                    ->filterByEducationalInstitution()
                    ->orderByDesc('created_at');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['account_name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
                    ->addColumn('paymentChannel', fn($row) => optional($row->paymentChannel)->name)
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        $btn = '<button href="javascript:void(0)" data-slug="'. $row->slug .'" data-account-name="'. $row->account_name .'" data-account-number="'. $row->account_number .'" data-payment-channel-id="'. $row->payment_channel_id .'" data-educational-institution="'. $row->educational_institution_id .'" data-active="'. $row->is_active .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['is_active', 'action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(BankAccountRequest $request): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $bankAccount = new BankAccount();
            $bankAccount->educational_institution_id = $request->input('educational_institution_id');
            $bankAccount->payment_channel_id = $request->input('payment_channel_id');
            $bankAccount->account_name = $request->input('account_name');
            $bankAccount->account_number = $request->input('account_number');
            $bankAccount->is_active = $request->input('is_active');
            $bankAccount->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $bankAccount, null, Response::HTTP_OK);
    }

    public function update(BankAccountRequest $request, BankAccount $bankAccount): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $bankAccount->payment_channel_id = $request->input('payment_channel_id');
            $bankAccount->account_name = $request->input('account_name');
            $bankAccount->account_number = $request->input('account_number');
            $bankAccount->is_active = $request->input('is_active');
            $bankAccount->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $bankAccount, null, Response::HTTP_OK);
    }

    public function destroy(BankAccount $bankAccount): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $bankAccount->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $bankAccount, null, Response::HTTP_OK);
    }

    // TODO Select
    public function select(Request $request)
    {
        return $this->bankAccountRepository->getByEducationalInstitutions($request);
    }
}
