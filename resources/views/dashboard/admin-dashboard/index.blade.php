@extends('layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-md-12 col-lg-8">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h4 class="card-title mb-1 d-flex gap-2 flex-wrap">Congratulations {{ auth()->user()->name }}! 🎉</h4>
                    <p class="pb-0">Fokuslah untuk mencapai tujuanmu, meskipun banyak hal yang menarik dalam perjalanannya.</p>
                    <h4 class="text-primary mb-1">$42.8k</h4>
                    <p class="mb-2 pb-1">78% of target 🚀</p>
                    <a href="#" class="btn btn-sm btn-primary waves-effect waves-light">View Sales</a>
                </div>
                <img src="{{ url('https://hadziqmtqn.github.io/materialize/assets/img/illustrations/trophy.png') }}" class="position-absolute bottom-0 end-0 me-3" height="140" alt="view sales">
            </div>
        </div>
    </div>
@endsection