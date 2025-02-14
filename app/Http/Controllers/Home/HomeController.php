<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\FaqCategoryFilterRequest;
use App\Http\Requests\Faq\FilterRequest;
use App\Models\EducationalInstitution;
use App\Repositories\EducationalLevelRepository;
use App\Repositories\FaqRepository;
use App\Repositories\HomeRepository;
use Illuminate\View\View;

class HomeController extends Controller
{
    protected EducationalLevelRepository $educationalLevelRepository;
    protected HomeRepository $homeRepository;
    protected FaqRepository $faqRepository;

    /**
     * @param EducationalLevelRepository $educationalLevelRepository
     * @param HomeRepository $homeRepository
     * @param FaqRepository $faqRepository
     */
    public function __construct(EducationalLevelRepository $educationalLevelRepository, HomeRepository $homeRepository, FaqRepository $faqRepository)
    {
        $this->educationalLevelRepository = $educationalLevelRepository;
        $this->homeRepository = $homeRepository;
        $this->faqRepository = $faqRepository;
    }

    public function index(): View
    {
        $title = 'Beranda';
        $educationalLevels = $this->educationalLevelRepository->getLevel();
        $quotas = $this->homeRepository->quotas();
        $schedules = $this->homeRepository->getSchedule();
        $registrationSteps = $this->homeRepository->getRegistrationSteps();
        $educationalInstitutions = EducationalInstitution::select(['id', 'name'])
            ->get();

        return \view('home.home.index', compact('title', 'educationalLevels', 'quotas', 'schedules', 'registrationSteps', 'educationalInstitutions'));
    }

    public function getFaqCategories(FaqCategoryFilterRequest $request)
    {
        return $this->faqRepository->getFaqCategories($request);
    }

    public function getFaqs(FilterRequest $request)
    {
        return $this->faqRepository->getFaqs($request);
    }
}
