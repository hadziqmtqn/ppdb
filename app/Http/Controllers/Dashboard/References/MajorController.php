<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\Major\MajorRequest;
use App\Models\Major;

class MajorController extends Controller
{
    public function index()
    {
        return Major::all();
    }

    public function store(MajorRequest $request)
    {
        return Major::create($request->validated());
    }

    public function show(Major $major)
    {
        return $major;
    }

    public function update(MajorRequest $request, Major $major)
    {
        $major->update($request->validated());

        return $major;
    }

    public function destroy(Major $major)
    {
        $major->delete();

        return response()->json();
    }
}
