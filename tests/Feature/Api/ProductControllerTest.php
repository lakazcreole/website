<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    public function testIndex()
    {
        $resp = $this->json('GET', '/api/products')
            ->assertStatus(200)
            ->assertJson([
                'data' => [],
            ]);
    }
}
