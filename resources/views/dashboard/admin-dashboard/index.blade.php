@extends('layouts.master')
@section('content')
    <div class="row gy-4 mb-4">
        <div class="col-xl-8 col-md-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title mb-2 d-flex gap-2 flex-wrap">Congratulations {{ auth()->user()->name }}! 🎉</h4>
                    <p class="pb-4">Fokuslah untuk mencapai tujuanmu, meskipun banyak hal yang menarik dalam perjalanannya. 🚀</p>
                    <a href="{{ route('student.index') }}" class="btn btn-sm btn-primary waves-effect waves-light">Lihat Data Siswa</a>
                </div>
                <img src="{{ url('https://hadziqmtqn.github.io/materialize/assets/img/illustrations/trophy.png') }}" class="position-absolute bottom-0 end-0 me-3" height="140" alt="view sales">
            </div>
        </div>
        {{--TODO Base Data--}}
        @foreach($totalBaseDatas as $key => $totalBaseData)
            <div class="col-xl-2 col-lg-3 col-sm-4 col-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-{{ $totalBaseData['color'] }} rounded">
                                    <i class="mdi mdi-{{ $totalBaseData['icon'] }} mdi-24px"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-info mt-4 pt-1">
                            <h5 class="mb-2">{{ $totalBaseData['total'] }}</h5>
                            <p data-bs-toggle="tooltip" title="{{ $totalBaseData['title'] }}">{{ $key }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{--TODO Close Base Data--}}
    </div>

    {{--TODO Select Option--}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="mdi mdi-filter me-2"></i>Filter Data</h5>
        </div>
        <div class="card-body pb-2">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3 filter">
                        <select name="" id="select-school-year" class="form-select select2">
                            <option value="{{ $getSchoolYearActive['id'] }}">{{ $getSchoolYearActive['year'] }}</option>
                        </select>
                        <label for="select-school-year">Tahun Ajaran</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3 filter">
                        <select name="" id="select-educational-institution" class="form-select select2" data-allow-clear="true"></select>
                        <label for="select-educational-institution">Lembaga Pendidikan</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--TODO Student Stats--}}
    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    @foreach($stats as $key => $stat)
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start card-widget-1 {{ !$loop->last ? 'border-end' : '' }} pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-1" id="{{ $stat['id'] }}">{{ $stat['total'] }}</h3>
                                    <p class="mb-0">{{ $key }}</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary"><i class="mdi mdi-{{ $stat['icon'] }} text-heading mdi-20px"></i></span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{--TODO Close Student Stats--}}

    {{--TODO Previous School Reference--}}
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-datatable">
                    <table class="table table-striped text-nowrap" id="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>NPSN</th>
                            <th>Asal Sekolah</th>
                            <th>Kelompok Pendidikan</th>
                            <th>Jumlah Siswa</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--TODO Close Previous School Reference--}}
@endsection

@section('scripts')
    <script src="{{ asset('js/school-year/select.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/dashboard/admin/student-stats.js') }}"></script>
    <script src="{{ asset('js/dashboard/admin/previous-school-reference-datatable.js') }}"></script>
@endsection