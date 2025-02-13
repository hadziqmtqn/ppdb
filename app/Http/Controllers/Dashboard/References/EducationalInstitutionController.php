<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationalInstitution\EducationalInstitutionRequest;
use App\Http\Requests\EducationalInstitution\UpdateEducationalInstitutionRequest;
use App\Models\EducationalInstitution;
use App\Repositories\EducationalInstitutionRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Yajra\DataTables\Facades\DataTables;

class EducationalInstitutionController extends Controller implements HasMiddleware
{
    protected EducationalInstitutionRepository $educationalInstitutionRepository;

    public function __construct(EducationalInstitutionRepository $educationalInstitutionRepository)
    {
        $this->educationalInstitutionRepository = $educationalInstitutionRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('educational-institution-read'), only: ['index', 'show']),
            new Middleware(PermissionMiddleware::using('educational-institution-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('educational-institution-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Lembaga';

        return view('dashboard.educational-institution.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = EducationalInstitution::query()
                    ->with('educationalLevel:id,name')
                    ->orderBy('educational_level_id');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalLevel', fn($row) => optional($row->educationalLevel)->name)
                    ->addColumn('is_active', function ($row) {
                        return '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-warning') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="' . route('educational-institution.show', $row->slug) . '" class="btn btn-icon btn-sm btn-primary"><i class="mdi mdi-eye"></i></a>';
                    })
                    ->rawColumns(['is_active', 'action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(EducationalInstitutionRequest $request)
    {
        try {
            $educationalInstitution = new EducationalInstitution();
            $educationalInstitution->educational_level_id = $request->input('educational_level_id');
            $educationalInstitution->name = $request->input('name');
            $educationalInstitution->email = $request->input('email');
            $educationalInstitution->website = $request->input('website');
            $educationalInstitution->province = $request->input('province');
            $educationalInstitution->city = $request->input('city');
            $educationalInstitution->district = $request->input('district');
            $educationalInstitution->village = $request->input('village');
            $educationalInstitution->street = $request->input('street');
            $educationalInstitution->postal_code = $request->input('postal_code');
            $educationalInstitution->profile = $request->input('profile');
            $educationalInstitution->save();

            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $educationalInstitution->addMediaFromRequest('logo')->toMediaCollection('logo');
            }
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function show(EducationalInstitution $educationalInstitution): View
    {
        $title = 'Lembaga';
        $educationalInstitution->load('educationalLevel');

        return view('dashboard.educational-institution.show', compact('title', 'educationalInstitution'));
    }

    public function update(UpdateEducationalInstitutionRequest $request, EducationalInstitution $educationalInstitution)
    {
        try {
            $educationalInstitution->educational_level_id = $request->input('educational_level_id');
            $educationalInstitution->name = $request->input('name');
            $educationalInstitution->email = $request->input('email');
            $educationalInstitution->website = $request->input('website');
            $educationalInstitution->province = $request->input('province');
            $educationalInstitution->city = $request->input('city');
            $educationalInstitution->district = $request->input('district');
            $educationalInstitution->village = $request->input('village');
            $educationalInstitution->street = $request->input('street');
            $educationalInstitution->postal_code = $request->input('postal_code');
            $educationalInstitution->profile = $request->input('profile');
            $educationalInstitution->is_active = $request->input('is_active');
            $educationalInstitution->save();

            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                if ($educationalInstitution->hasMedia('logo')) {
                    $educationalInstitution->clearMediaCollection('logo');
                }

                $educationalInstitution->addMediaFromRequest('logo')->toMediaCollection('logo');
            }

            if ($request->hasFile('letterhead') && $request->file('letterhead')->isValid()) {
                if ($educationalInstitution->hasMedia('letterhead')) {
                    $educationalInstitution->clearMediaCollection('letterhead');
                }

                $educationalInstitution->addMediaFromRequest('letterhead')->toMediaCollection('letterhead');
            }
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        }

        return to_route('educational-institution.index')->with('success', 'Data berhasil disimpan');
    }

    public function select(Request $request)
    {
        return $this->educationalInstitutionRepository->select($request);
    }
}
