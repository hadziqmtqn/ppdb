<div class="card mb-4">
    <div class="card-body">
        <div class="customer-avatar-section">
            <div class="d-flex align-items-center flex-column">
                <img class="img-fluid rounded mb-3 mt-4" src="{{ $photoUrl }}" height="120" width="120" alt="User avatar">
                <div class="customer-info text-center mb-4">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <span>{{ optional(optional($user->student)->educationalInstitution)->name }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around flex-wrap mb-4">
            <div class="d-flex align-items-center gap-2">
                <div class="avatar me-1">
                    <div class="avatar-initial rounded bg-label-primary">
                        <i class="mdi mdi mdi-tag-outline mdi-20px"></i>
                    </div>
                </div>
                <div>
                    <span>Kategori</span>
                    <h5 class="mb-0">{{ optional(optional($user->student)->registrationCategory)->name }}</h5>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="avatar me-1">
                    <div class="avatar-initial rounded bg-label-primary">
                        <i class="mdi mdi-sitemap-outline mdi-20px"></i>
                    </div>
                </div>
                <div>
                    <span>Jalur</span>
                    <h5 class="mb-0">{{ optional(optional($user->student)->registrationPath)->name }}</h5>
                </div>
            </div>
        </div>

        <div class="info-container">
            <h5 class="border-bottom text-uppercase pb-3">DETAIL</h5>
            <ul class="list-unstyled mb-4">
                <li class="mb-2">
                    <span class="h6 me-1">Email:</span>
                    <span>{{ $user->email }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Status:</span>
                    <span class="badge {{ $user->is_active ? 'bg-label-success' : 'bg-label-danger' }} rounded-pill">{{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Kontak:</span>
                    <span>{{ optional($user->student)->whatsapp_number }}</span>
                </li>
            </ul>
            @if(!auth()->user()->hasRole('user'))
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-outline-warning me-3 waves-effect waves-light" data-bs-target="#editUser" data-bs-toggle="modal">Edit Status Akun</a>
                </div>
            @endif
        </div>
    </div>
</div>