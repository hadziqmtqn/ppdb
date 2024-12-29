@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('role.index') }}">Role</a> /</span>
        Edit {{ $title }}
    </h4>
    <div class="card mb-4">
        <div class="card-header header-elements d-flex justify-content-between">
            <h5 class="m-0 me-2">Edit {{ $title }}</h5>
        </div>
        <form action="{{ route('role.update', $role->slug) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}">
                    <label for="name">Nama</label>
                </div>
                <div class="row">
                    @foreach($models as $key => $model)
                        @php
                            $modelName = preg_replace('/^.*\\\\/', '', $model);
                        @endphp
                        <div class="col-md-6">
                            <div class="card shadow-none border-2 card-action mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-action-title mb-2">{{ ucwords(str_replace('_', ' ', Str::snake($modelName))) }}</h5>
                                        <p class="card-subtitle">{{ $model }}</p>
                                    </div>
                                </div>
                                <div class="card-body border-top border-1">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ Str::kebab($modelName . '-read') }}" id="{{ $modelName . '-read-' . $key }}" @checked(in_array(Str::kebab($modelName . '-read'), $role->permissions->pluck('name')->toArray()))>
                                                <label class="form-check-label" for="{{ $modelName . '-read-' . $key }}"> Read </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ Str::kebab($modelName . '-write') }}" id="{{ $modelName . '-write-' . $key }}" @checked(in_array(Str::kebab($modelName . '-write'), $role->permissions->pluck('name')->toArray()))>
                                                <label class="form-check-label" for="{{ $modelName . '-write-' . $key }}"> Write </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ Str::kebab($modelName . '-delete') }}" id="{{ $modelName . '-delete-' . $key }}" @checked(in_array(Str::kebab($modelName . '-delete'), $role->permissions->pluck('name')->toArray()))>
                                                <label class="form-check-label" for="{{ $modelName . '-delete-' . $key }}"> Delete </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @include('layouts.session')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/role/check-all.js') }}"></script>
@endsection