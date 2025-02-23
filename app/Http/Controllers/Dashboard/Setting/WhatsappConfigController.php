<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsappConfig\WhatsappConfigRequest;
use App\Models\WhatsappConfig;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WhatsappConfigController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('whatsapp-config-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('whatsapp-config-write'), only: ['store']),
        ];
    }

    public function index(): View
    {
        $title = 'Konfig. Whatsapp';

        return view('dashboard.settings.whatsapp-config.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = WhatsappConfig::query();

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->where('provider', 'like', '%' . $search . '%');
                        });
                    })
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        return '<button type="button" data-slug="'. $row->slug .'" data-domain="'. $row->domain .'" data-api-key="'. $row->api_key .'" data-active="'. $row->is_active .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button>';
                    })
                    ->rawColumns(['action', 'is_active'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function update(WhatsappConfigRequest $request, WhatsappConfig $whatsappConfig): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $whatsappConfig->domain = $request->input('domain');
            $whatsappConfig->api_key = $request->input('api_key');
            $whatsappConfig->is_active = $request->input('is_active');
            $whatsappConfig->save();
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan', $whatsappConfig, null, Response::HTTP_OK);
    }
}
