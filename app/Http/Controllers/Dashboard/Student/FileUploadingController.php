<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FileUploadingController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected StudentRegistrationRepository $studentRegistrationRepository;

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('file-uploading-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('file-uploading-write'), only: ['store']),
            new Middleware(PermissionMiddleware::using('file-uploading-delete'), only: ['destroy']),
        ];
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Siswa';
        $user->load('student');
        $menus = $this->studentRegistrationRepository->menus($user);
        $files = $this->studentRegistrationRepository->getFiles($user->student);

        return view('dashboard.student.file-uploading.index', compact('title', 'user', 'menus', 'files'));
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
