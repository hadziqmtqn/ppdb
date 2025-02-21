@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('school-report') }}">Nilai Rapor</a> /</span>
        {{ $subTitle }}
    </h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $subTitle }}</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="card shadow-none border">
                        <div class="card-body p-2 d-flex justify-content-between flex-wrap gap-3">
                            <div class="d-flex gap-3">
                                <div class="avatar">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <i class="mdi mdi-account-outline mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="card-info">
                                    <h4 class="mb-1 text-primary">{{ $user->name }}</h4>
                                    <h6 class="mb-0 fw-normal"><i class="mdi mdi-account-card-outline me-1"></i>{{ optional($user->student)->registration_number }}</h6>
                                    <h6 class="mb-0 fw-normal"><i class="mdi mdi-office-building-outline me-1"></i>{{ optional(optional($user->student)->educationalInstitution)->name }}</h6>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="avatar">
                                    <div class="avatar-initial bg-label-info rounded">
                                        <i class="mdi mdi-trending-up mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="card-info">
                                    <h4 class="mb-0">{{ $schoolReports['totalScore'] }}</h4>
                                    <small>Total Skor</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    @foreach($schoolReports['schoolReports'] as $schoolReport)
                        <div class="alert alert-primary alert-dismissible" role="alert">
                            Nilai Raport Semester {{ $schoolReport['semester'] }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="card shadow-none border mb-2">
                            <div class="table-responsive rounded-3">
                                <table class="table">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Skor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($schoolReport['detailSchoolReports'] as $detailSchoolReport)
                                        <tr>
                                            <td>{{ $detailSchoolReport['lessonName'] }}</td>
                                            <td>{{ $detailSchoolReport['score'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td class="fw-bold">Skor</td>
                                        <td class="fw-bold">{{ $schoolReport['totalScore'] }}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection