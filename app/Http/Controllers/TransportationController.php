<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transportation\TransportationRequest;
use App\Models\Transportation;

class TransportationController extends Controller
{
    public function index()
    {
        return Transportation::all();
    }

    public function store(TransportationRequest $request)
    {
        return Transportation::create($request->validated());
    }

    public function show(Transportation $transportation)
    {
        return $transportation;
    }

    public function update(TransportationRequest $request, Transportation $transportation)
    {
        $transportation->update($request->validated());

        return $transportation;
    }

    public function destroy(Transportation $transportation)
    {
        $transportation->delete();

        return response()->json();
    }
}
