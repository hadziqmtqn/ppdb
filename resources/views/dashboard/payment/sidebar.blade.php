<div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
    <ul class="nav nav-align-left nav-pills flex-column">
        <li class="nav-item">
            <a href="{{ route('payment-setting.index') }}" class="nav-link {{ url()->current() == route('payment-setting.index') ? 'active' : '' }}">
                <i class="mdi mdi-credit-card-outline me-1"></i>
                <span class="align-middle">Pengaturan Pembayaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('payment-channel.index') }}" class="nav-link {{ url()->current() == route('payment-channel.index') ? 'active' : '' }}">
                <i class="mdi mdi-radar me-1"></i>
                <span class="align-middle">Saluran Pembayaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bank-account.index') }}" class="nav-link {{ url()->current() == route('bank-account.index') ? 'active' : '' }}">
                <i class="mdi mdi-bank-outline me-1"></i>
                <span class="align-middle">Rekening Bank</span>
            </a>
        </li>
    </ul>
    <div class="d-none d-md-block">
        <div class="mt-5 text-center">
            <img src="{{ url('https://hadziqmtqn.github.io/materialize/assets/img/illustrations/faq-illustration.png') }}" class="img-fluid w-px-120" alt="FAQ Image" />
        </div>
    </div>
</div>