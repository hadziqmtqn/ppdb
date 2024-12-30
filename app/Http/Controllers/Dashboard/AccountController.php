<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $title = 'Akun Saya';

        return view('dashboard.account.index', compact('title'));
    }

    public function update(AccountRequest $request)
    {
        try {
            if ($request->input('current_password') && !Hash::check($request->input('current_password'), auth()->user()->password)) {
                return redirect()->back()->with('error', 'Password lama yang anda masukan salah.');
            }

            $account = User::findOrFail(auth()->user()->id);
            $account->name = $request->input('name');
            $account->email = $request->input('email');

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
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error','Terjadi Kesalahan');
        }

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }
}
