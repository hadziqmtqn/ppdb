<?php

namespace App\Http\Controllers\Dashboard\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\MessageRequest;
use App\Models\Conversation;
use App\Models\Message;
use App\Traits\ApiResponse;
use App\Traits\HandlesBase64Images;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    use ApiResponse, HandlesBase64Images;

    public function index(Conversation $conversation): JsonResponse
    {
        try {
            $messages = Message::with('user:id,name')
                ->conversationId($conversation->id)
                ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $messages->map(function (Message $message) {
            return collect([
                'slug' => $message->slug,
                'username' => ucwords(strtolower(optional($message->user)->name)),
                'avatar' => url('https://ui-avatars.com/api/?name='. optional($message->user)->name .'&color=7F9CF5&background=EBF4FF'),
                'message' => $message->message,
                'date' => Carbon::parse($message->created_at)->isoFormat('DD MMM Y HH:mm'),
                'isSeen' => $message->is_seen,
                'nameColor' => (auth()->user()->id == $message->user_id) ? 'text-primary' : ''
            ]);
        }), null, Response::HTTP_OK);
    }

    public function latest(Conversation $conversation): JsonResponse
    {
        try {
            $message = Message::with('user:id,name')
                ->conversationId($conversation->id)
                ->latest()
                ->first();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', [
            'slug' => $message->slug,
            'username' => ucwords(strtolower(optional($message->user)->name)),
            'avatar' => url('https://ui-avatars.com/api/?name='. optional($message->user)->name .'&color=7F9CF5&background=EBF4FF'),
            'message' => $message->message,
            'date' => Carbon::parse($message->created_at)->isoFormat('DD MMM Y HH:mm'),
            'isSeen' => $message->is_seen,
            'nameColor' => (auth()->user()->id == $message->user_id) ? 'text-primary' : ''
        ], null, Response::HTTP_OK);
    }

    public function replyMessage(MessageRequest $request, Conversation $conversation): JsonResponse
    {
        try {
            $message = new Message();
            $message->conversation_id = $conversation->id;
            $message->user_id = auth()->id();
            $message->message = $request->input('message');
            $message->save();

            $content = $request->input('message');

            // Memproses gambar base64 di dalam konten menggunakan trait
            $directory = 'conversation/' . $conversation->slug;
            $content = $this->processBase64Images($content, $directory);

            $message->update(['message' => $content]);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Pesan gagal dikirim', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Pesan berhasil dikirim', null, null, Response::HTTP_OK);
    }

    public function destroy(Message $message): JsonResponse
    {
        try {
            $message->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
