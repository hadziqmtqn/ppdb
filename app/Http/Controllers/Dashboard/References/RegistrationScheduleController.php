<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationSchedule\RegistrationScheduleRequest;
use App\Models\RegistrationSchedule;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RegistrationScheduleController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('registration-schedule-write'), only: ['store', 'update'])
        ];
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = RegistrationSchedule::query()
                    ->with('educationalInstitution:id,name', 'schoolYear:id,first_year,last_year');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['start_date', 'end_date'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
                    ->addColumn('schoolYear', fn($row) => optional($row->schoolYear)->first_year . '-' . optional($row->schoolYear)->last_year)
                    ->addColumn('date', fn($row) => Carbon::parse($row->start_date)->isoFormat('DD MMMM Y') . '-' . Carbon::parse($row->end_date)->isoFormat('DD MMMM Y'))
                    ->addColumn('action', function ($row) {
                        return '<button href="javascript:void(0)" data-slug="'. $row->slug .'" data-start-date="'. date('Y-m-d', strtotime($row->start_date)) .'" data-end-date="'. date('Y-m-d', strtotime($row->end_date)) .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(RegistrationScheduleRequest $request): JsonResponse
    {
        try {
            $registrationSchedule = RegistrationSchedule::query()
                ->filterData([
                    'educational_institution_id' => $request->input('educational_institution_id'),
                    'school_year_id' => $request->input('school_year_id')
                ])
                ->firstOrNew();
            $registrationSchedule->educational_institution_id = $request->input('educational_institution_id');
            $registrationSchedule->school_year_id = $request->input('school_year_id');
            $registrationSchedule->start_date = $request->input('start_date');
            $registrationSchedule->end_date = $request->input('end_date');
            $registrationSchedule->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $registrationSchedule, null, Response::HTTP_OK);
    }

    public function update(RegistrationScheduleRequest $request, RegistrationSchedule $registrationSchedule)
    {
        $registrationSchedule->update($request->validated());

        return $registrationSchedule;
    }
}
