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
            <input type="hidden" name="username" value="{{ $user->username }}">
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
                                <input type="hidden" name="lesson_id" value="{{ $report['lessonId'] }}">
                                <tr>
                                    <td>{{ $report['lessonName'] }}</td>
                                    <td>
                                        <input type="number" name="score" value="{{ $report['score'] }}" class="form-control" aria-label="Score">
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

@endsection