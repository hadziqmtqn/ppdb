<?php

namespace App\Repositories\Dashboard;

use App\Models\EducationalInstitution;
use App\Models\PreviousSchoolReference;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class AdminDashboardRepository
{
    protected EducationalInstitution $educationalInstitution;
    protected Student $student;
    protected PreviousSchoolReference $previousSchoolReference;

    public function __construct(EducationalInstitution $educationalInstitution, Student $student, PreviousSchoolReference $previousSchoolReference)
    {
        $this->educationalInstitution = $educationalInstitution;
        $this->student = $student;
        $this->previousSchoolReference = $previousSchoolReference;
    }

    public function totalBaseData(): Collection
    {
        return collect([
            'Total Lembaga' => [
                'title' => null,
                'icon' => 'office-building-marker-outline',
                'color' => 'primary',
                'total' => $this->educationalInstitution->active()->count()
            ]
        ]);
    }

    public function stats(): Collection
    {
        return collect([
            'Total Siswa' => [
                'total' => 0,
                'icon' => 'account-multiple-outline',
                'id' => 'totalStudents'
            ],
            'Pendaftaran Diterima' => [
                'total' => 0,
                'icon' => 'check-all',
                'id' => 'registrationReceived'
            ],
            'Belum Diterima' => [
                'total' => 0,
                'icon' => 'wallet-outline',
                'id' => 'notYetReceived'
            ],
            'Registrasi Ditolak' => [
                'total' => 0,
                'icon' => 'alert-octagon-outline',
                'id' => 'registrationRejected'
            ]
        ]);
    }

    public function previousSchoolReferenceDatatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = $this->previousSchoolReference->query()
                    ->with('educationalGroup:id,name')
                    ->withCount('previousSchools')
                    ->whereHas('previousSchools.user.student', function ($query) use ($request) {
                        $query->where('school_year_id', $request->get('school_year_id'));
                    });

                $educationalInstitution = $request->get('educational_institution_id');
                $data->when($educationalInstitution, function ($query) use ($educationalInstitution) {
                    $query->whereHas('previousSchools.user.student', function ($query) use ($educationalInstitution) {
                        $query->where('educational_institution_id', $educationalInstitution);
                    });
                });

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalGroup', fn($row) => optional($row->educationalGroup)->name)
                    ->addColumn('npsn', fn($row) => '<a href="https://referensi.data.kemdikbud.go.id/pendidikan/npsn/' . $row->npsn . '" target="_blank">'. $row->npsn .'</a>')
                    ->rawColumns(['npsn'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }
}
