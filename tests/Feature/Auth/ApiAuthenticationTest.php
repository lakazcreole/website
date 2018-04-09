<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticationViaHeader()
    {
        $user = factory(User::class)->create();
        $this->withHeaders(['HTTP_Authorization' => 'Bearer ' . $user->api_token])
            ->json('GET', '/api/user')
            ->assertStatus(200)
            ->assertJson([
                'api_token' => $user->api_token
            ]);
    }

    public function testAuthenticationViaUrlParameter()
    {
        $user = factory(User::class)->create();
        $this->json('GET', '/api/user?api_token=' . $user->api_token)
            ->assertStatus(200)
            ->assertJson([
                'api_token' => $user->api_token
            ]);
    }
}
