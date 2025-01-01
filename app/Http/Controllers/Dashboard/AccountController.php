<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountRequest;
use App\Models\EmailChange;
use App\Models\User;
use App\Repositories\SendMessage\EmailChangeRepository;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AccountController extends Controller
{
    protected EmailChangeRepository $emailChangeRepository;

    public function __construct(EmailChangeRepository $emailChangeRepository)
    {
        $this->emailChangeRepository = $emailChangeRepository;
    }

    public function index(): View
    {
        $title = 'Akun Saya';
        $emailChange = EmailChange::userId(auth()->id())
            ->filterByStatus('pending')
            ->latest()
            ->first();

        return view('dashboard.account.index', compact('title', 'emailChange'));
    }

    public function update(AccountRequest $request)
    {
        try {
            if ($request->input('current_password') && !Hash::check($request->input('current_password'), auth()->user()->password)) {
                return redirect()->back()->with('error', 'Password lama yang anda masukan salah.');
            }

            $account = User::findOrFail(auth()->user()->id);

            DB::beginTransaction();
            $account->name = $request->input('name');

            // tambahkan data email baru sementara untuk diverifikasi
            if ($request->input('email') != $account->email) {
                $emailChange = new EmailChange();
                $emailChange->user_id = $account->id;
                $emailChange->new_email = $request->input('email');
                $token = Str::random(30);
                $emailChange->token = Hash::make($token);
                $emailChange->expired_at = Carbon::now()->addDay();
                $emailChange->save();

                // TODO Kirim pesan
                $this->emailChangeRepository->sendMessage($emailChange->new_email, $token);
            }else {
                $account->email = $request->input('email');
            }

            if ($request->input('current_password') && $request->input('password')) {
                $account->password = Hash::make($request->input('password'));
            }

            $account->save();

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                if ($account->hasMedia('photo')) {
                    $account->clearMediaCollection('photo');
                }

                $account->addMediaFromRequest('photo')->toMediaCollection('photo');
            }
            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->back()->with('error','Terjadi Kesalahan');
        }

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }
}
