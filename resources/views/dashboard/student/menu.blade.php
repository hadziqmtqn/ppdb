<div class="card mb-3">
    <div class="card-header header-elements">
        <h5 class="me-2">Menu</h5>
        <div class="card-header-elements ms-auto">
            <a href="{{ route('student.show', $user->username) }}" class="btn btn-sm btn-primary waves-effect waves-light">
                <span class="tf-icon mdi mdi-arrow-left me-1"></span>Detail
            </a>
        </div>
    </div>
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
        @if(optional(optional(optional($user->student)->educationalInstitution)->registrationSetting)->accepted_with_school_report)
            <div class="demo-inline-spacing">
                <div class="list-group">
                    <a href="{{ route('school-report.index', $user->username) }}" class="list-group-item list-group-item-primary {{ url()->current() == route('school-report.index', $user->username) ? 'active' : '' }} waves-effect">
                    <span class="d-flex justify-content-between">
                        <span><i class="mdi mdi-file-document-outline me-2"></i>Nilai Rapor</span>
                        <span><i class="mdi mdi-information-outline text-warning" data-bs-toggle="tooltip" title="Belum Lengkap"></i></span>
                    </span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>