@extends('layouts.master')
@section('content')
    <div class="row gy-4">
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
@endsection