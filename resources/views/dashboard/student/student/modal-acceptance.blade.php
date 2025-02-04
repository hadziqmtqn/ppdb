<div class="modal fade" id="acceptanceRegistrationModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Penerimaan Pendaftaran</h3>
                </div>
                <form id="formAcceptance" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false" data-username="{{ $user->username }}">
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="alert alert-outline-warning d-flex align-items-center" role="alert">
                            <i class="mdi mdi-alert-outline me-2"></i>
                            <span class="text-dark">Sebelum mengubah status registrasi, pastikan data registrasi telah valid. <strong class="text-warning">Setiap perubahan akan mengirim pesan otomatis ke Siswa yang bersangkutan!</strong></span>
                        </div>
                        <div class="row select-status-option">
                            @foreach(['belum_diterima' => 'warning', 'diterima' => 'primary', 'ditolak' => 'danger'] as $acceptance => $color)
                                <div class="col-lg-4 col-md-12">
                                    <div class="list-group mb-2">
                                        <label class="list-group-item cursor-pointer border-{{ $color }} border-2">
                                            <span class="form-check form-check-{{ $color }} mb-0"><input class="form-check-input me-1" type="radio" id="{{ $acceptance }}" name="registration_status" value="{{ $acceptance }}" {{ optional($user->student)->registration_status == $acceptance ? 'checked' : '' }}>{{ ucfirst(str_replace('_', ' ', $acceptance)) }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit-acceptance">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
