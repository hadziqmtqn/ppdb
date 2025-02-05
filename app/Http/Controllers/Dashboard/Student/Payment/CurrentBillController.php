<?php

namespace App\Http\Controllers\Dashboard\Student\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Student\Payment\CurrentBillRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CurrentBillController extends Controller
{
    protected CurrentBillRepository $currentBillRepository;

    /**
     * @param CurrentBillRepository $currentBillRepository
     */
    public function __construct(CurrentBillRepository $currentBillRepository)
    {
        $this->currentBillRepository = $currentBillRepository;
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Tagihan Saat Ini';
        $user->load('student.educationalInstitution:id,name', 'student.schoolYear:id,first_year,last_year');
        $totalAmount = $this->currentBillRepository->getRegistrationFee($user)
            ->get()
            ->sum('amount');

        return \view('dashboard.student.payment.current-bill.index', compact('title', 'user', 'totalAmount'));
    }

    public function datatable(Request $request, User $user): JsonResponse
    {
        Gate::authorize('view-student', $user);

        try {
            $user->load('student');

            if ($request->ajax()) {
                $data = $this->currentBillRepository->getRegistrationFee($user);

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
                    ->addColumn('registrationCategory', fn($row) => optional($row->registrationCategory)->name)
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        $btn = '<button href="javascript:void(0)" data-slug="'. $row->slug .'" data-name="'. $row->name .'" data-active="'. $row->is_active .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'is_active'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }
}
