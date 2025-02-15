@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>

    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.application.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            <div class="card mb-3">
                <h5 class="card-header">{{ $title }}</h5>
                <form action="{{ route('application.store') }}" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama" value="{{ $application['name'] }}">
                                    <label for="name">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" name="foundation" id="foundation" class="form-control" placeholder="Nama Yayasan" value="{{ $application['foundation'] }}">
                                    <label for="foundation">Nama Yayasan</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="url" name="website" id="website" class="form-control" placeholder="Website" value="{{ $application['website'] }}">
                                    <label for="website">Website</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="url" name="main_website" id="main_website" class="form-control" placeholder="Website Utama" value="{{ $application['mainWebsite'] }}">
                                    <label for="main_website">Website Utama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <select name="register_verification" id="register_verification" class="form-select select2">
                                        <option value="0" @selected($application['registerVerification'] == '0')>Tidak</option>
                                        <option value="1" @selected($application['registerVerification'] == '1')>Ya</option>
                                    </select>
                                    <label for="register_verification">Verifikasi Akun</label>
                                    <small class="fst-italic">Pengguna baru harus memverifikasi akun setelah registrasi</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <select name="notification_method" id="notification_method" class="form-select select2">
                                        <option value="email" @selected($application['notificationMethod'] == 'email')>Email</option>
                                        <option value="whatsapp" @selected($application['notificationMethod'] == 'whatsapp')>Whatsapp</option>
                                    </select>
                                    <label for="notification_method">Metode Notifikasi</label>
                                    <small class="fst-italic">Metode pesan dikirim ke pengguna</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="number" name="whatsapp_number" id="whatsapp_number" class="form-control" placeholder="No. Whatsapp" value="{{ $application['whatsappNumber'] }}">
                                    <label for="whatsapp_number">No. Whatsapp</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="file" name="logo" id="logo" class="form-control" accept=".jpg,.jpeg,.png">
                                    <label for="logo">Logo</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-3">
                                    <textarea name="description" id="description" class="form-control textarea-autosize" placeholder="Deskripsi">{{ $application['description'] }}</textarea>
                                    <label for="description">Deskripsi</label>
                                </div>
                            </div>
                        </div>
                        @include('layouts.session')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/application/validation.js') }}"></script>
@endsection