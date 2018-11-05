<?php

namespace Tests\Feature\Api;

use App\Product;
use App\Discount;
use Tests\TestCase;
use App\DiscountItem;
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
        $discountItem = factory(DiscountItem::class)->create(['discount_id' => $discount->id]);
        $discountItem->products()->attach($product->id);
        $this->json('GET', "api/discounts/{$discount->id}")
            ->assertStatus(200)
            ->assertJson([
                'id' => $discount->id,
                'description' => $discount->description,
                'items' => [
                    [
                        'percent' => $discountItem->percent,
                        'required' => $discountItem->required,
                        'products' => [
                            [
                                'id' => $product->id,
                                'name' => $product->name,
                            ]
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
