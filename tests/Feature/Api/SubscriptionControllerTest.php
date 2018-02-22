<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $data = [
            'email' => 'sally@email.com',
        ];
        $this->json('POST', '/api/subscription', $data)->assertStatus(201);
        $this->assertDatabaseHas('subscriptions', $data);
    }

    public function testStoreValidatesData()
    {
        $data = [
            'email' => ''
        ];
        $this->json('POST', '/api/subscription', $data)->assertStatus(422);
        $this->json('POST', '/api/subscription', [])->assertStatus(422);
    }

    public function testEmailsAreUnique()
    {
        $data = [
            'email' => 'sally@email.com',
        ];
        $this->json('POST', '/api/subscription', $data)->assertStatus(201);
        $this->json('POST', '/api/subscription', $data)->assertStatus(422);
    }

}
