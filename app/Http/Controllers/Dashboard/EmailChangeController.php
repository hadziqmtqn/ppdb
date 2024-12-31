<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailChange\VerificationRequest;
use App\Models\EmailChange;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmailChangeController extends Controller
{
    public function verification(VerificationRequest $request, EmailChange $emailChange)
    {
        Gate::authorize('verification', $emailChange);

        try {
            $emailChange->load('user');

            $tokenInvalid = !Hash::check($emailChange->token, $request->get('token'));
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
            return redirect()->back()->with('error', 'Internal server error');
        }

        return to_route('account.index')->with('success', 'Email berhasil diverifikasi');
    }
}
