<div class="card mb-3">
    <h5 class="card-header">Menu</h5>
    <div class="card-body pt-0">
        <div class="demo-inline-spacing">
            <div class="list-group">
                <a href="{{ route('student-registration.index', $user->username) }}" class="list-group-item list-group-item-action {{ url()->current() == route('student-registration.index', $user->username) ? 'active' : '' }} waves-effect">
                    <i class="mdi mdi-account-plus-outline me-2"></i>Pendaftaran
                </a>
                <a href="javascript:void(0);" class="list-group-item list-group-item-action waves-effect">
                    <i class="mdi mdi-account-outline me-2"></i>Data Pribadi
                </a>
                <a href="javascript:void(0);" class="list-group-item list-group-item-action waves-effect">
                    <i class="mdi mdi-account-network me-2"></i>Keluarga
                </a>
                <a href="javascript:void(0);" class="list-group-item list-group-item-action waves-effect">
                    <i class="mdi mdi-map-marker-outline me-2"></i>Tempat Tinggal
                </a>
                <a href="javascript:void(0);" class="list-group-item list-group-item-action waves-effect">
                    <i class="mdi mdi-school-outline me-2"></i>Asal Sekolah
                </a>
            </div>
        </div>
    </div>
</div>