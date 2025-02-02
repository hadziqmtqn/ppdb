<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\FilterRequest;
use App\Repositories\Student\StudentStatsRepository;

class StudentStatsController extends Controller
{
    protected StudentStatsRepository $studentStatsRepository;

    public function __construct(StudentStatsRepository $studentStatsRepository)
    {
        $this->studentStatsRepository = $studentStatsRepository;
    }

    public function index(FilterRequest $request)
    {
        return $this->studentStatsRepository->total($request);
    }
}
