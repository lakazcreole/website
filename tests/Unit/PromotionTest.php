<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use App\Customer;
use App\Promotion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromotionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_discount_for_final_percentage()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 15]));
        $promo = factory(Promotion::class)->create([
            'final_percentage' => 50
        ]);
        $discount = $promo->generateDiscount($order->lines, $order->deliveryPrice);
        $this->assertEquals(7.5, $discount);
    }

    /** @test */
    public function it_can_generate_discount_for_final_raw_amount()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 13]));
        $promo = factory(Promotion::class)->create([
            'final_raw' => 5
        ]);
        $discount = $promo->generateDiscount($order->lines, $order->deliveryPrice);
        $this->assertEquals(5, $discount);
    }

    /** @test */
    public function it_priotizes_percentage_based_discounts()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 15]));
        $promo = factory(Promotion::class)->create([
            'final_percentage' => 50,
            'final_raw' => 5
        ]);
        $discount = $promo->generateDiscount($order->lines, $order->deliveryPrice);
        $this->assertEquals(7.5, $discount);
    }
}
