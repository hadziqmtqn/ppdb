<div class="modal fade" id="modalRegister" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Registrasi Akun Baru</h3>
                </div>
                <form onsubmit="return false" id="formCreate" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <input type="hidden" name="educational_institution_id" id="select-educational-institution">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" value="" id="educationName" disabled>
                            <label for="educationName">Lembaga Pendidikan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="registration_category_id" class="form-select select2" id="select-registration-category"></select>
                            <label for="select-registration-category">Kategori Pendaftaran</label>
                        </div>
                        <div id="registrationPathsContainer">
                            <div id="showRegistrationPaths">
                                <div class="form-floating form-floating-outline mb-3">
                                    <select name="registration_path_id" class="form-select select2" id="select-registration-path"></select>
                                    <label for="select-registration-path">Jalur Pendaftaran</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="class_level_id" class="form-select select2" id="select-class-level"></select>
                            <label for="select-class-level">Kelas</label>
                        </div>
                        <div id="showMajorsContainer">
                            <div id="showMajors">
                                <div class="form-floating form-floating-outline mb-3">
                                    <select name="major_id" class="form-select select2" id="select-major"></select>
                                    <label for="select-major">Jurusan</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama">
                            <label for="name">Nama</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" id="whatsapp_number" class="form-control phone-number-mask" minlength="10" maxlength="13" placeholder="No. Whatsapp">
                            <label for="whatsapp_number">No. Whatsapp</label>
                        </div>
                        <div class="form-password-toggle mb-3">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="password" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multicol-password2" />
                                    <label for="password">Kata Sandi</label>
                                </div>
                                <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                            </div>
                        </div>
                        <div class="form-password-toggle mb-3">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multicol-confirm-password2" />
                                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                                </div>
                                <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
