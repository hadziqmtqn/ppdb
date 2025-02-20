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
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/school-report/create.js') }}"></script>
@endsection