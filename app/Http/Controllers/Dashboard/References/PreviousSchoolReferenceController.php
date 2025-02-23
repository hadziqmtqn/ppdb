<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreviousSchoolReference\PreviousSchoolReferenceRequest;
use App\Models\PreviousSchoolReference;
use App\Repositories\References\PreviousSchoolReferenceRepository;
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

class PreviousSchoolReferenceController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected PreviousSchoolReferenceRepository $previousSchoolReferenceRepository;

    /**
     * @param PreviousSchoolReferenceRepository $previousSchoolReferenceRepository
     */
    public function __construct(PreviousSchoolReferenceRepository $previousSchoolReferenceRepository)
    {
        $this->previousSchoolReferenceRepository = $previousSchoolReferenceRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('previous-school-reference-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('previous-school-reference-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('previous-school-reference-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Referensi Asal Sekolah';

        return \view('dashboard.references.previous-school-reference.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = PreviousSchoolReference::query()
                    ->with('educationalGroup:id,name')
                    ->withCount('previousSchools')
                    ->orderByDesc('created_at');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name', 'npsn'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalGroup', fn($row) => optional($row->educationalGroup)->name)
                    ->addColumn('npsn', fn($row) => '<a href="https://referensi.data.kemdikbud.go.id/pendidikan/npsn/' . $row->npsn . '" target="_blank">' . $row->npsn . '</a>')
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="'. route('previous-school-reference.show', $row->slug) .'" class="btn btn-icon btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a> ';
                        if (($row->previous_schools_count == 0)) {
                            $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action', 'npsn'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(PreviousSchoolReferenceRequest $request): JsonResponse
    {
        try {
            $previousSchoolReference = new PreviousSchoolReference();
            $previousSchoolReference->educational_group_id = $request->input('educational_group_id');
            $previousSchoolReference->npsn = $request->input('npsn');
            $previousSchoolReference->name = $request->input('name');
            $previousSchoolReference->province = $request->input('province');
            $previousSchoolReference->city = $request->input('city');
            $previousSchoolReference->district = $request->input('district');
            $previousSchoolReference->village = $request->input('village');
            $previousSchoolReference->street = $request->input('street');
            $previousSchoolReference->status = $request->input('status');
            $previousSchoolReference->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    public function show(PreviousSchoolReference $previousSchoolReference): View
    {
        $title = 'Reference Asal Sekolah';
        $subTitle = 'Detail ' . $title;
        $previousSchoolReference->load('educationalGroup:id,name');

        return \view('dashboard.references.previous-school-reference.show', compact('title', 'subTitle', 'previousSchoolReference'));
    }

    public function update(PreviousSchoolReferenceRequest $request, PreviousSchoolReference $previousSchoolReference): JsonResponse
    {
        try {
            $previousSchoolReference->educational_group_id = $request->input('educational_group_id');
            $previousSchoolReference->npsn = $request->input('npsn');
            $previousSchoolReference->name = $request->input('name');
            $previousSchoolReference->province = $request->input('province');
            $previousSchoolReference->city = $request->input('city');
            $previousSchoolReference->district = $request->input('district');
            $previousSchoolReference->village = $request->input('village');
            $previousSchoolReference->street = $request->input('street');
            $previousSchoolReference->status = $request->input('status');
            $previousSchoolReference->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, route('previous-school-reference.index'), Response::HTTP_OK);
    }

    public function destroy(PreviousSchoolReference $previousSchoolReference): JsonResponse
    {
        try {
            $previousSchoolReference->loadCount('previousSchools');

            if ($previousSchoolReference->previous_schools_count > 0) return $this->apiResponse('Data tidak bisa dihapus', null, null, Response::HTTP_BAD_REQUEST);

            $previousSchoolReference->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }

    // TODO Select
    public function select(Request $request)
    {
        return $this->previousSchoolReferenceRepository->select($request);
    }
}
