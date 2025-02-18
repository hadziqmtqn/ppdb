<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationSetting\RegistrationSettingRequest;
use App\Models\RegistrationSetting;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RegistrationSettingController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('registration-setting-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('registration-setting-write'), only: ['store', 'update'])
        ];
    }

    public function index(): View
    {
        $title = 'Pengaturan Registrasi';

        return \view('dashboard.settings.registration-setting.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = RegistrationSetting::query()
                    ->with('educationalInstitution:id,name');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereHas('educationalInstitution', fn($query) => $query->where('name', 'LIKE', '%' . $search . '%'));
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
                    ->addColumn('accepted_with_school_raport', fn($row) => '<span class="badge rounded-pill '. ($row->accepted_with_school_report ? 'bg-primary' : 'bg-warning') .'">'. ($row->accepted_with_school_report ? 'Ya' : 'Tidak') .'</span>')
                    ->addColumn('action', function ($row) {
                        $btn = '<button href="javascript:void(0)" data-slug="'. $row->slug .'" data-educational-institution="'. $row->educational_institution_id .'" data-accepted="'. $row->accepted_with_school_raport .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'accepted_with_school_raport'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(RegistrationSettingRequest $request): JsonResponse
    {
        try {
            $registrationSetting = RegistrationSetting::educationalInstitutionId($request->input('educational_institution_id'))
                ->firstOrNew();
            $registrationSetting->educational_institution_id = $request->input('educational_institution_id');
            $registrationSetting->accepted_with_school_report = $request->input('accepted_with_school_report');
            $registrationSetting->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    public function update(RegistrationSettingRequest $request, RegistrationSetting $registrationSetting): JsonResponse
    {
        try {
            $registrationSetting->educational_institution_id = $request->input('educational_institution_id');
            $registrationSetting->accepted_with_school_report = $request->input('accepted_with_school_report');
            $registrationSetting->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }
}
