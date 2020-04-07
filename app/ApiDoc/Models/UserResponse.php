<?php

namespace App\ApiDoc\Models;

/**
 * @OA\Schema(
 *     description="User response example",
 *     type="object",
 *     title="User response example"
 * )
 */
class UserResponse
{
    /**
     * @\OpenApi\Annotations\Property(
     *      title="User id",
     *      type="integer",
     *      example="1"
     * )
     * @var integer
     */
    public $id;

    /**
     * @\OpenApi\Annotations\Property(
     *     title="User name",
     *     description="User name",
     *     format="string",
     *     example="name"
     * )
     * @var string
     */
    public $name;

    /**
     * @\OpenApi\Annotations\Property(
     *     title="email",
     *     description="User email",
     *     format="string",
     *     example="mail@example.com"
     * )
     * @var string
     */
    public $email;

    /**
     * @\OpenApi\Annotations\Property(
     *     title="User password",
     *     description="User password",
     *     format="string",
     *     example="password"
     * )
     * @var string
     */
    public $password;
}
