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
                        <div class="demo-inline-spacing mt-3">
                            <ul class="list-group">
                                @foreach($files as $file => $asset)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between w-100">
                                            <h5 class="mb-1">{{ $asset['fileName'] }}</h5>
                                            @if($asset['fileUrl'])
                                                <a href="{{ url($asset['fileUrl']) }}" class="btn btn-xs btn-outline-primary" target="_blank">Lihat</a>
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