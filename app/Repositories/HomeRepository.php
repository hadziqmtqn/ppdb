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
}
