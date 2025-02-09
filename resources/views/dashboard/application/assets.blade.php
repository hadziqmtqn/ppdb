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
                        <h5 class="card-title mb-3">{{ ucfirst($getAsset['asset']) }} Asset</h5>
                        <div class="alert alert-outline-warning mb-4" role="alert">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-information-outline mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">Keterangan</div>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($getAsset['notes'] as $note)
                                            <li>{{ $note }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="mb-3">
                            <form action="{{ route('application.save-assets', $application['slug']) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input type="file" class="form-control" name="file[{{ $getAsset['asset'] }}]" id="inputAssets-{{ $getAsset['asset'] }}" aria-describedby="inputAsets" aria-label="Upload" accept=".jpg,.jpeg,.png">
                                    <button class="btn btn-outline-primary waves-effect" type="submit">Upload</button>
                                </div>
                                @include('layouts.session')
                            </form>
                        </div>
                        <hr>
                        <div class="card shadow-none border-0">
                            <div class="table-responsive border rounded">
                                <table class="table">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap w-50">Nama File</th>
                                        <th class="text-nowrap w-25">Ukuran</th>
                                        <th class="text-nowrap w-25">Opsi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($getAsset['media'] as $asset)
                                        <tr>
                                            <td class="text-nowrap text-heading">{{ $asset['fileName'] }}</td>
                                            <td>{{ $asset['fileSize'] }}</td>
                                            <td>
                                                <form action="{{ route('application.delete-assets', $application['slug']) }}" method="post" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="collection[{{ $asset['fileId'] }}]" value="{{ $getAsset['asset'] }}">
                                                    <a href="{{ $asset['fileUrl'] }}" class="btn btn-sm btn-outline-dark" target="_blank">Lihat</a>
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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

@section('scripts')
    <script src="{{ asset('js/application/delete-assets.js') }}"></script>
@endsection