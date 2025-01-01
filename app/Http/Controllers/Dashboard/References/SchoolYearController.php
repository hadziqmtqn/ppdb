<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolYear\SchoolYearRequest;
use App\Models\SchoolYear;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Yajra\DataTables\Facades\DataTables;

class SchoolYearController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // TODO: Implement middleware() method.

        return [
            new Middleware(PermissionMiddleware::using('school-year-read'), only: ['index', 'show']),
            new Middleware(PermissionMiddleware::using('school-year-write'), only: ['store', 'update']),
        ];
    }

    public function index(): View
    {
        $title = 'Tahun Ajaran';

        return \view('dashboard.references.school-year.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = SchoolYear::query()
                    ->orderByDesc('first_year');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['first_year', 'last_year'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('year', fn($row) => $row->first_year . '-' . $row->last_year)
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-warning') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        return '<a href="'. route('school-year.show', $row->slug) .'" class="btn btn-icon btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a>';
                    })
                    ->rawColumns(['action', 'is_active'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(SchoolYearRequest $request)
    {
        try {
            $schoolYear = new SchoolYear();
            $schoolYear->first_year = $request->input('first_year');
            $schoolYear->last_year = $request->input('last_year');
            $schoolYear->is_active = $request->input('is_active');
            $schoolYear->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function show(SchoolYear $schoolYear): View
    {
        $title = 'Tahun Ajaran';

        return \view('dashboard.references.school-year.show', compact('title', 'schoolYear'));
    }

    public function update(SchoolYearRequest $request, SchoolYear $schoolYear)
    {
        try {
            $schoolYear->first_year = $request->input('first_year');
            $schoolYear->last_year = $request->input('last_year');
            $schoolYear->is_active = $request->input('is_active');
            $schoolYear->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}
