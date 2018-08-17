<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use App\Customer;
use App\Discount;
use App\OrderLine;
use App\PromoCode;
use Tests\TestCase;
use App\Events\OrderCreated;
use App\Events\OrderAccepted;
use App\Events\OrderDeclined;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_customer()
    {
        $customer = factory(Customer::class)->create();
        $order = factory(Order::class)->make([
            'customer_id' => $customer->id
        ]);
        $this->assertEquals($customer->id, $order->customer->id);
    }

    /** @test */
    public function it_has_a_lines_relationship()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertNotNull($order->lines);
    }

    /** @test */
    public function it_has_an_add_product_method()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $product = factory(Product::class)->create();
        $order->addProduct($product, 2);
        $this->assertDatabaseHas('order_lines', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'totalPrice' => 2 * $product->price
        ]);
    }

    /** @test */
    public function it_has_an_accept_url_attribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals(action('OrderController@accept', ['order' => $order->id]), $order->acceptUrl);
    }

    /** @test */
    public function it_has_a_decline_url_attribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals(action('OrderController@getDeclineForm', ['order' => $order->id]), $order->declineUrl);
    }

    /** @test */
    public function it_has_an_is_accepted_method()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals($order->accepted_at !== null, $order->isAccepted());
    }

    /** @test */
    public function it_has_an_is_declined_method()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals($order->declined_at !== null, $order->isDeclined());
    }

    /** @test */
    public function it_has_an_is_cancelled_method()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals($order->canceled_at !== null, $order->isCanceled());
    }

    /** @test */
    public function it_has_an_is_waiting_method()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals($order->accepted_at === null && $order->declined_at === null && $order->canceled_at === null, $order->isWaiting());
    }

    /** @test */
    public function it_updates_the_model_when_accepted()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->accept('Yes.');
        $this->assertNotNull($order->fresh()->accepted_at);
        $this->assertTrue($order->fresh()->isAccepted());
        $this->assertEquals('Yes.', $order->fresh()->acceptMessage);
    }

    /** @test */
    public function it_updates_the_model_when_declined()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->decline('No.');
        $this->assertNotNull($order->fresh()->declined_at);
        $this->assertTrue($order->fresh()->isDeclined());
        $this->assertEquals('No.', $order->fresh()->declineMessage);
    }

    /** @test */
    public function it_updates_the_model_when_cancelled()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->cancel();
        $this->assertNotNull($order->fresh()->canceled_at);
        $this->assertTrue($order->fresh()->isCanceled());
    }

    /** @test */
    public function it_fires_an_event_when_created()
    {
        Event::fake();
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        Event::assertDispatched(OrderCreated::class, function ($event) use ($order) {
            return $event->order->id === $order->id;
        });
    }

    /** @test */
    public function it_fires_an_event_when_accepted()
    {
        Event::fake();
        $order = factory(Order::class)->make([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->accept('Yes!');
        Event::assertDispatched(OrderAccepted::class, function ($event) use ($order) {
            return $event->order->id === $order->id;
        });
    }

    /** @test */
    public function it_fires_an_event_when_declined()
    {
        Event::fake();
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->decline('No.');
        Event::assertDispatched(OrderDeclined::class, function ($event) use ($order) {
            return $event->order->id === $order->id;
        });
    }

    /** @test */
    public function it_has_an_information_field()
    {
        $order = factory(Order::class)->create([
            'information' => 'test',
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'information' => 'test'
        ]);
    }

    /** @test */
    public function it_can_be_applied_a_promo_code()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $discount = factory(Discount::class)->create();
        $promoCode = factory(PromoCode::class)->create([
            'discount_id' => $discount->id,
        ]);
        $order->applyPromoCode($promoCode);
        $this->assertEquals($promoCode->id, $order->fresh()->promoCode->id);
    }

    // /** @test */
    // public function it_does_not_apply_promo_code_if_required_products_are_missing()
    // {
    //     $product = factory(Product::class)->create();
    //     $order = factory(Order::class)->create([
    //         'customer_id' => factory(Customer::class)->create()->id
    //     ]);
    //     $discount = factory(Discount::class)->create();
    //     $promoCode = factory(PromoCode::class)->create([
    //         'discount_id' => $discount->id,
    //     ]);
    //     $order->applyPromoCode($promoCode);
    // }

    /** @test */
    public function it_has_a_discount_attribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $discount = factory(Discount::class)->create();
        $promoCode = factory(PromoCode::class)->create([
            'discount_id' => $discount->id,
        ]);
        $this->assertEquals(null, $order->discount);
        $order->applyPromoCode($promoCode);
        $this->assertEquals($promoCode->discount->id, $order->discount->id);
    }

    /** @test */
    public function it_has_a_total_products_price_attribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 2]), 2);
        $order->addProduct(factory(Product::class)->create(['price' => 6]));
        $this->assertEquals(10, $order->totalProductsPrice);
    }

    /** @test */
    public function it_has_a_delivery_price_attribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertNotNull($order->deliveryPrice);
    }

    /** @test */
    public function it_adjusts_delivery_price_below_13()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 10]));
        // Delivery price is 2 € for orders up to 13 €
        $this->assertEquals(2, $order->deliveryPrice);
    }

    /** @test */
    public function it_adjusts_delivery_price_between_13_and_15()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 14]));
        // Delivery price is the difference between the price and 15 for orders from 13 € to 15 €
        $this->assertEquals(1, $order->deliveryPrice);
    }

    /** @test */
    public function it_adjusts_delivery_price_above_15()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 15]));
        // Delivery is free for orders of 15 € or above
        $this->assertEquals(0, $order->deliveryPrice);
    }

    /** @test */
    public function it_has_a_price_before_discount_attribute()
    {
        $product = factory(Product::class)->create(['price' => 15]);
        $discount = factory(Discount::class)->create();
        $discount->addFreeProduct($product);
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct($product);
        $order->applyPromoCode(factory(PromoCode::class)->create([
            'discount_id' => $discount->id,
        ]));
        $this->assertEquals(15, $order->priceBeforeDiscount);
    }

    /** @test */
    public function it_has_a_final_price_attribute()
    {
        $product = factory(Product::class)->create(['price' => 15]);
        $discount = factory(Discount::class)->create();
        $discount->addFreeProduct($product);
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct($product);
        $order->applyPromoCode(factory(PromoCode::class)->create([
            'discount_id' => $discount->id
        ]));
        $this->assertNotNull($order->finalPrice);
        $this->assertEquals(0, $order->finalPrice);
    }
}
