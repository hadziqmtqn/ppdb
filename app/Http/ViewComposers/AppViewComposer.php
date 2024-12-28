<?php

namespace App\Http\ViewComposers;

use App\Repositories\ApplicationRepository;
use App\Repositories\MenuRepository;
use App\Repositories\MyAccountRepository;
use Illuminate\View\View;

class AppViewComposer
{
    protected ApplicationRepository $applicationRepository;
    protected MyAccountRepository $myAccountRepository;
    protected MenuRepository $menuRepository;

    public function __construct(ApplicationRepository $applicationRepository, MyAccountRepository $myAccountRepository, MenuRepository $menuRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->myAccountRepository = $myAccountRepository;
        $this->menuRepository = $menuRepository;
    }

    public function compose(View $view): void
    {
        $view->with('application', $this->applicationRepository->getApplication());

        if (auth()->check()) {
            $view->with('myAccount', $this->myAccountRepository->myAccount());
            $view->with('listMenus', $this->menuRepository->getMenus());
        }
    }
}
