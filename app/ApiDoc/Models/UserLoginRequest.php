<?php

namespace App\ApiDoc\Models;

/**
 * @OA\Schema(
 *     description="User login request.",
 *     type="object",
 *     title="User login request."
 * )
 */
class UserLoginRequest
{
    /**
     * @\OpenApi\Annotations\Property(
     *      title="email",
     *      type="string",
     *      example="mail@example.com"
     * )
     * @var string
     */
    public $email;

    /**
     * @\OpenApi\Annotations\Property(
     *      title="password",
     *      type="string",
     *      example="123123123"
     * )
     * @var string
     */
    public $password;
}
