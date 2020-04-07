<?php

namespace App\ApiDoc\Models;

/**
 * @\OpenApi\Annotations\Schema(
 *     description="Accept friend request",
 *     type="object",
 *     title="Accept friend request"
 * )
 */
class AcceptFriendRequest
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

    /**
     * @\OpenApi\Annotations\Property(
     *     title="User id",
     *     description="User id",
     *     format="string",
     *     example="2"
     * )
     * @var string
     */
    public $user_id;

    /**
     * @\OpenApi\Annotations\Property(
     *     title="Status",
     *     description="Status",
     *     format="integer",
     *     example="1"
     * )
     * @var string
     */
    public $status;
}
