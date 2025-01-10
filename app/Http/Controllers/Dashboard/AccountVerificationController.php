<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountVerification\VerificationRequest;
use App\Models\AccountVerification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AccountVerificationController extends Controller
{
    public function index(): View
    {
        $title = 'Verifikasi Akun';

        return \view('dashboard.account-verification.index', compact('title'));
    }

    public function verification(VerificationRequest $request)
    {
        try {
            $emailChange = AccountVerification::userId(auth()->id())
                ->filterByStatus('pending')
                ->latest()
                ->first();

            if (!$emailChange) return to_route('account.index')->with('error', 'Gagal memverifikasi email baru');

            $tokenInvalid = !Hash::check($request->get('token'), $emailChange->token);
            $tokenExpired = date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($emailChange->expired_at));

            if ($tokenInvalid || $tokenExpired) return to_route('account.index')->with('error', 'Email gagal diverifikasi!');

            DB::beginTransaction();
            $emailChange->status = 'verified';
            $emailChange->save();

            $user = $emailChange->user;
            $user->email = $emailChange->new_email;
            $user->save();
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return to_route('account.index')->with('error', 'Internal server error');
        }

        return to_route('account.index')->with('success', 'Email berhasil diverifikasi');
    }
}
