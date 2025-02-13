<?php

namespace App\Repositories;

use App\Models\EducationalInstitution;
use App\Models\RegistrationStep;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class HomeRepository
{
    protected EducationalInstitution $educationalInstitution;
    protected RegistrationStep $registrationStep;

    /**
     * @param EducationalInstitution $educationalInstitution
     * @param RegistrationStep $registrationStep
     */
    public function __construct(EducationalInstitution $educationalInstitution, RegistrationStep $registrationStep)
    {
        $this->educationalInstitution = $educationalInstitution;
        $this->registrationStep = $registrationStep;
    }


    // TODO Quotas
    public function quotas(): Collection
    {
        return $this->educationalInstitution
            ->with('registrationScheduleActive')
            ->whereHas('registrationScheduleActive')
            ->active()
            ->get()
            ->map(function (EducationalInstitution $educationalInstitution) {
                $fields = [
                    'quota' => [
                        'icon' => 'ticket-percent-outline',
                        'color' => 'primary',
                        'label' => 'Kuota',
                        'description' => 'Kuota pendaftaran yang disediakan',
                        'asset' => asset('assets/object-2.svg')
                    ],
                    'totalStudents' => [
                        'icon' => 'account-multiple',
                        'color' => 'success',
                        'label' => 'Jumlah Pendaftar',
                        'description' => 'Total calon siswa baru terdaftar',
                        'asset' => asset('assets/object-1.svg')
                    ],
                    'remainingQuota' => [
                        'icon' => 'at',
                        'color' => 'warning',
                        'label' => 'Sisa Kuota',
                        'description' => 'Sisa kuota pendaftaran saat ini',
                        'asset' => asset('assets/object-3.svg')
                    ]
                ];
                $data = [];

                foreach ($fields as $field => $attributes) {
                    switch ($field) {
                        case 'quota':
                            $data['quota'] = [
                                'value' => optional($educationalInstitution->registrationScheduleActive)->quota,
                                'icon' => $attributes['icon'],
                                'color' => $attributes['color'],
                                'label' => $attributes['label'],
                                'description' => $attributes['description'],
                                'asset' => $attributes['asset']
                            ];
                            break;
                        case 'totalStudents':
                            $data['totalStudents'] = [
                                'value' => (optional($educationalInstitution->registrationScheduleActive)->quota ?? 0) - (optional($educationalInstitution->registrationScheduleActive)->remaining_quota ?? 0),
                                'icon' => $attributes['icon'],
                                'color' => $attributes['color'],
                                'label' => $attributes['label'],
                                'description' => $attributes['description'],
                                'asset' => $attributes['asset']
                            ];
                            break;
                        case 'remainingQuota':
                            $data['remainingQuota'] = [
                                'value' => optional($educationalInstitution->registrationScheduleActive)->remaining_quota,
                                'icon' => $attributes['icon'],
                                'color' => $attributes['color'],
                                'label' => $attributes['label'],
                                'description' => $attributes['description'],
                                'asset' => $attributes['asset']
                            ];
                            break;
                    }
                }

                return collect([
                    'name' => $educationalInstitution->name,
                    'data' => $data
                ]);
            });
    }

    // TODO Get Schedule
    public function getSchedule(): Collection
    {
        return $this->educationalInstitution
            ->with('registrationScheduleActive')
            ->active()
            ->get()
            ->map(function (EducationalInstitution $educationalInstitution) {
                $registrationSchedule = optional($educationalInstitution)->registrationScheduleActive;

                return collect([
                    'name' => $educationalInstitution->name,
                    'startDate' => $registrationSchedule->start_date ? Carbon::parse($registrationSchedule->start_date)->isoFormat('DD MMM Y') : null,
                    'endDate' => $registrationSchedule->end_date ? Carbon::parse($registrationSchedule->end_date)->isoFormat('DD MMM Y') : null,
                    'hasEnded' => $registrationSchedule && (date('Y-m-d') >= date('Y-m-d', strtotime($registrationSchedule->end_date))) ?? false,
                ]);
            });
    }

    // TODO Registration Steps
    public function getRegistrationSteps(): Collection
    {
        return $this->registrationStep
            ->active()
            ->orderBy('serial_number')
            ->get()
            ->map(function (RegistrationStep $registrationStep) {
                // Default images based on serial_number
                $defaultImages = [
                    1 => asset('assets/steps/step-1.png'),
                    2 => asset('assets/steps/step-2.png'),
                    3 => asset('assets/steps/step-3.png'),
                    4 => asset('assets/steps/step-4.png'),
                ];

                return collect([
                    'serialNumber' => $registrationStep->serial_number,
                    'title' => $registrationStep->title,
                    'description' => $registrationStep->description,
                    'image' => $registrationStep->hasMedia('steps') ? $registrationStep->getFirstTemporaryUrl(Carbon::now()->addMinutes(20), 'steps') : ($defaultImages[$registrationStep->serial_number] ?? null),
                    // Determine classPosition based on serial_number
                    'classPosition' => $registrationStep->serial_number % 2 == 0 ? [
                        'imageClass' => 'order-md-0 order-lg-1',
                        'contentClass' => 'order-md-1 order-lg-0'
                    ] : null
                ]);
            });
    }
}
