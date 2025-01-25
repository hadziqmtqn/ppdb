@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <form action="{{ route('whatsapp-config.store') }}" method="post" id="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="url" name="domain" id="domain" class="form-control" placeholder="Domain/Endpoint" value="{{ $whatsappConfig->domain }}">
                            <label for="domain">Domain/Endpoint</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="api_key" id="api_key" class="form-control" placeholder="API Key" value="{{ $whatsappConfig->api_key }}">
                            <label for="api_key">API Key</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="is_active" id="is_active" class="form-select select2">
                                <option value="0" @selected($whatsappConfig->is_active == 0)>Tidak</option>
                                <option value="1" @selected($whatsappConfig->is_active == 1)>Ya</option>
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
    <script src="{{ asset('js/whatsapp-config/validation.js') }}"></script>
@endsection