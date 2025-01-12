<div class="card mb-3">
    <h5 class="card-header">Menu</h5>
    <div class="card-body pt-0">
        <div class="demo-inline-spacing">
            <div class="list-group">
                @foreach($menus as $key => $menu)
                    <a href="{{ $menu['url'] }}" class="list-group-item list-group-item-action {{ url()->current() == $menu['url'] ? 'active' : '' }} waves-effect">
                        <span class="d-flex justify-content-between">
                            <span><i class="mdi {{ $menu['icon'] }} me-2"></i>{{ $key }}</span>
                            <span><i class="mdi mdi-{{ $menu['isCompleted'] ? 'check text-success' : 'information-outline text-warning' }}" data-bs-toggle="tooltip" title="{{ $menu['isCompleted'] ? 'Lengkap' : 'Belum Lengkap' }}"></i></span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>