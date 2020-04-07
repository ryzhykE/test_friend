<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\FriendRequestNotFoundException;
use App\Friend;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddFriendRequest;
use App\Http\Requests\FriendDestroyRequest;
use App\Http\Resources\FriendResource;
use App\Services\User\FriendService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class FriendResponseController
 * @package App\Http\Controllers\Api
 */
class FriendResponseController extends Controller
{
    /**
     * @var FriendService
     */
    private $friendService;

    /**
     * FriendResponseController constructor.
     * @param FriendService $friendService
     */
    public function __construct(FriendService $friendService)
    {
        $this->friendService = $friendService;
    }

    /**
     * @OA\Post(
     *     path="/friend-response",
     *     description="Accept request",
     *     tags={"Friend Response"},
     *     security={{"Auth": {}}},
     *     @OA\RequestBody(
     *         description="Accept request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\JsonContent(ref="#/components/schemas/AcceptFriendRequest")
     *          )
     *     ),
     *     @OA\Response(response=201, description="Friend accept successfully"),
     *     @OA\Response(response=422, description="Error: Friend accept Not Found"),
     *     @OA\Response(response=401, description="Error: Unauthorized")
     * )
     *
     * @param AddFriendRequest $request
     * @return FriendResource
     * @throws FriendRequestNotFoundException
     */
    public function store(AddFriendRequest $request)
    {
        try {
            $friendRequest = $this->friendService->getFriendForStore($request->get('user_id'));
        } catch (ModelNotFoundException $e) {
            throw new FriendRequestNotFoundException();
        }

        $friendRequest->update($request->merge(['confirmed_at' => now()])->toArray());

        return new FriendResource($friendRequest);
    }

    /**
     * @OA\Delete(
     *     path="/friend-response",
     *     description="Ignore request",
     *     tags={"Friend Response"},
     *     security={{"Auth": {}}},
     *     @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          description="Ignore request",
     *          example=1,
     *          required=true,
     *          allowEmptyValue=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="No content"),
     *     @OA\Response(response=422, description="Error: Unprocessable Entity"),
     *     @OA\Response(response=401, description="Error: Unauthorized")
     * )
     *
     * @param FriendDestroyRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws FriendRequestNotFoundException
     */
    public function destroy(FriendDestroyRequest $request)
    {
        try {
            $this->friendService->destroyFriend($request->get('user_id'));
        } catch (ModelNotFoundException $e) {
            throw new FriendRequestNotFoundException();
        }

        return response()->json([], 204);
    }
}
