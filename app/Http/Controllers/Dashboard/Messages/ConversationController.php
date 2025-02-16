<?php

namespace App\Http\Controllers\Dashboard\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\ConversationRequest;
use App\Models\Conversation;
use App\Repositories\Message\ConversationRepository;
use App\Traits\ApiResponse;
use App\Traits\HandlesBase64Images;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class ConversationController extends Controller
{
    use AuthorizesRequests, ApiResponse, HandlesBase64Images;

    protected ConversationRepository $conversationRepository;

    /**
     * @param ConversationRepository $conversationRepository
     */
    public function __construct(ConversationRepository $conversationRepository)
    {
        $this->conversationRepository = $conversationRepository;
    }

    public function index(): View
    {
        $title = 'Kirim Pesan';

        return \view('dashboard.messages.conversation.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Conversation::query()
                    ->with([
                        'user:id,name',
                        'user.student:id,user_id,educational_institution_id',
                        'user.student.educationalInstitution:id,name',
                        'admin:id,name'
                    ])
                    ->orderByDesc('created_at');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereHas('user', fn($query) => $query->whereAny(['name'], 'LIKE', '%' . $search . '%'));
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional(optional(optional($row->user)->student)->educationalInstitution)->name)
                    ->addColumn('student', fn($row) => optional($row->user)->name)
                    ->addColumn('admin', fn($row) => optional($row->admin)->name)
                    ->addColumn('is_seen', fn($row) => '<span class="badge rounded-pill '. ($row->is_seen ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Dibaca' : 'Belum terbaca') .'</span>')
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="'. route('conversation.show', $row->slug) .'" class="btn btn-icon btn-sm btn-primary"><i class="mdi mdi-eye"></i></a> ';
                        $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'is_seen'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    /**
     * @throws Throwable
     */
    public function store(ConversationRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $conversation = new Conversation();
            $conversation->user_id = $request->input('user_id');
            $conversation->admin_id = $request->input('send_to') == 'user' ? auth()->id() : null;
            $conversation->subject = $request->input('subject');
            $conversation->message = $request->input('message');
            $conversation->save();

            $content = $request->input('message');

            // Memproses gambar base64 di dalam konten menggunakan trait
            $directory = 'conversation/' . $conversation->slug;
            $content = $this->processBase64Images($content, $directory);

            // Memperbarui konten post dengan konten yang telah dimodifikasi
            $conversation->update(['message' => $content]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Pesan gagal dikirim', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Pesan berhasil dikirim', null, route('conversation.show', $conversation->slug), Response::HTTP_OK);
    }

    public function show(Conversation $conversation): View
    {
        $this->authorize('view', $conversation);

        $title = 'Kirim Pesan';
        $conversation->load([
            'user:id,name',
            'admin:id,name',
            'messages' => function ($query) {
                $query->orderByDesc('created_at');
            }
        ]);

        return \view('dashboard.messages.message.index', compact('title', 'conversation'));
    }

    /**
     * @throws Throwable
     */
    public function destroy(Conversation $conversation): JsonResponse
    {
        $this->authorize('delete', $conversation);

        try {
            DB::beginTransaction();
            // Hapus direktori yang berisi gambar
            $directory = 'conversation/' . $conversation->slug;
            $this->deleteDirectory($directory);

            $conversation->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }

    // TODO Select
    public function selectStudent(Request $request)
    {
        return $this->conversationRepository->getStudents($request);
    }
}
