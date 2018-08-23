<?php

namespace Tests\Feature;

use App\User;
use App\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardController extends TestCase
{
    use RefreshDatabase;

    public function testAdminUserCanAccessDashboard()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertViewIs('dashboard');
    }

    public function testStandardUserCannotAccessDashboard()
    {
        $user = factory(User::class)->create(['admin' => false]);
        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertStatus(403);
    }

    public function testGuestIsRedirectedToLogin()
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }
}
