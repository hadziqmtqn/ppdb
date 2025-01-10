<?php

namespace App\Repositories;

use App\Models\AccountVerification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SaveNewAccountRepository
{
    public function __construct()
    {
    }

    public function save($request): Collection
    {
        $emailChange = new AccountVerification();
        $emailChange->user_id = $request['user_id'];
        $emailChange->new_email = $request['email'];
        $token = Str::random(30);
        $emailChange->token = Hash::make($token);
        $emailChange->expired_at = Carbon::now()->addDay();
        $emailChange->save();

        return collect([
            'email' => $emailChange->new_email,
            'token' => $token
        ]);
    }
}
