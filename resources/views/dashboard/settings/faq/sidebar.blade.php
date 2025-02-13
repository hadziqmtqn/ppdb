<div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
    <ul class="nav nav-align-left nav-pills flex-column">
        <li class="nav-item">
            <a href="{{ route('faq.index') }}" class="nav-link {{ url()->current() == route('faq.index') ? 'active' : '' }}">
                <i class="mdi mdi-information-outline me-1"></i>
                <span class="align-middle">FAQ</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('faq-category.index') }}" class="nav-link {{ url()->current() == route('faq-category.index') ? 'active' : '' }}">
                <i class="mdi mdi-information-variant-circle-outline me-1"></i>
                <span class="align-middle">FAQ Category</span>
            </a>
        </li>
    </ul>
</div>