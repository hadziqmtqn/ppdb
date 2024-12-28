@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('role.index') }}">Role</a> /</span>
        Edit {{ $title }}
    </h4>
    <div class="card mb-4">
        <div class="card-header header-elements">
            <h5 class="m-0 me-2">Edit {{ $title }}</h5>
        </div>
        <form action="{{ route('role.update', $role->slug) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-flush-spacing">
                        <tbody>
                        <tr>
                            <td class="text-nowrap fw-medium">
                                {{ ucfirst(str_replace('-', ' ', $role->name)) }} Access
                                <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system"></i>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="form-check col-md-4">
                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                        <label class="form-check-label" for="selectAll"> Pilih Semua </label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{--@foreach($permissions as $permission)
                            <tr>
                                <td class="text-nowrap fw-medium">{{ $permission->name }}</td>
                                <td>
                                    <div class="row">
                                        @foreach($permission['permissions'] as $key => $roleHasPermission)
                                            <div class="form-check col-md-4">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" id="permission-{{ $permission['name'] }}-{{ $key }}" {{ in_array($roleHasPermission->id, $role['role_has_permissions']->pluck('permission_id')->toArray()) ? 'checked' : '' }} value="{{ $roleHasPermission->name }}" />
                                                <label class="form-check-label" for="permission-{{ $permission['name'] }}-{{ $key }}"> {{ $roleHasPermission->name }} </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
            </div>
        </form>
    </div>
@endsection