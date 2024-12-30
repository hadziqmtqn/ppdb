@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <form action="{{ route('email-config.store') }}" method="post" id="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="email" name="mail_username" id="mail_username" class="form-control" placeholder="Username" value="{{ $emailConfig->mail_username }}">
                            <label for="mail_username">Username</label>
                        </div>
                    </div>
                    <div class="col-md-6 form-password-toggle">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control" type="password" id="mailPasswordApp" name="mail_password_app" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" value="{{ $emailConfig->mail_password_app }}" />
                                <label for="mailPasswordApp">Kata Sandi Aplikasi</label>
                            </div>
                            <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="is_active" id="is_active" class="form-select select2">
                                <option value="0" @selected($emailConfig->is_active == 0)>Tidak</option>
                                <option value="1" @selected($emailConfig->is_active == 1)>Ya</option>
                            </select>
                            <label for="is_active">Status Aktif</label>
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
@endsection

@section('scripts')
    <script src="{{ asset('js/email-config/validation.js') }}"></script>
@endsection