<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Student\SchoolReportRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FileUploadingController extends Controller
{
    use ApiResponse;

    protected StudentRegistrationRepository $studentRegistrationRepository;
    protected SchoolReportRepository $schoolReportRepository;

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository, SchoolReportRepository $schoolReportRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
        $this->schoolReportRepository = $schoolReportRepository;
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Manajemen Siswa';
        $user->load('student.educationalInstitution.registrationSetting');
        $menus = $this->studentRegistrationRepository->menus($user);
        $files = $this->studentRegistrationRepository->getFiles($user->student);
        $schoolReportIsCompleted = $this->schoolReportRepository->isComplete($user);

        return view('dashboard.student.file-uploading.index', compact('title', 'user', 'menus', 'files', 'schoolReportIsCompleted'));
    }

    public function store(Request $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('student');

            $student = $user->student;

            $mediaFiles = $this->studentRegistrationRepository->getFiles($student);

            $fileName = null;
            $fileUrl = null;
            foreach ($mediaFiles as $file => $mediaFile) {
                if ($request->hasFile($file) && $request->file($file)->isValid()) {
                    if ($student->hasMedia($file)) {
                        $student->clearMediaCollection($file);
                    }

                    $student->addMediaFromRequest($file)
                        ->usingFileName(Str::random(10) . '_' . $request->file($file)->getClientOriginalName())
                        ->toMediaCollection($file);

                    $student->refresh();

                    $fileName = $file;
                    $fileUrl = $student->getFirstTemporaryUrl(Carbon::now()->addMinutes(30), $file);
                }
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Berkas gagal diunggah!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Berkas berhasil diunggah!', [
            'fileName' => $fileName,
            'fileUrl' => $fileUrl
        ], null, Response::HTTP_OK);
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('student');

            $student = $user->student;

            if ($student->hasMedia($request->input('file'))) {
                $student->clearMediaCollection($request->input('file'));
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Berkas gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Berkas berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
