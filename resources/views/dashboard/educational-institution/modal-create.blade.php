<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Tambah {{ $title }}</h3>
                </div>
                <form action="{{ route('educational-institution.store') }}" id="form" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_level_id" id="select-educational-level" class="form-select select2"></select>
                            <label for="select-educational-level">Level Pendidikan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nama" value="{{ old('name') }}">
                            <label for="name">Nama</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="url" class="form-control" name="website" id="website" placeholder="Website" value="{{ old('website') }}">
                            <label for="website">Website</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="province" id="select-province" class="form-select select2" data-allow-clear="true"></select>
                            <label for="select-province">Provinsi</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="city" id="select-city" class="form-select select2" data-allow-clear="true"></select>
                            <label for="select-city">Kota/Kabupaten</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="district" id="select-district" class="form-select select2" data-allow-clear="true"></select>
                            <label for="select-district">Kecamatan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="village" id="select-village" class="form-select select2" data-allow-clear="true"></select>
                            <label for="select-village">Desa/Kelurahan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="street" id="street" class="form-control" value="{{ old('street') }}" placeholder="Jalan">
                            <label for="street">Jalan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="number" name="postal_code" class="form-control" id="postal_code" value="{{ old('postal_code') }}" placeholder="Kode Pos">
                            <label for="postal_code">Kode Pos</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <textarea name="profile" class="form-control" id="profile" style="min-height: 100px" placeholder="Pofil Singkat">{{ old('profile') }}</textarea>
                            <label for="profile">Profil</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="file" name="logo" class="form-control" id="logo" accept=".jpg,,jpeg,.png">
                            <label for="logo">Logo</label>
                        </div>
                        @include('layouts.session')
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
