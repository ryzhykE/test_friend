<?php

namespace App\ApiDoc\Models;

/**
 * @OA\Schema(
 *     description="User register by form fields.",
 *     type="object",
 *     title="User register request"
 * )
 */
class UserRegisterRequest
{
    /**
     * @\OpenApi\Annotations\Property(
     *      title="name",
     *      type="string",
     *      example="name"
     * )
     * @var string
     */
    public $name;

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

    /**
     * @\OpenApi\Annotations\Property(
     *      title="password",
     *      type="string",
     *      example="123123123"
     * )
     * @var string
     */
    public $password_confirmation;
}
