<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    public function apiResponse($message = null, $data = null, $urlRedirect = null, $code = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return response()->json([
            'success' => $code === Response::HTTP_OK,
            'type' => $code === Response::HTTP_OK ? 'success' : 'error',
            'message' => $message,
            'data' => $data,
            'redirect' => $urlRedirect
        ], $code);
    }
}
