<?php

namespace App\Services\User;

use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services\User
 */
class UserService
{
    /**
     * @return object
     */
    public function getUserList(): object
    {
        return User::where('id', '<>', Auth::id())->latest('id')->get();
    }

    /**
     * @param $id
     */
    public function syncUserFriends($id): void
    {
        User::findOrFail($id)->friends()->syncWithoutDetaching(auth()->user());
    }
}
