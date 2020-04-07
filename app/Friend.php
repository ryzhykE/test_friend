<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * \App\Friend
 *
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property bool|null $status
 * @property \Illuminate\Support\Carbon|null $confirmed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereUserId($value)
 * @mixin \Eloquent
 */
class Friend extends Model
{
    /**
     * @var array
     */
    protected $dates = ['confirmed_at'];

    /**
     * @var array
     */
    protected $casts = ['status' => 'bool'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'friend_id', 'confirmed_at', 'status'];

    /**
     * @param $userId
     * @return mixed
     */
    public static function friendship($userId)
    {
        return (new static())
            ->where(function ($query) use ($userId) {
                return $query->where('user_id', Auth::id())
                    ->where('friend_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                return $query->where('friend_id', Auth::id())
                    ->where('user_id', $userId);
            })
            ->first();
    }
}
