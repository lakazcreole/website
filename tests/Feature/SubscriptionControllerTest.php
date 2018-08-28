<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Subscription;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    public function setUp()
    {
        parent::setUp();
        $this->admin = factory(User::class)->create(['admin' => true]);
    }

    /** @test */
    public function index()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.subscriptions.index'))
            ->assertStatus(200)
            ->assertViewIs('subscriptions.index')
            ->assertViewHasAll([
                'subscriptions' => Subscription::all()
            ]);
    }
}
