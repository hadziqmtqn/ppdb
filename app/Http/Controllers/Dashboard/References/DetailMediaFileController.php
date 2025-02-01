<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaFile\DetailMediaFileRequest;
use App\Models\DetailMediaFile;

class DetailMediaFileController extends Controller
{
    public function index()
    {
        return DetailMediaFile::all();
    }

    public function store(DetailMediaFileRequest $request)
    {
        return DetailMediaFile::create($request->validated());
    }

    public function show(DetailMediaFile $detailMediaFile)
    {
        return $detailMediaFile;
    }

    public function update(DetailMediaFileRequest $request, DetailMediaFile $detailMediaFile)
    {
        $detailMediaFile->update($request->validated());

        return $detailMediaFile;
    }

    public function destroy(DetailMediaFile $detailMediaFile)
    {
        $detailMediaFile->delete();

        return response()->json();
    }
}
