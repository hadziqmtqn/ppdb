<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repositories\EducationalInstitutionRepository;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    protected EducationalInstitutionRepository $educationalInstitutionRepository;

    public function __construct(EducationalInstitutionRepository $educationalInstitutionRepository)
    {
        $this->educationalInstitutionRepository = $educationalInstitutionRepository;
    }

    public function index(): View
    {
        $title = 'Registrasi';
        $educationalInstitutions = $this->educationalInstitutionRepository->getEducationalInstitutionWithSchedule();

        return \view('home.register.index', compact('title', 'educationalInstitutions'));
    }
}
