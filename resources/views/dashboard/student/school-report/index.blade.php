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
            <div class="alert alert-outline-warning alert-dismissible mb-4" role="alert">
                <h4 class="alert-heading d-flex align-items-center">
                    <i class="mdi mdi-information-outline mdi-24px me-2"></i>Keterangan
                </h4>
                <div class="mb-0 text-dark">
                    <ul>
                        <li>Ketika nilai rapor sudah tersimpan Anda tidak bisa mengubah pilihan <span class="fw-bold">Kelompok Pendidikan</span> pada Data Asal Sekolah.</li>
                        <li>Upload rapor dalam bentuk <span class="fw-bold">PDF</span> tiap semester dengan maksimal 3MB.</li>
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <input type="hidden" name="username" value="{{ $user->username }}" id="username">
            <form onsubmit="return false" id="form" data-username="{{ $user->username }}">
                @foreach($schoolReports as $semester => $schoolReport)
                    <div class="card mb-3">
                        <h5 class="card-header">Nilai Rapor Pada Asal Sekolah di Semester {{ $semester }}</h5>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>Nilai</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schoolReport['detailSchoolReports'] as $report)
                                    <tr>
                                        <td>{{ $report['lessonName'] }}</td>
                                        <td>
                                            <input type="number" name="score" value="{{ $report['score'] }}" class="form-control score-input" aria-label="Score" data-semester="{{ $semester }}" data-lesson-id="{{ $report['lessonId'] }}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <div class="alert alert-outline-dark d-flex align-items-center mb-2" role="alert">
                                <i class="mdi mdi-alert-rhombus-outline me-2"></i>
                                File diupload setelah selesai mengisi nilai rapor diatas.
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between w-100">
                                        <h5 class="mb-1">Upload Rapor Semester {{ $semester }}</h5>
                                        {{----}}
                                        {{--<div class="btn-group" role="group">
                                            <a href="#" type="button" class="btn btn-outline-secondary btn-xs waves-effect" target="_blank">Lihat</a>
                                            <button type="button" class="btn btn-outline-danger btn-xs waves-effect btn-delete-file" data-username="{{ $user->username }}" data-file-name="rapor_semester_{{ $semester }}">Hapus</button>
                                        </div>--}}
                                        {{----}}
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <input type="file" class="filepond" name="rapor_semester_{{ $semester }}" data-slug="{{ $schoolReport['slug'] }}" id="filepond_{{ $semester }}" data-semester="{{ $semester }}" data-allow-reorder="false" data-max-file-size="3MB" data-max-files="1">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/school-report/create.js') }}"></script>
    <script src="{{ asset('js/student/school-report/file-uploading.js') }}"></script>
@endsection