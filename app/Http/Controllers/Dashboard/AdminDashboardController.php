<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\FilterRequest;
use App\Repositories\Dashboard\AdminDashboardRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Repositories\Student\StudentStatsRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AdminDashboardController extends Controller
{
    use ApiResponse;

    protected AdminDashboardRepository $adminDashboardRepository;
    protected StudentStatsRepository $studentStatsRepository;
    protected StudentRegistrationRepository $studentRegistrationRepository;

    /**
     * @param AdminDashboardRepository $adminDashboardRepository
     * @param StudentStatsRepository $studentStatsRepository
     * @param StudentRegistrationRepository $studentRegistrationRepository
     */
    public function __construct(AdminDashboardRepository $adminDashboardRepository, StudentStatsRepository $studentStatsRepository, StudentRegistrationRepository $studentRegistrationRepository)
    {
        $this->adminDashboardRepository = $adminDashboardRepository;
        $this->studentStatsRepository = $studentStatsRepository;
        $this->studentRegistrationRepository = $studentRegistrationRepository;
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

    public function totalStudentByDataCompleteness(FilterRequest $request): JsonResponse
    {
        try {
            $totalStudent = $this->studentStatsRepository->totalStudent($request);

            return $this->apiResponse('Get data successfully.', [
                'totalStudent' => $totalStudent,
                'completedData' => $this->studentRegistrationRepository->countCompletedUsers($request),
            ], null, Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function previousSchoolReferenceDatatable(Request $request)
    {
        return $this->adminDashboardRepository->previousSchoolReferenceDatatable($request);
    }

    public function totalStudentReceived(): JsonResponse
    {
        try {
            return $this->apiResponse('Get data successfully.', $this->studentStatsRepository->totalStudentReceived(), null, Response::HTTP_OK);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
