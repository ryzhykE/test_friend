<?php

namespace App\Services;

use App\User;
use \App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

/**
 * Class LoginService
 * @package App\Services
 */
class LoginService
{
    /**
     * @param Request $request
     * @param OauthTokenService $tokenService
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request, OauthTokenService $tokenService)
    {
        /** @var User $user */
        $user = User::where('email', $request->get('email'))->first();

        if ($user) {
            if (!Hash::check($request->get('password'), $user->password)){
                return ['error' => 'Sorry, that password isn\'t right.'];
            }

            if ($request->get('remember-me') == 'true'){
                Passport::tokensExpireIn(\Carbon\Carbon::now()->addDays(7));
            }
        } else {
            return response()->json([
                'message' => 'Auth error',
            ], 401);
        }

        $tokenService->getAccessTokens($user, $request);

        $auth = new UserResource($user);

        if (isset($auth['error'])){
            return response()->json([
                'message' => $auth['error']
            ], 401);
        }
        return response()->json($auth, 200);
    }
}
