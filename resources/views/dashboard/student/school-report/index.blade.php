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