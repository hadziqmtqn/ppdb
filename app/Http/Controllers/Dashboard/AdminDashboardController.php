<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\FilterRequest;
use App\Models\PreviousSchoolReference;
use App\Repositories\Dashboard\AdminDashboardRepository;
use App\Repositories\Student\StudentStatsRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AdminDashboardController extends Controller
{
    use ApiResponse;

    protected AdminDashboardRepository $adminDashboardRepository;
    protected StudentStatsRepository $studentStatsRepository;

    /**
     * @param AdminDashboardRepository $adminDashboardRepository
     * @param StudentStatsRepository $studentStatsRepository
     */
    public function __construct(AdminDashboardRepository $adminDashboardRepository, StudentStatsRepository $studentStatsRepository)
    {
        $this->adminDashboardRepository = $adminDashboardRepository;
        $this->studentStatsRepository = $studentStatsRepository;
    }

    public function index(): View
    {
        $title = 'Dashboard';
        $totalBaseDatas = $this->adminDashboardRepository->totalBaseData();
        $stats = $this->adminDashboardRepository->stats();

        return view('dashboard.admin-dashboard.index', compact('title', 'totalBaseDatas', 'stats'));
    }

    public function studentStats(FilterRequest $request): JsonResponse
    {
        try {
            return $this->apiResponse('Get data successfully.', [
                'totalStudent' => $this->studentStatsRepository->totalStudent($request),
                'registrationReceived' => $this->studentStatsRepository->registrationReceived($request),
                'notYetReceived' => $this->studentStatsRepository->notYetReceived($request),
                'registrationRejected' => $this->studentStatsRepository->registrationRejected($request)
            ], null, Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function previousSchoolReferenceDatatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = PreviousSchoolReference::query()
                    ->with('educationalGroup:id,name');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalGroup', fn($row) => optional($row->educationalGroup)->name)
                    ->addColumn('action', function ($row) {
                        return '<a href="#" class="btn btn-icon btn-sm btn-warning" target="_blank"><i class="mdi mdi-pencil"></i></a>';
                    })
                    ->rawColumns(['is_active', 'action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }
}
