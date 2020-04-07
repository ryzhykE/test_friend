<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Api\Auth
 */
class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/register",
     *     description="Register user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         description="Registering user by form fields",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRegisterRequest")
     *     ),
     *     @OA\Response(response="201", description="Successfully registered."),
     *     @OA\Response(response="422", description="Error: Unprocessable Entity"),
     * )
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        User::create(array_merge(
            $request->only('name', 'email'),
            ['password' => bcrypt($request->password)])
        );

        return response()->json([
            'message' => 'Successfully registered.'
        ], 201);
    }
}
