<?php

namespace Tests\Feature\Api;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $this->json('GET', '/api/products')
            ->assertStatus(200)
            ->assertJson([
                'data' => [],
            ]);
    }

    public function testIndexCanBeOrdered()
    {
        factory(Product::class)->create(['name' => 'B', 'disabled' => false]);
        factory(Product::class)->create(['name' => 'A', 'disabled' => false]);
        $res = $this->json('GET', '/api/products?order=true')
            ->assertStatus(200);
        $data = $res->json()['data'];
        $this->assertTrue(strcmp($data[0]['name'], $data[1]['name']) < 0);
    }

    public function testStandardUserCannotUpdate()
    {
        $user = factory(User::class)->create(['admin' => false]);
        $product = factory(Product::class)->create();
        $this->actingAs($user, 'api')
            ->json('PUT', "/api/products/{$product->id}", [])
            ->assertStatus(403);
    }

    public function testAdminUserCanUpdate()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $product = factory(Product::class)->create(['disabled' => false]);
        $this->actingAs($user, 'api')
            ->json('PUT', "/api/products/{$product->id}", ['disabled' => true])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'disabled' => true
                ]
            ]);
        // $this->assertTrue(Product::find($product->id)->disabled);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'disabled' => true
        ]);
    }

    public function testUpdateValidatesRequest()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $product = factory(Product::class)->create(['disabled' => false]);
        $r = $this->actingAs($user, 'api')
            ->json('PUT', "/api/products/{$product->id}", [])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'disabled' => []
                ]
            ]);
    }
}
