<?php
namespace App\Services;

use App\User;
use Illuminate\Http\Request;

/**
 * Class OauthTokenService
 * @package App\Services
 */
class OauthTokenService
{
    /**
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function getAccessTokens(User $user, Request $request)
    {
        $params = [
            'grant_type' => 'password',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'username' => $user->email,
            'password' => $request->get('password'),
        ];

       request()->request->add($params);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return json_decode(\Route::dispatch($proxy)->content(), true);
    }
}
