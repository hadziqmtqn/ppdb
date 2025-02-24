<?php

namespace App\Repositories\Student;

use App\Models\EducationalInstitution;
use App\Models\SchoolYear;
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
    protected SchoolYear $schoolYear;
    protected EducationalInstitution $educationalInstitution;

    public function __construct(Student $student, SchoolYear $schoolYear, EducationalInstitution $educationalInstitution)
    {
        $this->student = $student;
        $this->schoolYear = $schoolYear;
        $this->educationalInstitution = $educationalInstitution;
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

    public function totalStudent($request): int
    {
        return $this->student
            ->whereHas('user')
            ->statsFilter($request)
            ->count();
    }

    public function notYetValidated($request): int
    {
        return $this->student
            ->whereHas('user')
            ->statsFilter($request)
            ->registrationValidation('belum_divalidasi')
            ->count();
    }

    public function validated($request): int
    {
        return $this->student
            ->whereHas('user')
            ->statsFilter($request)
            ->registrationValidation('valid')
            ->count();
    }

    public function registrationReceived($request): int
    {
        return $this->student
            ->whereHas('user')
            ->statsFilter($request)
            ->registrationStatus('diterima')
            ->count();
    }

    public function notYetReceived($request): int
    {
        return $this->student
            ->whereHas('user')
            ->statsFilter($request)
            ->registrationStatus('belum_diterima')
            ->count();
    }

    public function registrationRejected($request): int
    {
        return $this->student
            ->whereHas('user')
            ->statsFilter($request)
            ->registrationStatus('ditolak')
            ->count();
    }

    public function totalStudentReceived(): Collection
    {
        // Get the active school year
        $activeYear = $this->schoolYear
            ->where('is_active', true)
            ->first();

        // Get the previous school year based on the active year's id
        $previousYear = $this->schoolYear
            ->where('id', '<', $activeYear->id ?? 0)
            ->orderBy('id', 'desc')
            ->first();

        // Combine the previous year and the active year into a collection
        $result = collect([$previousYear, $activeYear])->filter();

        $colors = ['primary', 'success', 'secondary', 'info', 'danger'];

        // Process the result and return
        return $result->map(function (SchoolYear $schoolYear) use ($colors) {
            return collect([
                'year' => str_replace('20', '', $schoolYear->first_year) . '/' . str_replace('20', '', $schoolYear->last_year),
                'educationalInstitutions' => $this->educationalInstitution->withCount([
                    'students' => fn($query) => $query->where([
                        'school_year_id' => $schoolYear->id,
                        'registration_status' => 'diterima'
                    ])
                ])
                    ->get()
                    ->map(function (EducationalInstitution $educationalInstitution, $index) use ($colors) {
                        return collect([
                            'name' => $educationalInstitution->name,
                            'total' => $educationalInstitution->students_count,
                            'color' => $colors[$index % count($colors)]
                        ]);
                    })
            ]);
        });
    }
}
