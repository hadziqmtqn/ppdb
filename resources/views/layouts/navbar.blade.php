<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-xxl">
        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="{{ route('home') }}" class="app-brand-link gap-2" target="_blank">
                <span class="app-brand-logo demo">
                    <img src="{{ $application['logo'] }}" alt="logo" style="width: 40px">
                </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="mdi mdi-close align-middle"></i>
            </a>
        </div>

        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="mdi mdi-menu mdi-24px"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Search -->
                <li class="nav-item navbar-search-wrapper me-1 me-xl-0">
                    <a class="nav-link search-toggler fw-normal" href="javascript:void(0);">
                        <i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl"></i>
                    </a>
                </li>
                <!-- /Search -->

                <!-- Style Switcher -->
                <li class="nav-item dropdown-style-switcher dropdown me-1 me-xl-0">
                    <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"><i class="mdi mdi-24px"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                <span class="align-middle"><i class="mdi mdi-weather-sunny me-2"></i>Light</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                <span class="align-middle"><i class="mdi mdi-weather-night me-2"></i>Dark</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                <span class="align-middle"><i class="mdi mdi-monitor me-2"></i>System</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- / Style Switcher-->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ $myAccount['photo'] }}" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('account.index') }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ $myAccount['photo'] }}" alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-medium d-block">{{ $myAccount['name'] }}</span>
                                        <small class="text-muted">{{ $myAccount['role'] }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('account.index') }}">
                                <i class="mdi mdi-account-outline me-2"></i>
                                <span class="align-middle">Akun Saya</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="mdi mdi-logout me-2"></i>
                                    <span class="align-middle">Keluar</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>

        <!-- Search Small Screens -->
        <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
            <input type="text" class="form-control search-input border-0" placeholder="Search..." aria-label="Search..." />
            <i class="mdi mdi-close search-toggler cursor-pointer"></i>
        </div>
    </div>
</nav>