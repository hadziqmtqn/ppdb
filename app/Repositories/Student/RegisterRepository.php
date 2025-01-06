<?php

namespace App\Repositories\Student;

use App\Models\Application;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterRepository
{
    use ApiResponse;

    protected User $user;
    protected Student $student;
    protected SchoolYear $schoolYear;
    protected Application $application;

    public function __construct(User $user, Student $student, SchoolYear $schoolYear, Application $application)
    {
        $this->user = $user;
        $this->student = $student;
        $this->schoolYear = $schoolYear;
        $this->application = $application;
    }

    protected function schoolYearActive(): SchoolYear
    {
        return $this->schoolYear->active()
            ->firstOrFail();
    }

    protected function app(): Application
    {
        return $this->application->firstOrFail();
    }

    public function register(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            // TODO create user
            $user = $this->user;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            // TODO assign user role
            $user->assignRole('user');

            // TODO create student
            $student = $this->student;
            $student->user_id = $user->id;
            $student->school_year_id = $this->schoolYearActive()->id;
            $student->educational_institution_id = $request->input('educational_institution_id');
            $student->class_level_id = $request->input('class_level_id');
            $student->registration_path_id = $request->input('registration_path_id');
            $student->major_id = $request->input('major_id');
            $student->whatsapp_number = $request->input('whatsapp_number');
            $student->save();
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }
}
