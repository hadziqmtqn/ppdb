<?php

namespace App\Http\Controllers\Dashboard\SchoolReport;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolReport\Lesson\LessonRequest;
use App\Http\Requests\SchoolReport\Lesson\UpdateLessonRequest;
use App\Models\Lesson;
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

class LessonController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('lesson-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('lesson-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('lesson-delete'), only: ['destroy'])
        ];
    }

    public function index(): View
    {
        $title = 'Pengaturan Registrasi';
        $subTitle = 'Mata Pelajaran';

        return \view('dashboard.school-report.lesson.index', compact('title', 'subTitle'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Lesson::query()
                    ->withCount('lessonMappings');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('type', fn($row) => ucfirst($row->type))
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        $btn = '<button type="button" data-slug="'. $row->slug .'" data-name="'. $row->name .'" data-code="'. $row->code .'" data-type="'. $row->type .'" data-active="'. $row->is_active .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';

                        if ($row->lesson_mappings_count == 0) {
                            $btn .= '<button type="button" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';
                        }

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

    public function store(LessonRequest $request): JsonResponse
    {
        try {
            $lesson = new Lesson();
            $lesson->code = $request->input('code');
            $lesson->name = $request->input('name');
            $lesson->type = $request->input('type');
            $lesson->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson): JsonResponse
    {
        try {
            $lesson->code = $request->input('code');
            $lesson->name = $request->input('name');
            $lesson->type = $request->input('type');
            $lesson->is_active = $request->input('is_active');
            $lesson->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    public function destroy(Lesson $lesson): JsonResponse
    {
        try {
            $lesson->loadCount('lessonMappings');

            if ($lesson->lesson_mappings_count != 0) return $this->apiResponse('Data tidak bisa dihapus!', null, null, Response::HTTP_BAD_REQUEST);

            $lesson->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
