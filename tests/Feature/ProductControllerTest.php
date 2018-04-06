<?php

namespace Tests\Feature;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminUserCanAccessDashboardProducts()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $this->actingAs($user)
            ->get('/dashboard/products')
            ->assertStatus(200)
            ->assertViewIs('products.index')
            ->assertViewHas('productTypes', [
                [ 'type' => 'starter', 'title' => 'Entrées' ],
                [ 'type' => 'main', 'title' => 'Plats' ],
                [ 'type' => 'drink', 'title' => 'Boissons' ],
                [ 'type' => 'side', 'title' => 'Accompagnements' ],
            ])
            ->assertViewHas('products', Product::all())
            ->assertViewHas('api_token', $user->api_token);
    }
}
