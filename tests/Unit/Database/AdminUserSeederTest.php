<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeedsAdminUser()
    {
        $this->artisan('db:seed', ['--class' => 'AdminUserSeeder']);
        $this->assertDatabaseHas('users', [
            'firstName' => env('ADMIN_FIRST_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'admin' => true,
        ]);
    }
}
