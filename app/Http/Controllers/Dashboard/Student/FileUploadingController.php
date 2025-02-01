<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\MediaFileRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

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
}
