<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaFile\MediaFileRequest;
use App\Models\MediaFile;

class MediaFileController extends Controller
{
    public function index()
    {
        return MediaFile::all();
    }

    public function store(MediaFileRequest $request)
    {
        return MediaFile::create($request->validated());
    }

    public function show(MediaFile $file)
    {
        return $file;
    }

    public function update(MediaFileRequest $request, MediaFile $file)
    {
        $file->update($request->validated());

        return $file;
    }

    public function destroy(MediaFile $file)
    {
        $file->delete();

        return response()->json();
    }
}
