<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardController extends TestCase
{
    use RefreshDatabase;

    public function testAdminUserCanDashboard()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(200)
            ->assertViewIs('dashboard');
    }

    public function testStandardUserCannotDashboard()
    {
        $user = factory(User::class)->create(['admin' => false]);
        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(403);
    }

    public function testGuestCannotDashboard()
    {
        $this->get('dashboard')
            ->assertRedirect(route('login'));
    }
}
