<?php

namespace App\Exceptions;

use Exception;

/**
 * Class FriendRequestNotFoundException
 * @package App\Exceptions
 */
class FriendRequestNotFoundException extends Exception
{
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'errors' => [
                'code' => 404,
                'title' => 'Friend Request Not Found',
                'detail' => 'Unable to locate the friend request with the given information.',
            ]
        ], 404);
    }
}
