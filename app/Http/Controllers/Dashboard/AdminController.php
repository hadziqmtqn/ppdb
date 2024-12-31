<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('admin-read'), only: ['index', 'show']),
            new Middleware(PermissionMiddleware::using('admin-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('admin-delete'), only: ['destroy', 'restore']),
        ];
    }

    public function index(): View
    {
        $title = 'Admin';

        return \view('dashboard.admin.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = User::query()
                    ->with('admin.educationalInstitution:id,name')
                    ->whereHas('admin');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name', 'email'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional(optional($row->admin)->educationalInstitution)->name)
                    ->addColumn('role', fn($row) => '<span class="badge rounded-pill ' . ($row->roles->first()->name == 'super-admin' ? 'bg-primary' : 'bg-secondary') . '">'. ucfirst(str_replace('-', ' ', $row->roles->first()->name)) .'</span>')
                    ->addColumn('whatsappNumber', fn($row) => optional($row->admin)->whatsapp_number)
                    ->addColumn('is_active', function ($row) {
                        return '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('admin.show', $row->username) . '" class="btn btn-icon btn-sm btn-primary"><i class="mdi mdi-eye"></i></a> ';
                        $btn .= '<button href="javascript:void(0)" data-username="' . $row->username . '" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-trash-can-outline"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['is_active', 'role', 'action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(AdminRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            $user->assignRole($request->input('role_id'));

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $user->addMediaFromRequest('photo')->toMediaCollection('photo');
            }

            $admin = new Admin();
            $admin->user_id = $user->id;
            $admin->educational_institution_id = $request->input('educational_institution_id');
            $admin->whatsapp_number = $request->input('whatsapp_number');
            $admin->save();
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function show(User $user): View
    {
        $title = 'Admin';
        $user->load('admin.educationalInstitution:id,name');

        return \view('dashboard.admin.show', compact('title', 'user'));
    }

    public function update(UpdateAdminRequest $request, User $user)
    {
        try {
            $user->load('admin');
            DB::beginTransaction();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->input('password')) $user->password = Hash::make($request->input('password'));
            $user->is_active = $request->input('is_active');
            $user->save();

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                if ($user->hasMedia('photo')) $user->clearMediaCollection('photo');
                $user->addMediaFromRequest('photo')->toMediaCollection('photo');
            }

            $admin = $user->admin;
            $admin->educational_institution_id = $request->input('educational_institution_id');
            $admin->whatsapp_number = $request->input('whatsapp_number');
            $admin->save();
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan');
        }

        return to_route('admin.index')->with('success', 'Data berhasil disimpan');
    }

    public function destroy(User $user): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            if ($user->hasMedia('photo')) $user->clearMediaCollection('photo');

            $user->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus', null, null, Response::HTTP_OK);
    }
}
