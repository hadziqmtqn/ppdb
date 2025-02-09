@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>

    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.application.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            @foreach($getAssets as $getAsset)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ ucfirst($getAsset) }} Asset</h5>
                        <div class="mb-3">
                            <form action="{{ route('application.save-assets', $application['slug']) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input type="file" class="form-control" name="file[{{ $getAsset }}]" id="inputAssets-{{ $getAsset }}" aria-describedby="inputAsets" aria-label="Upload" accept=".jpg,.jpeg,.png">
                                    <button class="btn btn-outline-primary waves-effect" type="submit">Submit</button>
                                </div>
                                @include('layouts.session')
                            </form>
                        </div>
                        <div class="card shadow-none border-0">
                            <div class="table-responsive border rounded">
                                <table class="table">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap w-50">Nama File</th>
                                        <th class="text-nowrap text-center w-25">Ukuran</th>
                                        <th class="text-nowrap text-center w-25">Opsi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-nowrap text-heading">New customer sign up</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection