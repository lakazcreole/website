<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $data = [
            'name' => 'Sally',
            'email' => 'sally@email.com',
            'object' => 'Hello',
            'message' => 'Hey I just wanted to say hi'
        ];
        $this->json('POST', '/api/contact', $data)->assertStatus(201);
        $this->assertDatabaseHas('contacts', $data);
    }
}
