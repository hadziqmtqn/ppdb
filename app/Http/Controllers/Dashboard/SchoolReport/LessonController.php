<?php

namespace App\Http\Controllers\Dashboard\SchoolReport;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolReport\Lesson\LessonRequest;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index()
    {
        return Lesson::all();
    }

    public function store(LessonRequest $request)
    {
        return Lesson::create($request->validated());
    }

    public function show(Lesson $lesson)
    {
        return $lesson;
    }

    public function update(LessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        return $lesson;
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->json();
    }
}
