<?php

namespace App\Repositories\Student;

use App\Models\MediaFile;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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

    public function allCompleted(User $user): bool
    {
        // Panggil method menus untuk mendapatkan koleksi menu
        $menus = $this->menus($user);

        // Cek apakah semua menu bernilai isCompleted == true
        return $menus->every(fn($menu) => $menu['isCompleted']);
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

    public function registrationStatus(Student $student): Collection
    {
        $statusMapping = [
            'belum_diterima' => [
                'color' => 'warning',
                'text' => Auth::user()->hasRole('user') ? 'Registrasi belum diterima, masih dalam tahap validasi.' : 'Registrasi belum diterima, harap data registrasi divalidasi terlebih dahulu.'
            ],
            'diterima' => [
                'color' => 'primary',
                'text' => Auth::user()->hasRole('user') ? 'Selamat, registrasi Anda telah diterima.' : 'Registrasi siswa ' . optional($student->user)->name . ' telah diterima.'
            ],
            'ditolak' => [
                'color' => 'danger',
                'text' => Auth::user()->hasRole('user') ? 'Maaf, registrasi Anda ditolak. Silahkan hubungi administrator untuk informasi lebih lanjut.' : 'Registrasi siswa ' . optional($student->user)->name . ' ditolak.'
            ]
        ];

        $registrationStatus = $statusMapping[$student->registration_status] ?? [
            'color' => 'secondary', // Warna abu-abu untuk status tidak valid
            'text' => 'Status registrasi tidak valid atau belum diatur.' // Pesan yang lebih informatif
        ];

        $registrationStatus['status'] = $student->registration_status;

        return collect($registrationStatus);
    }

    public function countCompletedUsers($request): Collection
    {
        $students = Student::with('user')
            ->statsFilter($request)
            ->get();

        $completedUsersCount = 0;
        $incompleteUsersCount = 0;

        foreach ($students as $student) {
            if ($this->allCompleted($student->user)) {
                $completedUsersCount++;
            } else {
                $incompleteUsersCount++;
            }
        }

        $totalUsers = $completedUsersCount + $incompleteUsersCount;
        $completedPercentage = $totalUsers > 0 ? ($completedUsersCount / $totalUsers) * 100 : 0;
        $incompletePercentage = $totalUsers > 0 ? ($incompleteUsersCount / $totalUsers) * 100 : 0;

        return collect([
            'completed' => [
                'count' => $completedUsersCount,
                'percentage' => round($completedPercentage)
            ],
            'incomplete' => [
                'count' => $incompleteUsersCount,
                'percentage' => round($incompletePercentage)
            ]
        ]);
    }
}
