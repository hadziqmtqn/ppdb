<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentRequest;
use App\Models\Student;
use App\Traits\ApiResponse;

class StudentController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return Student::all();
    }

    public function store(StudentRequest $request)
    {
        return Student::create($request->validated());
    }

    public function show(Student $student)
    {
        return $student;
    }

    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return $student;
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json();
    }
}
