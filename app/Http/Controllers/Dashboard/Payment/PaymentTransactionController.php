<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentConfirmationRequest;
use App\Http\Requests\Payment\PaymentTransaction\PaymentValidationRequest;
use App\Models\Payment;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PaymentTransactionController extends Controller
{
    use ApiResponse;

    public function index(): View
    {
        $title = 'Transaksi Pembayaran';

        return \view('dashboard.payment.payment-transaction.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Payment::query()
                    ->with([
                        'user:id,name',
                        'user.student:id,user_id,educational_institution_id',
                        'user.student.educationalInstitution:id,name'
                    ])
                    ->whereHas('user', fn($query) => $query->whereNull('deleted_at'))
                    ->filterByEducationalInstitution();

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');
                        $status = $request->get('status');
                        $educationalInstitutionId = $request->get('educational_institution_id');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereHas('user', function ($query) use ($search) {
                                $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                            });
                        })
                            ->when($status, function ($query) use ($status) {
                                $query->whereIn('status', $status);
                            })
                            ->when($educationalInstitutionId, function ($query) use ($educationalInstitutionId) {
                                $query->whereHas('user.student', function ($query) use ($educationalInstitutionId) {
                                    $query->where('educational_institution_id', $educationalInstitutionId);
                                });
                            });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional(optional(optional($row->user)->student)->educationalInstitution)->name)
                    ->addColumn('user', fn($row) => optional($row->user)->name)
                    ->addColumn('amount', fn($row) => 'Rp. ' . number_format($row->amount,0,',','.'))
                    ->addColumn('created_at', fn($row) => Carbon::parse($row->created_at)->isoFormat('DD MMM Y'))
                    ->addColumn('status', function ($row) {
                        $status = $row->status;

                        $badgeColor = match ($status) {
                            'PENDING' => 'bg-label-warning',
                            'PAID' => 'bg-label-primary',
                            'CANCEL' => 'bg-label-danger',
                            default => 'bg-label-secondary',
                        };

                        return '<span class="badge rounded-pill '. $badgeColor .'">'. str_replace('_', ' ', $status) .'</span>';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="'. route('payment-transaction.show', $row->slug) .'" class="btn btn-icon btn-sm btn-primary"><i class="mdi mdi-eye"></i></a> ';
                        if (!auth()->user()->hasRole('user') && ($row->status != 'PAID')) {
                            $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function show(Payment $payment): View
    {
        $payment->load([
            'user.student.educationalInstitution:id,name',
            'user:id,name,username',
            'paymentTransactions.registrationFee:id,name,type_of_payment',
            'bankAccount.paymentChannel'
        ]);
        Gate::authorize('view', $payment);

        $title = 'Transaksi Pembayaran';

        return \view('dashboard.payment.payment-transaction.show', compact('title', 'payment'));
    }

    public function confirm(PaymentConfirmationRequest $request, Payment $payment)
    {
        Gate::authorize('store', $payment);

        if ($payment->status == 'PAID') return redirect()->back()->with('warning', 'Tidak bisa diubah, jika sudah valid.');

        try {
            DB::beginTransaction();
            $payment->status = 'PROSES_VALIDASI';
            $payment->save();

            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                if ($payment->hasMedia('proof_of_payment')) {
                    $payment->clearMediaCollection('proof_of_payment');
                }

                $payment->addMediaFromRequest('file')
                    ->toMediaCollection('proof_of_payment');
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function paymentValidation(PaymentValidationRequest $request, Payment $payment): JsonResponse
    {
        Gate::authorize('validation', $payment);

        try {
            $payment->status = $request->input('status');
            $payment->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Update data success', null, route('payment-transaction.show', $payment->slug), Response::HTTP_OK);
    }

    public function checkPayment(Payment $payment): JsonResponse
    {
        Gate::authorize('view', $payment);

        try {
            return $this->apiResponse('Get data success', [
                'status' => str_replace('_', ' ', $payment->status),
                'paymentMethod' => $payment->payment_method ? str_replace('_', ' ', $payment->payment_method) : null,
                'paymentChannel' => $payment->payment_method == 'MANUAL_PAYMENT' ? optional(optional($payment->bankAccount)->paymentChannel)->code : $payment->payment_channel
            ], null, Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Payment $payment): JsonResponse
    {
        Gate::authorize('destroy', $payment);

        try {
            if ($payment->hasMedia('proof_of_payment')) {
                $payment->clearMediaCollection('proof_of_payment');
            }

            $payment->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Delete data success', null, null, Response::HTTP_OK);
    }
}
