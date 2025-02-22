<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreviousSchoolReference\PreviousSchoolReferenceRequest;
use App\Models\PreviousSchoolReference;
use App\Repositories\References\PreviousSchoolReferenceRepository;
use Illuminate\Http\Request;

class PreviousSchoolReferenceController extends Controller
{
    protected PreviousSchoolReferenceRepository $previousSchoolReferenceRepository;

    /**
     * @param PreviousSchoolReferenceRepository $previousSchoolReferenceRepository
     */
    public function __construct(PreviousSchoolReferenceRepository $previousSchoolReferenceRepository)
    {
        $this->previousSchoolReferenceRepository = $previousSchoolReferenceRepository;
    }

    public function index()
    {
        return PreviousSchoolReference::all();
    }

    public function store(PreviousSchoolReferenceRequest $request)
    {
        return PreviousSchoolReference::create($request->validated());
    }

    public function show(PreviousSchoolReference $previousSchoolReference)
    {
        return $previousSchoolReference;
    }

    public function update(PreviousSchoolReferenceRequest $request, PreviousSchoolReference $previousSchoolReference)
    {
        $previousSchoolReference->update($request->validated());

        return $previousSchoolReference;
    }

    public function destroy(PreviousSchoolReference $previousSchoolReference)
    {
        $previousSchoolReference->delete();

        return response()->json();
    }

    // TODO Select
    public function select(Request $request)
    {
        return $this->previousSchoolReferenceRepository->select($request);
    }
}
