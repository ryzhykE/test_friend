<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoginService;
use App\Services\OauthTokenService;
use Illuminate\Http\Request;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api\Auth
 */
class LoginController extends Controller
{
    /**
     * @var LoginService
     */
    private $loginService;

    /**
     * LoginController constructor.
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }
    /**
     * @OA\Post(
     *     path="/login",
     *     description="Login user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         description="Login user by email",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserLoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User response",
     *         @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(
     *                      title="user",
     *                      @OA\Property(property="user", title="user", ref="#/components/schemas/UserResponse")
     *                  )
     *              }
     *         )
     *     ),
     *     @OA\Response(response="422", description="Error: Unprocessable Entity"),
     *     @OA\Response(response="401", description="Error: Unauthorized")
     * )
     *
     * @param Request $request
     * @param OauthTokenService $tokenService
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, OauthTokenService $tokenService)
    {
       return $this->loginService->login($request, $tokenService);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     description="User logout",
     *     tags={"Auth"},
     *     security={{"Auth": {}}},
     *     @OA\Response(response="200", description="Successfully logged out"),
     *     @OA\Response(response="401", description="Error: Unauthorized")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'You are successfully logged out',
        ]);
    }
}
