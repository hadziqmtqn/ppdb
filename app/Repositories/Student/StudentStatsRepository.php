<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentStatsRepository
{
    use ApiResponse;

    protected Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    // TODO Stats
    public function stats(): Collection
    {
        return collect([
            'Total Siswa' => [
                'total' => 0,
                'icon' => 'account-multiple-outline',
                'id' => 'totalStudents'
            ],
            'Belum divalidasi' => [
                'total' => 0,
                'icon' => 'progress-alert',
                'id' => 'notYetValidated'
            ],
            'Data Valid' => [
                'total' => 0,
                'icon' => 'check-decagram-outline',
                'id' => 'validated'
            ],
            'Pendaftaran Diterima' => [
                'total' => 0,
                'icon' => 'check-all',
                'id' => 'registrationReceived'
            ],
            'Belum Diterima' => [
                'total' => 0,
                'icon' => 'wallet-outline',
                'id' => 'notYetReceived'
            ],
            'Registrasi Ditolak' => [
                'total' => 0,
                'icon' => 'alert-octagon-outline',
                'id' => 'registrationRejected'
            ]
        ]);
    }

    // TODO Total Stats
    public function total($request): JsonResponse
    {
        try {
            return $this->apiResponse('Get data success', [
                'totalStudents' => $this->totalStudent($request),
                'notYetValidated' => $this->notYetValidated($request),
                'validated' => $this->validated($request),
                'registrationReceived' => $this->registrationReceived($request),
                'notYetReceived' => $this->notYetReceived($request),
                'registrationRejected' => $this->registrationRejected($request)
            ], null, Response::HTTP_OK);
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function totalStudent($request): int
    {
        return $this->student
            ->statsFilter($request)
            ->count();
    }

    private function notYetValidated($request): int
    {
        return $this->student
            ->statsFilter($request)
            ->registrationValidation('belum_divalidasi')
            ->count();
    }

    private function validated($request): int
    {
        return $this->student
            ->statsFilter($request)
            ->registrationValidation('valid')
            ->count();
    }

    private function registrationReceived($request): int
    {
        return $this->student
            ->statsFilter($request)
            ->registrationStatus('diterima')
            ->count();
    }

    private function notYetReceived($request): int
    {
        return $this->student
            ->statsFilter($request)
            ->registrationStatus('belum_diterima')
            ->count();
    }

    private function registrationRejected($request): int
    {
        return $this->student
            ->statsFilter($request)
            ->registrationStatus('ditolak')
            ->count();
    }
}
