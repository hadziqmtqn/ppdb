<?php

namespace App\Repositories;

use App\Models\EducationalInstitution;
use Illuminate\Support\Collection;

class HomeRepository
{
    protected EducationalInstitution $educationalInstitution;

    /**
     * @param EducationalInstitution $educationalInstitution
     */
    public function __construct(EducationalInstitution $educationalInstitution)
    {
        $this->educationalInstitution = $educationalInstitution;
    }


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
                        'icon' => 'icon-quota',
                        'label' => 'Quota',
                        'description' => 'Total quota available'
                    ],
                    'totalStudents' => [
                        'icon' => 'icon-students',
                        'label' => 'Total Students',
                        'description' => 'Total number of students registered'
                    ],
                    'remainingQuota' => [
                        'icon' => 'icon-remaining',
                        'label' => 'Remaining Quota',
                        'description' => 'Quota remaining for registration'
                    ]
                ];
                $data = [];

                foreach ($fields as $field => $attributes) {
                    switch ($field) {
                        case 'quota':
                            $data['quota'] = [
                                'value' => optional($educationalInstitution->registrationScheduleActive)->quota,
                                'icon' => $attributes['icon'],
                                'label' => $attributes['label'],
                                'description' => $attributes['description']
                            ];
                            break;
                        case 'totalStudents':
                            $data['totalStudents'] = [
                                'value' => (optional($educationalInstitution->registrationScheduleActive)->quota ?? 0) - (optional($educationalInstitution->registrationScheduleActive)->remaining_quota ?? 0),
                                'icon' => $attributes['icon'],
                                'label' => $attributes['label'],
                                'description' => $attributes['description']
                            ];
                            break;
                        case 'remainingQuota':
                            $data['remainingQuota'] = [
                                'value' => optional($educationalInstitution->registrationScheduleActive)->remaining_quota,
                                'icon' => $attributes['icon'],
                                'label' => $attributes['label'],
                                'description' => $attributes['description']
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
}
