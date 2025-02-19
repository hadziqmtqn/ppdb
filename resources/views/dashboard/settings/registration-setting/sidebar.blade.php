<div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
    <ul class="nav nav-align-left nav-pills flex-column">
        <li class="nav-item">
            <a href="{{ route('registration-setting.index') }}" class="nav-link {{ url()->current() == route('registration-setting.index') ? 'active' : '' }}">
                <i class="mdi mdi-account-check-outline me-1"></i>
                <span class="align-middle">Pengaturan Registrasi</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('educational-group.index') }}" class="nav-link {{ url()->current() == route('educational-group.index') ? 'active' : '' }}">
                <i class="mdi mdi-chart-histogram me-1"></i>
                <span class="align-middle">Kelompok Pendidikan</span>
            </a>
        </li>
    </ul>
</div>