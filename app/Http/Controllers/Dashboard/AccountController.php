<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountRequest;
use App\Models\AccountVerification;
use App\Models\User;
use App\Repositories\SaveNewAccountRepository;
use App\Repositories\SendMessage\AccountVerificationRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class AccountController extends Controller
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
        $title = 'Akun Saya';
        $emailChange = AccountVerification::userId(auth()->id())
            ->filterByStatus('pending')
            ->latest()
            ->first();

        return view('dashboard.account.index', compact('title', 'emailChange'));
    }

    /**
     * @throws Throwable
     */
    public function update(AccountRequest $request)
    {
        try {
            if ($request->input('current_password') && !Hash::check($request->input('current_password'), auth()->user()->password)) {
                return redirect()->back()->with('error', 'Password lama yang anda masukan salah.');
            }

            $account = User::with('admin')
                ->findOrFail(auth()->user()->id);

            DB::beginTransaction();
            $account->name = $request->input('name');

            // tambahkan data email baru sementara untuk diverifikasi
            if ($request->input('email') != $account->email) {
                $emailChange = $this->saveNewAccountRepository->save([
                    'user_id' => $account->id,
                    'email' => $request->input('email')
                ]);

                // TODO Kirim pesan
                $this->accountVerificationRepository->sendMessage($emailChange['email'], route('email-change.verification', ['token' => $emailChange['token']]), optional($account->admin)->whatsapp_number);
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
