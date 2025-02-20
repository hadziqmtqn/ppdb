<?php

namespace App\Http\Controllers\Dashboard\SchoolReport;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolReport\SchoolReportRequest;
use App\Models\SchoolReport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SchoolReportController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', SchoolReport::class);

        return SchoolReport::all();
    }

    public function store(SchoolReportRequest $request)
    {
        $this->authorize('create', SchoolReport::class);

        return SchoolReport::create($request->validated());
    }

    public function show(SchoolReport $schoolReport)
    {
        $this->authorize('view', $schoolReport);

        return $schoolReport;
    }

    public function update(SchoolReportRequest $request, SchoolReport $schoolReport)
    {
        $this->authorize('update', $schoolReport);

        $schoolReport->update($request->validated());

        return $schoolReport;
    }

    public function destroy(SchoolReport $schoolReport)
    {
        $this->authorize('delete', $schoolReport);

        $schoolReport->delete();

        return response()->json();
    }
}
