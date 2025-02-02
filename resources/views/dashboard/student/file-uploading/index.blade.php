@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('student.index') }}">Siswa</a> /</span>
        Pendaftaran
    </h4>
    <div class="row">
        <div class="col-md-4">
            @include('dashboard.student.menu')
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <h5 class="card-header">Unggah Berkas</h5>
                <form id="form" onsubmit="return false" data-username="{{ $user->username }}">
                    <div class="card-body">
                        <div class="alert alert-outline-primary alert-dismissible" role="alert">
                            <h4 class="alert-heading d-flex align-items-center">
                                <i class="mdi mdi-check-circle-outline mdi-24px me-2"></i>Panduan 🚀
                            </h4>
                            <hr>
                            <ul class="ps-3">
                                <li>Semua berkas wajib diupload</li>
                                <li>Berkas yang diizinkan hanya berupa file Gambar (.jpg,.jpeg,.png) dan PDF</li>
                                <li>Tiap berkas maksimal 2MB</li>
                                <li>Berkas yang telah diupload terdapat tanda tombol <strong>Lihat</strong> dan <strong>Hapus</strong></li>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <hr>
                        <div class="demo-inline-spacing mt-3">
                            <ul class="list-group">
                                @foreach($files as $file => $asset)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between w-100">
                                            <h5 class="mb-1">{{ $asset['fileName'] }}</h5>
                                            @if($asset['fileUrl'])
                                                <div class="btn-group" role="group">
                                                    <a href="{{ url($asset['fileUrl']) }}" type="button" class="btn btn-outline-secondary btn-xs waves-effect" target="_blank">Lihat</a>
                                                    <button type="button" class="btn btn-outline-danger btn-xs waves-effect btn-delete-file" data-username="{{ $user->username }}" data-file-name="{{ $file }}">Hapus</button>
                                                </div>
                                            @endif
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <input type="file" class="filepond" name="{{ $file }}" data-allow-reorder="false" data-max-file-size="2MB" data-max-files="1">
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/file-uploading/file-uploading.js') }}"></script>
@endsection