<?php

namespace Tests\Feature\Api;

use App\Product;
use App\Discount;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountControllerShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_json()
    {
        $product = factory(Product::class)->create();
        $discount = factory(Discount::class)->create();
        $discount->addProduct($product, 100, 12, true);
        $this->json('GET', "api/discounts/{$discount->id}")
            ->assertStatus(200)
            ->assertJson([
                'id' => $discount->id,
                'description' => $discount->description,
                'products' => [
                    [
                        'id' => $product->id,
                        'pivot' => [
                            'product_id' => $product->id,
                            'percent' => 100,
                            'max_items' => 12,
                            'required' => true
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_sens_an_error_for_unexisting_promotions()
    {
        $this->json('GET', 'api/discounts/0')
            ->assertStatus(404);
    }
}
