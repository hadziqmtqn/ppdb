<?php

namespace App\Repositories;

use App\Models\EducationalInstitution;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EducationalInstitutionRepository
{
    use ApiResponse;

    protected EducationalInstitution $educationalInstitution;

    public function __construct(EducationalInstitution $educationalInstitution)
    {
        $this->educationalInstitution = $educationalInstitution;
    }

    public function select($request): JsonResponse
    {
        try {
            $educationalInstitutions = $this->educationalInstitution
                ->when($request['search'], function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request['search'] . '%');
                })
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $educationalInstitutions->map(function (EducationalInstitution $educationalInstitution) {
            return collect([
                'id' => $educationalInstitution->id,
                'name' => $educationalInstitution->name
            ]);
        }), null, Response::HTTP_OK);
    }

    public function getEducationalInstitutionWithSchedule(): Collection
    {
        return $this->educationalInstitution->with('registrationScheduleActive', 'educationalLevel:id,name,code', 'majors')
            ->whereHas('registrationScheduleActive')
            ->active()
            ->orderBy('educational_level_id')
            ->get()
            ->map(function (EducationalInstitution $educationalInstitution) {
                $startDate = date('Y-m-d', strtotime(optional($educationalInstitution->registrationScheduleActive)->start_date));
                $endDate = date('Y-m-d', strtotime(optional($educationalInstitution->registrationScheduleActive)->end_date));
                $toDay = date('Y-m-d');

                return collect([
                    'id' => $educationalInstitution->id,
                    'name' => $educationalInstitution->name,
                    'educationalLevel' => optional($educationalInstitution->educationalLevel)->name,
                    'colorLevel' => optional($educationalInstitution->educationalLevel)->code == 'SD' ? 'bg-danger' : (optional($educationalInstitution->educationalLevel)->code == 'SMP' ? 'bg-primary' : 'bg-info'),
                    'email' => $educationalInstitution->email,
                    'website' => $educationalInstitution->website,
                    'profile' => $educationalInstitution->profile,
                    'logo' => $educationalInstitution->hasMedia('logo') ? $educationalInstitution->getFirstTemporaryUrl(Carbon::now()->addMinutes(5), 'logo') : asset('assets/sekolah.png'),
                    'startDateSchedule' => Carbon::parse($startDate)->isoFormat('DD MMMM Y'),
                    'endDateSchedule' => Carbon::parse($endDate)->isoFormat('DD MMMM Y'),
                    'quota' => optional($educationalInstitution->registrationScheduleActive)->quota,
                    'remainingQuota' => optional($educationalInstitution->registrationScheduleActive)->remaining_quota,
                    'remainingDays' => $startDate > $toDay && $endDate > $toDay ? 'Belum dibuka' : ($startDate <= $toDay && $endDate >= $toDay ? 'Sisa ' . Carbon::parse($endDate)->shortAbsoluteDiffForHumans() . ' lagi' : 'Telah ditutup'),
                    'hasMajors' => $educationalInstitution->majors->isNotEmpty() ? 'YES' : 'NO'
                ]);
            });
    }
}
