<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageReceiver\MessageReceiverRequest;
use App\Models\MessageReceiver;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MessageReceiverController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('message-receiver-read'), only: ['show']),
            new Middleware(PermissionMiddleware::using('message-receiver-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('message-receiver-delete'), only: ['destroy']),
        ];
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = MessageReceiver::query()
                    ->with('messageTemplate.educationalInstitution:id,name', 'user:id,name');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereHas('messageTemplate', function ($query) use ($search) {
                                $query->where('title', 'like', '%' . $search . '%');
                            });
                        });
                    })
                    ->addColumn('messageTemplate', fn($row) => optional($row->messageTemplate)->title . ' - ' . optional(optional($row->messageTemplate)->educationalInstitution)->name)
                    ->addColumn('user', fn($row) => optional($row->user)->name)
                    ->addColumn('action', function ($row) {
                        return '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(MessageReceiverRequest $request): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $messageReceiver = MessageReceiver::query()
                ->where([
                    'message_template_id' => $request->input('message_template_id'),
                    'user_id' => $request->input('user_id')
                ])
                ->firstOrNew();
            $messageReceiver->message_template_id = $request->input('message_template_id');
            $messageReceiver->user_id = $request->input('user_id');
            $messageReceiver->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $messageReceiver, null, Response::HTTP_OK);
    }

    public function destroy(MessageReceiver $messageReceiver): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $messageReceiver->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
