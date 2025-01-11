<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceOfRecidence\PlaceOfRecidenceRequest;
use App\Models\PlaceOfRecidence;

class PlaceOfRecidenceController extends Controller
{
    public function index()
    {
        return PlaceOfRecidence::all();
    }

    public function store(PlaceOfRecidenceRequest $request)
    {
        return PlaceOfRecidence::create($request->validated());
    }

    public function show(PlaceOfRecidence $placeOfRecidence)
    {
        return $placeOfRecidence;
    }

    public function update(PlaceOfRecidenceRequest $request, PlaceOfRecidence $placeOfRecidence)
    {
        $placeOfRecidence->update($request->validated());

        return $placeOfRecidence;
    }

    public function destroy(PlaceOfRecidence $placeOfRecidence)
    {
        $placeOfRecidence->delete();

        return response()->json();
    }
}
