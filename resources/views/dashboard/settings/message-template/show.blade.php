@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('message-template.index') }}">{{ $title }}</a> /</span>
        Detail {{ $title }}
    </h4>
    <div class="card mb-4">
        <h5 class="card-header">Detail {{ $title }}</h5>
        <form action="{{ route('message-template.update', $messageTemplate->slug) }}" id="form" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="title" id="title" class="form-control" value="{{ $messageTemplate->title }}" placeholder="Judul">
                    <label for="title">Judul</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="educational_institution_id" id="select-educational-institution" class="form-select select2">
                        <option value="{{ $messageTemplate->educational_institution_id }}" selected>{{ optional($messageTemplate->educationalInstitution)->name }}</option>
                    </select>
                    <label for="select-educational-institution">Lembaga</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="category" id="category" class="form-select select2">
                        <option value=""></option>
                        @foreach($messageCategories as $messageCategory)
                            <option value="{{ $messageCategory }}" {{ $messageTemplate->category == $messageCategory ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $messageCategory)) }}</option>
                        @endforeach
                    </select>
                    <label for="category">Kategori</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="recipient" id="recipient" class="form-select select2">
                        <option value=""></option>
                        @foreach($recipients as $recipient)
                            <option value="{{ $recipient->name }}" {{ $messageTemplate->recipient == $recipient->name ? 'selected' : '' }}>{{ ucfirst(str_replace('-', ' ', $recipient->name)) }}</option>
                        @endforeach
                        <option value="all" {{ $messageTemplate->recipient == 'all' ? 'selected' : '' }}>Semua</option>
                    </select>
                    <label for="recipient">Penerima</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <textarea name="message" id="message" style="height: 200px" class="form-control" placeholder="Pesan">{{ $messageTemplate->message }}</textarea>
                    <label for="message">Pesan</label>
                    <small class="text-danger fst-italic">Anda tidak boleh mengganti kode teks bertanda kurung kurawal seperti <strong>{nama_aplikasi}</strong></small>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="is_active" id="isActive" class="form-select select2">
                        <option value=""></option>
                        <option value="1" @selected($messageTemplate->is_active == 1)>Aktif</option>
                        <option value="0" @selected($messageTemplate->is_active == 0)>Tidak Aktif</option>
                    </select>
                    <label for="isActive">Status Aktif</label>
                </div>
                @include('layouts.session')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-outline-secondary">Batal</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/message-template/validation.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
@endsection