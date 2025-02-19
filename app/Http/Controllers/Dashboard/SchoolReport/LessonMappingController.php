<?php

namespace App\Http\Controllers\Dashboard\SchoolReport;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolReport\LessonMapping\LessonMappingRequest;
use App\Models\LessonMapping;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

        return \view('dashboard.school-report.lesson-mapping.index', compact('title'));
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

        return \view('dashboard.school-report.lesson-mapping.show', compact('title', 'lessonMapping'));
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
