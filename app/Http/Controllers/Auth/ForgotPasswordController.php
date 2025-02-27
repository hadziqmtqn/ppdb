<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ForgotPasswordController extends Controller
{
    use ApiResponse;

    public function index(): View
    {
        $title = 'Lupa Kata Sandi';

        return \view('home.auth.forgot-password', compact('title'));
    }

    /**
     * @throws Throwable
     */
    public function store(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $user = User::with('student', 'admin')
                ->filterByEmail($request->input('email'))
                ->firstOrFail();

            DB::beginTransaction();
            $token = Str::random(60);
            PasswordResetToken::filterByEmail($request->input('email'))
                ->delete();

            $passwordResetToken = new PasswordResetToken();
            $passwordResetToken->email = $request->input('email');
            $passwordResetToken->token = $token;
            $passwordResetToken->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan', null, null, Response::HTTP_OK);
    }
}
