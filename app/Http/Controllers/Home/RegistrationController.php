<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\RegisterRequest;
use App\Repositories\EducationalInstitutionRepository;
use App\Repositories\Student\RegisterRepository;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    protected EducationalInstitutionRepository $educationalInstitutionRepository;
    protected RegisterRepository $registerRepository;

    public function __construct(EducationalInstitutionRepository $educationalInstitutionRepository, RegisterRepository $registerRepository)
    {
        $this->educationalInstitutionRepository = $educationalInstitutionRepository;
        $this->registerRepository = $registerRepository;
    }

    public function index(): View
    {
        $title = 'Registrasi';
        $educationalInstitutions = $this->educationalInstitutionRepository->getEducationalInstitutionWithSchedule();

        return \view('home.register.index', compact('title', 'educationalInstitutions'));
    }

    public function store(RegisterRequest $request)
    {
        return $this->registerRepository->register($request);
    }
}
