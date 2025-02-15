<?php

namespace App\Http\Controllers\Dashboard\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\ConversationRequest;
use App\Models\Conversation;
use App\Repositories\Message\ConversationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class ConversationController extends Controller
{
    use AuthorizesRequests, ApiResponse;

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

            // Mencari dan memproses semua gambar base64 di dalam konten
            preg_match_all('/<img src="data:image\/(jpeg|png);base64,([^"]+)"/', $content, $matches);

            foreach ($matches[0] as $index => $imgTag) {
                $extension = $matches[1][$index];
                $base64Image = $matches[2][$index];

                // Mendekode base64 menjadi file gambar dan menyimpannya menggunakan Spatie Media Library
                $media = $conversation->addMediaFromBase64($base64Image)
                    ->usingFileName(uniqid() . '.' . $extension)
                    ->toMediaCollection('images');

                // Menggantikan base64 dengan URL gambar
                $url = $media->getTemporaryUrl(Carbon::now()->addSeconds(10));
                $content = str_replace($imgTag, '<img src="' . $url . '"', $content);
            }

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

        $content = $conversation->message;

        // Mencari dan memperbarui semua URL gambar sementara di dalam konten
        $updatedContent = $this->updateTemporaryUrls($conversation, $content);

        // Mengembalikan pesan dengan URL gambar sementara yang baru
        $conversation->message = $updatedContent;
        //dd($updatedContent);

        return \view('dashboard.messages.message.index', compact('title', 'conversation'));
    }

    private function updateTemporaryUrls(Conversation $conversation, $content)
    {
        preg_match_all('/<img src="([^"]+)"/', $content, $matches);

        foreach ($matches[1] as $url) {
            $media = $conversation->getMedia('images')->first(function ($mediaItem) use ($url) {
                return $mediaItem->getUrl() === $url;
            });

            if ($media) {
                // Periksa apakah URL sementara masih berlaku
                $expiryTime = Carbon::parse($media->expires_at);
                if (Carbon::now()->lessThan($expiryTime)) {
                    // Jika URL sementara masih berlaku, gunakan URL yang sama
                    $newUrl = $url;
                } else {
                    // Jika URL sementara telah kedaluwarsa, buat URL sementara yang baru
                    $newUrl = $media->getTemporaryUrl(Carbon::now()->addDays(2));
                }

                $content = str_replace($url, $newUrl, $content);
            }
        }

        $conversation->message = $content;
        $conversation->save();

        return $content;
    }

    public function destroy(Conversation $conversation): JsonResponse
    {
        $this->authorize('delete', $conversation);

        try {
            $conversation->delete();
        } catch (Exception $exception) {
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
