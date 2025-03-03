<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\RegistrationFee\RegistrationFeeRequest;
use App\Http\Requests\Payment\RegistrationFee\UpdateRegistrationFeeRequest;
use App\Models\RegistrationFee;
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

class RegistrationFeeController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('registration-fee-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('registration-fee-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('registration-fee-delete'), only: ['destroy'])
        ];
    }

    public function index(): View
    {
        $title = 'Biaya Pendaftaran';
        $subTitle = 'Biaya Pendaftaran';

        return \view('dashboard.payment.registration-fee.index', compact('title', 'subTitle'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = RegistrationFee::query()
                    ->with('educationalInstitution:id,name', 'schoolYear:id,first_year,last_year')
                    ->filterByEducationalInstitution()
                    ->orderByDesc('created_at');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
                    ->addColumn('schoolYear', fn($row) => optional($row->schoolYear)->first_year . '/' . optional($row->schoolYear)->last_year)
                    ->addColumn('type_of_payment', function ($row) {
                        $typeOfPayment = $row->type_of_payment;

                        $badgeColor = match ($typeOfPayment) {
                            'sekali_bayar' => 'text-primary',
                            'kredit' => 'text-warning',
                            default => 'text-secondary',
                        };

                        return '<h6 class="mb-0 w-px-100 '. $badgeColor .'"><i class="mdi mdi-circle mdi-14px me-2"></i>'. ucfirst(str_replace('_', ' ', $typeOfPayment)) .'</h6>';
                    })
                    ->addColumn('registration_status', function ($row) {
                        $registrationStatus = $row->registration_status;

                        $badgeColor = match ($registrationStatus) {
                            'siswa_belum_diterima' => 'text-primary',
                            'siswa_diterima' => 'text-warning',
                            default => 'text-secondary',
                        };

                        return '<h6 class="mb-0 w-px-100 '. $badgeColor .'"><i class="mdi mdi-circle mdi-14px me-2"></i>'. ucfirst(str_replace('_', ' ', $registrationStatus)) .'</h6>';
                    })
                    ->addColumn('amount', fn($row) => 'Rp ' . number_format($row->amount,0,',','.'))
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        $btn = '<button type="button" data-slug="'. $row->slug .'" data-name="'. $row->name .'" data-type-of-payment="'. $row->type_of_payment .'" data-registration-status="'. $row->registration_status .'" data-amount="'. number_format($row->amount) .'" data-active="'. $row->is_active .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        $btn .= '<button type="button" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['is_active', 'type_of_payment', 'registration_status', 'action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(RegistrationFeeRequest $request): JsonResponse
    {
        try {
            $registrationFee = new RegistrationFee();
            $registrationFee->educational_institution_id = $request->input('educational_institution_id');
            $registrationFee->school_year_id = $request->input('school_year_id');
            $registrationFee->type_of_payment = $request->input('type_of_payment');
            $registrationFee->registration_status = $request->input('registration_status');
            $registrationFee->name = $request->input('name');
            $registrationFee->amount = $request->input('amount');
            $registrationFee->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $registrationFee, null, Response::HTTP_OK);
    }

    public function update(UpdateRegistrationFeeRequest $request, RegistrationFee $registrationFee): JsonResponse
    {
        try {
            $registrationFee->type_of_payment = $request->input('type_of_payment');
            $registrationFee->registration_status = $request->input('registration_status');
            $registrationFee->name = $request->input('name');
            $registrationFee->amount = $request->input('amount');
            $registrationFee->is_active = $request->input('is_active');
            $registrationFee->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $registrationFee, null, Response::HTTP_OK);
    }

    public function destroy(RegistrationFee $registrationFee): JsonResponse
    {
        try {
            $registrationFee->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
