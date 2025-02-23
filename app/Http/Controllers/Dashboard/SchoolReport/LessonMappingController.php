<?php

namespace App\Http\Controllers\Dashboard\SchoolReport;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolReport\LessonMapping\LessonMappingRequest;
use App\Models\EducationalGroup;
use App\Models\Lesson;
use App\Models\LessonMapping;
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

class LessonMappingController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('lesson-mapping-read'), only: ['index', 'datatable', 'show']),
            new Middleware(PermissionMiddleware::using('lesson-mapping-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('lesson-mapping-delete'), only: ['destroy'])
        ];
    }

    public function index(): View
    {
        $title = 'Pengaturan Registrasi';
        $subTitle = 'Pembagian Mata Pelajaran';
        $lessons = $this->getLessons();

        return \view('dashboard.school-report.lesson-mapping.index', compact('title', 'subTitle', 'lessons'));
    }

    public function getLessons()
    {
        return Lesson::active()
            ->get();
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = LessonMapping::query()
                    ->with('educationalInstitution:id,name', 'lesson:id,name');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereHas('lesson', fn($query) => $query->whereAny(['name'], 'LIKE', '%' . $search . '%'));
                        });
                    })
                    ->addColumn('lesson', fn($row) => optional($row->lesson)->name)
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
                    ->addColumn('previous_educational_group', function ($row) {
                        $previousEducationalGroups = json_decode($row->previous_educational_group, true);
                        if (!is_array($previousEducationalGroups)) {
                            return '-';
                        }

                        $educationalGroup = EducationalGroup::whereIn('id', $previousEducationalGroups)
                            ->pluck('name')
                            ->toArray();

                        return implode(', ', $educationalGroup);
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="'. route('lesson-mapping.show', $row->slug) .'" class="btn btn-icon btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a> ';
                        $btn .= '<button type="button" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'is_active'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(LessonMappingRequest $request): JsonResponse
    {
        $lessonMappingExist = LessonMapping::query()
            ->filterData([
                'lesson_id' => $request->input('lesson_id'),
                'educational_institution_id' => $request->input('educational_institution_id')
            ])
            ->exists();

        if ($lessonMappingExist) return $this->apiResponse('Data telah dibuat!', null, null, Response::HTTP_BAD_REQUEST);

        try {
            $lessonMapping = new LessonMapping();
            $lessonMapping->lesson_id = $request->input('lesson_id');
            $lessonMapping->educational_institution_id = $request->input('educational_institution_id');
            $lessonMapping->previous_educational_group = json_encode(array_map('intval', $request->input('previous_educational_group')));
            $lessonMapping->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    public function show(LessonMapping $lessonMapping): View
    {
        $title = 'Pengaturan Registrasi';
        $subTitle = 'Detail Pembagian Mata Pelajaran';
        $lessons = $this->getLessons();
        $lessonMapping->load('educationalInstitution:id,name', 'lesson:id,name');
        $previousEducationalGroups = json_decode($lessonMapping->previous_educational_group, true);
        $educationalGroups = EducationalGroup::whereIn('id', $previousEducationalGroups)
            ->select(['id', 'name'])
            ->get();

        return \view('dashboard.school-report.lesson-mapping.show', compact('title', 'subTitle', 'lessonMapping', 'lessons', 'educationalGroups'));
    }

    public function update(LessonMappingRequest $request, LessonMapping $lessonMapping): JsonResponse
    {
        $lessonMappingExist = LessonMapping::query()
            ->filterData([
                'lesson_id' => $request->input('lesson_id'),
                'educational_institution_id' => $request->input('educational_institution_id')
            ])
            ->where('id', '!=', $lessonMapping->id)
            ->exists();

        if ($lessonMappingExist) return $this->apiResponse('Data telah dibuat!', null, null, Response::HTTP_BAD_REQUEST);

        try {
            $lessonMapping->lesson_id = $request->input('lesson_id');
            $lessonMapping->educational_institution_id = $request->input('educational_institution_id');
            $lessonMapping->previous_educational_group = json_encode(array_map('intval', $request->input('previous_educational_group')));
            $lessonMapping->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, route('lesson-mapping.index'), Response::HTTP_OK);
    }

    public function destroy(LessonMapping $lessonMapping): JsonResponse
    {
        try {
            $lessonMapping->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
