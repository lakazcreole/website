<?php

namespace Tests\Unit\Database;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersMigrationsTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersHaveApiToken()
    {
        $apiToken = str_random(60);
        $user = factory(User::class)->create(['api_token' => $apiToken]);
        $this->assertEquals($apiToken, User::find($user->id)->api_token);
    }
}
