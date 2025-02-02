<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountVerification\VerificationRequest;
use App\Models\AccountVerification;
use App\Repositories\SaveNewAccountRepository;
use App\Repositories\SendMessage\AccountVerificationRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AccountVerificationController extends Controller
{
    protected AccountVerificationRepository $accountVerificationRepository;
    protected SaveNewAccountRepository $saveNewAccountRepository;

    public function __construct(AccountVerificationRepository $accountVerificationRepository, SaveNewAccountRepository $saveNewAccountRepository)
    {
        $this->accountVerificationRepository = $accountVerificationRepository;
        $this->saveNewAccountRepository = $saveNewAccountRepository;
    }

    public function index(): View
    {
        $title = 'Verifikasi Akun';

        return \view('dashboard.account-verification.index', compact('title'));
    }

    public function verification(VerificationRequest $request)
    {
        try {
            $accountVerification = AccountVerification::userId(auth()->id())
                ->filterByStatus('pending')
                ->latest()
                ->first();

            if (!$accountVerification) return to_route('account-verification.index')->with('error', 'Gagal memverifikasi email baru');

            $tokenInvalid = !Hash::check($request->get('token'), $accountVerification->token);
            $tokenExpired = date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($accountVerification->expired_at));

            if ($tokenInvalid || $tokenExpired) return to_route('account-verification.index')
                ->with('error', 'Email gagal diverifikasi!');

            DB::beginTransaction();
            $accountVerification->status = 'verified';
            $accountVerification->save();

            $user = $accountVerification->user;
            $user->email_verified_at = now();
            $user->save();
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return to_route('account-verification.index')->with('error', 'Internal server error');
        }

        return to_route('dashboard')->with('success', 'Email berhasil diverifikasi');
    }

    public function resend()
    {
        try {
            DB::beginTransaction();
            // TODO Send Account Verification
            $saveNewAccount = $this->saveNewAccountRepository->save([
                'user_id' => auth()->id(),
                'email' => auth()->user()->email
            ]);

            $this->accountVerificationRepository->sendMessage($saveNewAccount['email'], route('account-verification.verification', ['token' => $saveNewAccount['token']]), auth()->user()->student->whatsapp_number);
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal dikirim');
        }

        return redirect()->back()->with('success', 'Tautan verifikasi berhasil dikirim');
    }
}
