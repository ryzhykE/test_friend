<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class UserProfileTest
 * @package Tests\Feature
 */
class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUserList()
    {
        $this->actingAs($user = factory(\App\User::class)->create(), 'api');
        $anotherUser = factory(\App\User::class, 2)->create();

        $response = $this->get('/api/v1/user');
        $response->assertStatus(200)->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'users',
                        'user_id' => $anotherUser->last()->id,
                        'name' => $anotherUser->last()->name,
                        'email' => $anotherUser->last()->email,
                        'created' => $anotherUser->last()->created_at->diffForHumans(),
                    ],
                    'links' => [
                        'self' => url('/user/' . $anotherUser->last()->id),
                    ]
                ],
                [
                    'data' => [
                        'type' => 'users',
                        'user_id' => $anotherUser->first()->id,
                        'name' => $anotherUser->first()->name,
                        'email' => $anotherUser->first()->email,
                        'created' => $anotherUser->first()->created_at->diffForHumans(),
                    ],
                    'links' => [
                        'self' => url('/user/' . $anotherUser->first()->id),
                    ]
                ]
            ],

        ]);
    }

    public function testUserCanViewProfile()
    {
        $this->actingAs($user = factory(\App\User::class)->create(), 'api');

        $response = $this->get('api/v1/user/'.$user->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'users',
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created' => $user->created_at->diffForHumans(),
                ],
                'links' => [
                    'self' => url('/user/' . $user->id),
                ]
            ]);
    }
}
