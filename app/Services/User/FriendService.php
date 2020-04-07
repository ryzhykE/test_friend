<?php

namespace App\Services\User;

use App\Friend;
use Illuminate\Support\Facades\Auth;

/**
 * Class FriendService
 * @package App\Services\User
 */
class FriendService {

    /**
     * @param $id
     * @return object
     */
    public function getFriend($id): object
    {
        return Friend::where('user_id', Auth::id())
            ->where('friend_id', $id)
            ->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFriendForStore($id)
    {
        return Friend::where('user_id', $id)
            ->where('friend_id', Auth::id())
            ->firstOrFail();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroyFriend($id)
    {
        return $this->getFriendForStore($id)->delete();
    }
}
