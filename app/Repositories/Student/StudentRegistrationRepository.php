<?php

namespace App\Repositories\Student;

use App\Models\MediaFile;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class StudentRegistrationRepository
{
    protected User $user;
    protected MediaFile $mediaFile;

    public function __construct(User $user, MediaFile $mediaFile)
    {
        $this->user = $user;
        $this->mediaFile = $mediaFile;
    }

    public function menus(User $user): Collection
    {
        $user->load('student', 'personalData', 'family', 'residence', 'previousSchool');

        $uploadingFile = $this->getFiles($user->student);

        return collect([
            'Pendaftaran' => collect([
                'icon' => 'mdi-account-plus-outline',
                'url' => route('student-registration.index', $user->username),
                'isCompleted' => (bool)$user->student
            ]),
            'Data Pribadi' => collect([
                'icon' => 'mdi-account-outline',
                'url' => route('personal-data.index', $user->username),
                'isCompleted' => (bool)$user->personalData
            ]),
            'Keluarga' => collect([
                'icon' => 'mdi-account-network',
                'url' => route('family.index', $user->username),
                'isCompleted' => (bool)$user->family
            ]),
            'Tempat Tinggal' => collect([
                'icon' => 'mdi-map-marker-outline',
                'url' => route('place-of-recidence.index', $user->username),
                'isCompleted' => (bool)$user->residence
            ]),
            'Asal Sekolah' => collect([
                'icon' => 'mdi-school-outline',
                'url' => route('previous-school.index', $user->username),
                'isCompleted' => (bool)$user->previousSchool
            ]),
            'Unggah Berkas' => collect([
                'icon' => 'mdi-upload-outline',
                'url' => route('file-uploading.index', $user->username),
                'isCompleted' => !empty($uploadingFile) && collect($uploadingFile)->every(fn($file) => !empty($file['fileUrl']))
            ])
        ]);
    }

    public function getFiles(Student $student): array
    {
        $mediaFiles = $this->mediaFile->query()
            ->whereHas('detailMediaFile', function ($query) use ($student) {
                $query->where(function ($query) use ($student) {
                    $query->where('educational_institution_id', $student->educational_institution_id)
                        ->whereNull('registration_path_id');
                })
                    ->orWhere(function ($query) use ($student) {
                        $query->where([
                            'educational_institution_id' => $student->educational_institution_id,
                            'registration_path_id' => $student->registration_path_id
                        ]);
                    });
            })
            ->orWhereDoesntHave('detailMediaFiles')
            ->select(['file_code', 'name'])
            ->active()
            ->get();

        $file = [];
        foreach ($mediaFiles as $uploadFileCategory) {
            $file[$uploadFileCategory->file_code] = [
                'fileName' => $uploadFileCategory->name,
                'fileUrl' => $student->hasMedia($uploadFileCategory->file_code) ? $student->getFirstTemporaryUrl(Carbon::now()->addMinutes(30), $uploadFileCategory->file_code) : null
            ];
        }

        return $file;
    }

    public function registrationValidationStatus(Student $student): Collection
    {
        $statusMapping = [
            'belum_divalidasi' => [
                'icon' => 'alert-outline',
                'color' => 'warning',
                'text' => 'Data registrasi siswa belum divalidasi.'
            ],
            'valid' => [
                'icon' => 'check-circle-outline',
                'color' => 'success',
                'text' => 'Data registrasi dan berkas pendukungnya telah dinyatakan valid.'
            ],
            'tidak_valid' => [
                'icon' => 'alert-rhombus-outline',
                'color' => 'danger',
                'text' => 'Data registrasi tidak valid, harap periksa kembali!'
            ]
        ];

        $validationStatus = $statusMapping[$student->registration_validation] ?? [
            'icon' => 'alert-rhombus-outline',
            'color' => 'danger'
        ];

        return collect($validationStatus);
    }
}
