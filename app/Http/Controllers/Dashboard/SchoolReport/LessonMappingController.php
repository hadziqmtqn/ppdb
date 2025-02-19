<?php

namespace App\Http\Controllers\Dashboard\SchoolReport;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolReport\LessonMapping\LessonMappingRequest;
use App\Models\LessonMapping;

class LessonMappingController extends Controller
{
    public function index()
    {
        return LessonMapping::all();
    }

    public function store(LessonMappingRequest $request)
    {
        return LessonMapping::create($request->validated());
    }

    public function show(LessonMapping $lessonMapping)
    {
        return $lessonMapping;
    }

    public function update(LessonMappingRequest $request, LessonMapping $lessonMapping)
    {
        $lessonMapping->update($request->validated());

        return $lessonMapping;
    }

    public function destroy(LessonMapping $lessonMapping)
    {
        $lessonMapping->delete();

        return response()->json();
    }
}
