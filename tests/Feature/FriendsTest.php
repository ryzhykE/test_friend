<?php

namespace Tests\Feature;

use App\Friend;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class FriendsTest
 * @package Tests\Feature
 */
class FriendsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanSendFriendRequest()
    {
       $this->withoutExceptionHandling();

       $this->actingAs($user = factory(User::class)->create(), 'api');
       $anotherUser = factory(User::class)->create();

       $response = $this->post('api/v1/friend-request', [
           'friend_id' => $anotherUser->id,
       ])->assertStatus(200);

       $friend = Friend::first();
       $this->assertNotNull($friend);

        $this->assertEquals($anotherUser->id, $friend->friend_id);
        $this->assertEquals($user->id, $friend->user_id);

        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friend->id,
                'confirmed_at' => null,
            ],
            'links' => [
                'self' => url('/user/'.$anotherUser->id),
            ]
        ]);
    }

    public function testValidUserCanBeFriend()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('api/v1/friend-request', [
            'friend_id' => 999,
        ])->assertStatus(404);

        $this->assertNull(Friend::first());
        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => 'User Not Found',
                'detail' => 'Unable to locate the user with the given information.',
            ]
        ]);
    }

    public function testFriendRequestCanBeAccepted()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();
        $this->post('/api/v1/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $response = $this->actingAs($anotherUser, 'api')
            ->post('/api/v1/friend-response', [
                'user_id' => $user->id,
                'status' => true,
            ])->assertStatus(200);

        $friendRequest = Friend::first();
        $this->assertNotNull($friendRequest->confirmed_at);
        $this->assertInstanceOf(Carbon::class, $friendRequest->confirmed_at);
        $this->assertEquals(now()->startOfSecond(), $friendRequest->confirmed_at);
        $this->assertEquals(true, $friendRequest->status);
        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'confirmed_at' => $friendRequest->confirmed_at->diffForHumans(),
                'friend_id' => $friendRequest->friend_id,
                'user_id' => $friendRequest->user_id,

            ],
            'links' => [
                'self' => url('/user/'.$anotherUser->id),
            ]
        ]);
    }

    public function testValidFriendCanBeAccepted()
    {
        $anotherUser = factory(User::class)->create();

        $response = $this->actingAs($anotherUser, 'api')
            ->post('/api/v1/friend-response', [
                'user_id' => 999,
                'status' => 1,
            ])->assertStatus(404);

        $this->assertNull(Friend::first());
        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => 'Friend Request Not Found',
                'detail' => 'Unable to locate the friend request with the given information.',
            ]
        ]);
    }

    public function testValidFriendCanBeIgnored()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(\App\User::class)->create();

        $this->post('/api/v1/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $response = $this->actingAs($anotherUser, 'api')
            ->delete('/api/v1/friend-response/delete', [
                'user_id' => $user->id,
            ])->assertStatus(204);

        $friendRequest = Friend::first();
        $this->assertNull($friendRequest);
        $response->assertNoContent();
    }
}
