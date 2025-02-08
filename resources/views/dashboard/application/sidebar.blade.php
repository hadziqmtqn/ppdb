<div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
    <ul class="nav nav-align-left nav-pills flex-column">
        <li class="nav-item">
            <a href="{{ route('application.index') }}" class="nav-link {{ url()->current() == route('application.index') ? 'active' : '' }}">
                <i class="mdi mdi-apps me-1"></i>
                <span class="align-middle">Aplikasi</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('application.assets', $application['slug']) }}" class="nav-link {{ url()->current() == route('application.assets', $application['slug']) ? 'active' : '' }}">
                <i class="mdi mdi-picture-in-picture-top-right-outline me-1"></i>
                <span class="align-middle">Assets</span>
            </a>
        </li>
    </ul>
    <div class="d-none d-md-block">
        <div class="mt-5 text-center">
            <img src="{{ asset('materialize/assets/img/illustrations/faq-illustration.png') }}" class="img-fluid w-px-120" alt="FAQ Image" />
        </div>
    </div>
</div>