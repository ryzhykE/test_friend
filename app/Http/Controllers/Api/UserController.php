<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Services\User\UserService;
use App\User;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/user",
     *     operationId="Get list of users",
     *     tags={"Users"},
     *     security={{"Auth": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="User list response",
     *         @OA\JsonContent(ref="#/components/schemas/UserResponse")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found"
     *     ),
     *      @OA\Response(response="500", description="Internal Server Error.")
     *
     * )
     *
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        return new UserCollection($this->userService->getUserList());
    }

    /**
     * @OA\Get(
     *     path="/user/{user}",
     *     description="Get User details",
     *     tags={"Users"},
     *     security={{"Auth": {}}},
     *     @OA\Parameter(
     *          name="user",
     *          in="path",
     *          description="Get User details",
     *          example=1,
     *          required=true,
     *          allowEmptyValue=false,
     *          @OA\Schema(type="object",
     *     @OA\Property(
     *                   property="name",
     *                   description="Updated name of the pet",
     *                   type="string"
     *               ),
     * )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="User details",
     *          @OA\JsonContent(ref="#/components/schemas/UserResponse")
     *     ),
     *     @OA\Response(response="401", description="Error: Unauthorized"),
     *     @OA\Response(response="404", description="Client not found."),
     * )
     */
    /**
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
