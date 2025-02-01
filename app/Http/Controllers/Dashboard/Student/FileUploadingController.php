<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\MediaFileRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
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
    protected MediaFileRepository $mediaFileRepoitory;

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository, MediaFileRepository $mediaFileRepoitory)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
        $this->mediaFileRepoitory = $mediaFileRepoitory;
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
        $files = $this->mediaFileRepoitory->getFiles([
            'educational_institution_id' => optional($user->student)->educational_institution_id,
            'registration_path_id' => optional($user->student)->registration_path_id
        ]);

        return view('dashboard.student.file-uploading.index', compact('title', 'user', 'menus', 'files'));
    }

    public function store(Request $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('student');

            $student = $user->student;

            $mediaFiles = $this->mediaFileRepoitory->getFiles([
                'educational_institution_id' => $student->educational_institution_id,
                'registration_path_id' => $student->registration_path_id
            ]);

            foreach ($mediaFiles as $file => $mediaFile) {
                if ($request->hasFile($file) && $request->file($file)->isValid()) {
                    if ($student->hasMedia($file)) {
                        $student->clearMediaCollection($file);
                    }

                    $student->addMediaFromRequest($file)
                        ->toMediaCollection($file);
                }
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Berkas gagal diunggah!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Berkas berhasil diunggah!', null, null, Response::HTTP_OK);
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
