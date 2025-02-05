<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageTemplate\MessageTemplateRequest;
use App\Http\Requests\MessageTemplate\SelectRequest;
use App\Http\Requests\MessageTemplate\UpdateMessageTemplateRequest;
use App\Models\MessageTemplate;
use App\Models\Role;
use App\Repositories\MessageTemplateRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MessageTemplateController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected MessageTemplateRepository $messageTemplateRepository;

    public function __construct(MessageTemplateRepository $messageTemplateRepository)
    {
        $this->messageTemplateRepository = $messageTemplateRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('message-template-read'), only: ['index', 'show']),
            new Middleware(PermissionMiddleware::using('message-template-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('message-template-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Templat Pesan';
        $messageCategories = $this->messageCategories();
        $recipients = $this->recipients();

        return \view('dashboard.settings.message-template.index', compact('title', 'messageCategories', 'recipients'));
    }

    public function messageCategories(): Collection
    {
        return collect([
            'registrasi',
            'verifikasi_email',
            'pendaftaran_diterima',
            'konfirmasi_pembayaran',
            'ubah_email_kata_sandi',
            'pendaftaran_ditolak'
        ]);
    }

    public function recipients()
    {
        return Role::select('name')
            ->get();
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = MessageTemplate::query()
                    ->with('educationalInstitution:id,name')
                    ->filterByEducationalInstitution();

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['title', 'category'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
                    ->addColumn('recipient', fn($row) => ucfirst(str_replace('-', ' ', $row->recipient)))
                    ->addColumn('category', fn($row) => ucfirst(str_replace('_', ' ', $row->category)))
                    ->addColumn('is_active', function ($row) {
                        return '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-warning') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('message-template.show', $row->slug) . '" class="btn btn-icon btn-sm btn-warning"><i class="mdi mdi-pencil-outline"></i></a> ';
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

    public function store(MessageTemplateRequest $request)
    {
        try {
            $messageTemplate = new MessageTemplate();
            $messageTemplate->educational_institution_id = $request->input('educational_institution_id');
            $messageTemplate->category = $request->input('category');
            $messageTemplate->title = $request->input('title');
            $messageTemplate->recipient = $request->input('recipient');
            $messageTemplate->message = $request->input('message');
            $messageTemplate->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function show(MessageTemplate $messageTemplate): View
    {
        $title = 'Templat Pesan';
        $messageCategories = $this->messageCategories();
        $messageTemplate->load('educationalInstitution:id,name');
        $recipients = $this->recipients();

        return \view('dashboard.settings.message-template.show', compact('title', 'messageCategories', 'messageTemplate', 'recipients'));
    }

    public function update(UpdateMessageTemplateRequest $request, MessageTemplate $messageTemplate)
    {
        try {
            $messageTemplate->educational_institution_id = $request->input('educational_institution_id');
            $messageTemplate->category = $request->input('category');
            $messageTemplate->title = $request->input('title');
            $messageTemplate->recipient = $request->input('recipient');
            $messageTemplate->message = $request->input('message');
            $messageTemplate->is_active = $request->input('is_active');
            $messageTemplate->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return to_route('message-template.index')->with('success', 'Data berhasil disimpan!');
    }

    public function destroy(MessageTemplate $messageTemplate): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $messageTemplate->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', $messageTemplate, null, Response::HTTP_OK);
    }

    public function select(SelectRequest $request)
    {
        return $this->messageTemplateRepository->select($request);
    }

    public function selectUser(SelectRequest $request)
    {
        return $this->messageTemplateRepository->selectUser($request);
    }
}
