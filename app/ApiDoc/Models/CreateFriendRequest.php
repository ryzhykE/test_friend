<?php

namespace App\ApiDoc\Models;

/**
 * @\OpenApi\Annotations\Schema(
 *     description="Create friend request",
 *     type="object",
 *     title="Create friend request"
 * )
 */
class CreateFriendRequest
{
    /**
     * @\OpenApi\Annotations\Property(
     *     title="Friend id",
     *     description="Friend id",
     *     format="string",
     *     example="1"
     * )
     * @var string
     */
    public $friend_id;
}
