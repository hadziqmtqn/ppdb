<?php

namespace App\Http\ViewComposers;

use App\Repositories\ApplicationRepository;
use App\Repositories\MenuRepository;
use App\Repositories\MyAccountRepository;
use App\Repositories\SchoolYearRepository;
use Illuminate\View\View;

class AppViewComposer
{
    protected ApplicationRepository $applicationRepository;
    protected MyAccountRepository $myAccountRepository;
    protected MenuRepository $menuRepository;
    protected SchoolYearRepository $schoolYearRepository;

    public function __construct(ApplicationRepository $applicationRepository, MyAccountRepository $myAccountRepository, MenuRepository $menuRepository, SchoolYearRepository $schoolYearRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->myAccountRepository = $myAccountRepository;
        $this->menuRepository = $menuRepository;
        $this->schoolYearRepository = $schoolYearRepository;
    }

    public function compose(View $view): void
    {
        $view->with('application', $this->applicationRepository->getApplication());
        $view->with('getSchoolYearActive', $this->schoolYearRepository->getSchoolYearActive());

        if (auth()->check()) {
            $view->with('myAccount', $this->myAccountRepository->myAccount());
            $view->with('listMenus', $this->menuRepository->getMenus());
        }
    }
}
