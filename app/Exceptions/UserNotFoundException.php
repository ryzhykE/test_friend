<?php

namespace App\Exceptions;

use Exception;

/**
 * Class UserNotFoundException
 * @package App\Exceptions
 */
class UserNotFoundException extends Exception
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
                'title' => 'User Not Found',
                'detail' => 'Unable to locate the user with the given information.',
            ]
        ], 404);
    }
}
