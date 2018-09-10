<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use App\Customer;
use App\Discount;
use Tests\TestCase;
use App\DiscountItem;
use App\DiscountApply;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountApplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_product_relationship()
    {
        $product = factory(Product::class)->create();
        $discountApply = factory(DiscountApply::class)->create([
            'order_id' => factory(Order::class)->create([
                'customer_id' => factory(Customer::class)->create()->id,
            ])->id,
            'discount_item_id' => factory(DiscountItem::class)->create([
                'discount_id' => factory(Discount::class)->create()->id,
            ]),
            'product_id' => $product->id
        ]);
        $this->assertEquals($product->id, $discountApply->product->id);
    }

    /** @test */
    public function it_has_a_discount_item_relationship()
    {
        $discountItem = factory(DiscountItem::class)->create([
            'discount_id' => factory(Discount::class)->create()->id,
        ]);
        $discountApply = factory(DiscountApply::class)->create([
            'order_id' => factory(Order::class)->create([
                'customer_id' => factory(Customer::class)->create()->id,
            ])->id,
            'discount_item_id' => $discountItem->id,
            'product_id' => factory(Product::class)->create()->id
        ]);
        $this->assertEquals($discountItem->id, $discountApply->discountItem->id);
    }
}
