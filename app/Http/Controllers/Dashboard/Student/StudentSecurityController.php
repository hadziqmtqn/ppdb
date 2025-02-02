<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\SecurityRequest;
use App\Models\User;
use App\Repositories\SendMessage\SafetyChangesRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentSecurityController extends Controller
{
    use ApiResponse;

    protected SafetyChangesRepository $safetyChangesRepository;

    public function __construct(SafetyChangesRepository $safetyChangesRepository)
    {
        $this->safetyChangesRepository = $safetyChangesRepository;
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Siswa';
        $user->load([
            'student.educationalInstitution:id,name',
            'student.registrationCategory:id,name',
            'student.registrationPath:id,name',
        ]);

        // TODO Photo Url
        $student = optional($user->student);
        $photoUrl = url('https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF');

        if ($student->hasMedia('pas-foto')) {
            $media = $student->getFirstMedia('pas-foto');

            if ($media && Str::startsWith($media->mime_type, 'image/')) {
                $photoUrl = $media->getTemporaryUrl(Carbon::now()->addMinutes(30));
            }
        }

        return \view('dashboard.student.security.index', compact('title', 'user', 'photoUrl'));
    }

    public function store(SecurityRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('student');

            $user->email = $request->input('email');
            $user->password = $request->input('password') ? Hash::make($request->input('password')) : $user->password;
            $user->save();

            // TODO Send Message
            $this->safetyChangesRepository->sendMessage([
                'username' => $user->name,
                'password' => $request->input('password') ?? '_Tidak ada perubahan_',
                'newEmail' => $request->input('email') != $user->email ? $request->input('email') : '_Tidak ada perubahan_',
                'oldEmail' => $user->email,
                'whatsappNumber' => optional($user->student)->whatsapp_number
            ]);
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $user, route('student-security.index', $user->username), Response::HTTP_OK);
    }
}
