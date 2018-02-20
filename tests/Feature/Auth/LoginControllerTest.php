<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin()
    {
        $this->assertGuest();
        $this->get('/login')
            ->assertViewIs('auth.login')
            ->assertStatus(200);
    }

    public function testAuthenticatedAreRedirected()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $this->assertAuthenticatedAs($user);
        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect(route('dashboard'));
    }

    public function testAdminCanLogin()
    {
        $this->artisan('db:seed', ['--class' => 'AdminUserSeeder']);
        $this->assertGuest();
        $this->post('/login', ['email' => env('ADMIN_EMAIL'), 'password' => env('ADMIN_PASSWORD')])
            ->assertStatus(302);
    }

    public function testAuthenticatedCanLogout()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $this->assertAuthenticatedAs($user);
        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect(route('home'));
    }
}
