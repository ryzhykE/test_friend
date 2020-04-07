<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FriendRequest;
use App\Http\Resources\FriendResource;
use App\Services\User\FriendService;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class FriendRequestController
 * @package App\Http\Controllers\Api
 */
class FriendRequestController extends Controller
{
    /**
     * @var FriendService
     */
    private $friendService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * FriendRequestController constructor.
     * @param FriendService $friendService
     * @param UserService $userService
     */
    public function __construct(FriendService $friendService, UserService $userService)
    {
        $this->friendService = $friendService;
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/friend-request",
     *     description="Friend request",
     *     tags={"Friend request"},
     *     security={{"Auth": {}}},
     *     @OA\RequestBody(
     *         description="Friend request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(ref="#/components/schemas/CreateFriendRequest")
     *          )
     *     ),
     *     @OA\Response(response=201, description="Friend request created successfully"),
     *     @OA\Response(response=422, description="Error: Unprocessable Entity"),
     *     @OA\Response(response=401, description="Error: Unauthorized")
     * )
     * @param FriendRequest $request
     * @return FriendResource
     * @throws UserNotFoundException
     */
    public function store(FriendRequest $request)
    {
        try {
            $this->userService->syncUserFriends($request->get('friend_id'));
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return new FriendResource($this->friendService->getFriend($request->get('friend_id')));
    }
}
