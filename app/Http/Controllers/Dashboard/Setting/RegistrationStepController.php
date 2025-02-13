<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationStep\RegistrationStepRequest;
use App\Http\Requests\RegistrationStep\UpdateRegistrationStepRequest;
use App\Models\RegistrationStep;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RegistrationStepController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('registration-step-read'), only: ['index', 'datatable', 'show']),
            new Middleware(PermissionMiddleware::using('registration-step-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('registration-step-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Langkah Pendaftaran';

        return \view('dashboard.settings.registration-step.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = RegistrationStep::query()
                    ->orderByDesc('serial_number');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['title', 'description'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('description', fn($row) => Str::limit(strip_tags($row->description), 70))
                    ->addColumn('is_active', function ($row) {
                        return '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-warning') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('registration-step.show', $row->slug) . '" class="btn btn-icon btn-sm btn-warning"><i class="mdi mdi-pencil-outline"></i></a> ';
                        $btn .= '<button href="javascript:void(0)" data-slug="' . $row->slug . '" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-trash-can-outline"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'is_active'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(RegistrationStepRequest $request)
    {
        try {
            $registrationStep = new RegistrationStep();
            $registrationStep->serial_number = $request->input('serial_number');
            $registrationStep->title = $request->input('title');
            $registrationStep->description = $request->input('description');
            $registrationStep->save();

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $registrationStep->addMediaFromRequest('image')
                    ->toMediaCollection('steps');
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function show(RegistrationStep $registrationStep): View
    {
        $title = 'Langkah Pendaftaran';

        return \view('dashboard.settings.registration-step.show', compact('title', 'registrationStep'));
    }

    public function update(UpdateRegistrationStepRequest $request, RegistrationStep $registrationStep)
    {
        try {
            $registrationStep->serial_number = $request->input('serial_number');
            $registrationStep->title = $request->input('title');
            $registrationStep->description = $request->input('description');
            $registrationStep->is_active = $request->input('is_active');
            $registrationStep->save();

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if ($registrationStep->hasMedia('steps')) {
                    $registrationStep->clearMediaCollection('steps');
                }

                $registrationStep->addMediaFromRequest('image')
                    ->toMediaCollection('steps');
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function destroy(RegistrationStep $registrationStep): JsonResponse
    {
        try {
            if ($registrationStep->hasMedia('steps')) {
                $registrationStep->clearMediaCollection('steps');
            }

            $registrationStep->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus', null, null, Response::HTTP_OK);
    }
}
