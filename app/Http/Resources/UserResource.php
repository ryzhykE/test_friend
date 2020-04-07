<?php

namespace App\Http\Resources;

use App\Friend;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'users',
                'user_id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'created' => $this->created_at->diffForHumans(),
                'friendship' => new FriendResource(Friend::friendship($this->id)),
            ],
            'links' => [
                'self' => url('/user/'. $this->id),
            ]
        ];
    }
}
