<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class MyAccountRepository
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function myAccount(): Collection
    {
        $user = $this->user->findOrFail(auth()->user()->id);

        return collect([
            'name' => $user->name,
            'role' => ucfirst(str_replace('-', ' ',$user->roles->first()->name)),
            'createdAt' => Carbon::parse($user->created_at)->isoFormat('DD MMM Y'),
            'photo' => $user->hasMedia('photo') ? $user->getFirstTemporaryUrl(Carbon::now()->addMinutes(5), 'photo') : url('https://ui-avatars.com/api/?name='. $user->name .'&color=7F9CF5&background=EBF4FF'),
        ]);
    }
}
