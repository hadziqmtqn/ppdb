<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repositories\EducationalLevelRepository;
use App\Repositories\HomeRepository;
use Illuminate\View\View;

class HomeController extends Controller
{
    protected EducationalLevelRepository $educationalLevelRepository;
    protected HomeRepository $homeRepository;

    /**
     * @param EducationalLevelRepository $educationalLevelRepository
     * @param HomeRepository $homeRepository
     */
    public function __construct(EducationalLevelRepository $educationalLevelRepository, HomeRepository $homeRepository)
    {
        $this->educationalLevelRepository = $educationalLevelRepository;
        $this->homeRepository = $homeRepository;
    }

    public function index(): View
    {
        $title = 'Beranda';
        $educationalLevels = $this->educationalLevelRepository->getLevel();
        $quotas = $this->homeRepository->quotas();
        $schedules = $this->homeRepository->getSchedule();

        return \view('home.home.index', compact('title', 'educationalLevels', 'quotas', 'schedules'));
    }
}
