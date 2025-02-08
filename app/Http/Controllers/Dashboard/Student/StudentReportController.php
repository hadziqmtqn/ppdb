<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Exports\Student\StudentReportExcel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\FilterRequest;
use App\Models\EducationalInstitution;
use App\Models\SchoolYear;
use App\Models\User;
use App\Repositories\Student\StudentRepository;
use App\Traits\ApiResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class StudentReportController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected StudentRepository $studentRepository;

    /**
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware('role:super-admin|admin')
        ];
    }

    public function excel(FilterRequest $request)
    {
        try {
            $schoolYear = SchoolYear::findOrFail($request->input('school_year_id'));
            $educationalInstitution = EducationalInstitution::find($request->input('educational_institution_id'));

            $educationalInstitutionName = optional($educationalInstitution)->name ?? ' Semua Lembaga ';
            $registrationAccepted = !$request->input('registration_status') ? ' Semua Status ' : ' Siswa ' . ucfirst(str_replace('_', ' ', $request->input('registration_status')));

            return Excel::download(new StudentReportExcel($request), 'Daftar PPDB ' . $educationalInstitutionName . $registrationAccepted . ' TA-' . $schoolYear->first_year . '-' . $schoolYear->last_year . '.xlsx');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Laporan gagal diunduh!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function pdf(User $user)
    {
        Gate::authorize('view-student', $user);

        try {
            $user->load('student.schoolYear:id,first_year,last_year', 'family:id,user_id,father_name,mother_name,guardian_name');
            $educationalInstitution = optional($user->student)->educationalInstitution;

            $letterhead = $educationalInstitution->hasMedia('letterhead') ? $educationalInstitution->getFirstTemporaryUrl(Carbon::now()->addMinutes(10), 'letterhead') : url('https://lh3.googleusercontent.com/pw/AP1GczO5zN2A_YzIaDrs6VmHQPuBzRDYCB8r7j5QDDnfkJxvN68zg8ZR8t0DYs_j-L8csUS8QlOWoyOyftwNR4j8dXJ62vrevG_4ovAQUxjNZZt7wp9jZUwOOqq-cxxiP8ki2JQFG73elEB2oN3JdPEp3wPW=w2522-h396-s-no-gm?authuser=1');
            $schoolYear = optional(optional($user->student)->schoolYear)->first_year . '-' . optional(optional($user->student)->schoolYear)->last_year;

            return Pdf::loadView('dashboard.student.student.pdf', [
                'letterhead' => $letterhead,
                'schoolYear' => $schoolYear,
                'educationalInstitution' => $educationalInstitution->name,
                'studentName' => $user->name,
                'registrations' => $this->studentRepository->registration($user),
                'personalData' => $this->studentRepository->personalData($user),
                'families' => $this->studentRepository->family($user),
                'residences' => $this->studentRepository->resicende($user),
                'previousSchools' => $this->studentRepository->previousSchool($user),
                'parentName' => optional($user->family)->father_name,
                'city' => str_replace(['KABUPATEN', 'KOTA'], '', optional($educationalInstitution)->city),
                'date' => Carbon::parse($user->created_at)->isoFormat('DD MMMM Y')
            ])
                ->setOption([
                    'isRemoteEnabled' => true
                ])
                ->setPaper('folio')
                ->stream('Biodata PPDB ' . $user->name .  ' TA-' . $schoolYear . '.pdf');
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal diunduh!');
        }
    }
}
