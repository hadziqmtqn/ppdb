<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Exports\Student\StudentReportExcel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\FilterRequest;
use App\Models\EducationalInstitution;
use App\Models\SchoolYear;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class StudentReportController extends Controller implements HasMiddleware
{
    use ApiResponse;

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

            return Excel::download(new StudentReportExcel($request), 'Daftar PPDB ' . $educationalInstitutionName . $registrationAccepted . ' TA. ' . $schoolYear->first_year . '-' . $schoolYear->last_year . '.xlsx');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Laporan gagal diunduh!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
