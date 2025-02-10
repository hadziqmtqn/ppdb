<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repositories\EducationalLevelRepository;
use Illuminate\View\View;

class HomeController extends Controller
{
    protected EducationalLevelRepository $educationalLevelRepository;

    /**
     * @param EducationalLevelRepository $educationalLevelRepository
     */
    public function __construct(EducationalLevelRepository $educationalLevelRepository)
    {
        $this->educationalLevelRepository = $educationalLevelRepository;
    }

    public function index(): View
    {
        $title = 'Beranda';
        $educationalLevels = $this->educationalLevelRepository->getLevel();

        return \view('home.home.index', compact('title', 'educationalLevels'));
    }
}
