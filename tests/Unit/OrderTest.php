<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use App\Customer;
use App\OrderLine;
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

    public function testHasCustomerRelationship()
    {
        $order = factory(Order::class)->make([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertNotNull($order->customer);
    }

    public function testHasLinesRelationship()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertNotNull($order->lines);
    }

    public function testAddProduct()
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

    public function testHasTotalPriceAttribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 2]), 2);
        $order->addProduct(factory(Product::class)->create(['price' => 6]));
        $this->assertEquals(10, $order->totalPrice);
    }

    public function testHasAcceptUrlAttribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals(action('OrderController@accept', ['order' => $order->id]), $order->acceptUrl);
    }

    public function testHasDeclineUrlAttribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals(action('OrderController@getDeclineForm', ['order' => $order->id]), $order->declineUrl);
    }

    public function testHasDeliveryPriceAttribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertNotNull($order->deliveryPrice);
    }

    public function testDeliveryPriceBelow13()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 10]));
        // Delivery price is 2 € for orders up to 13 €
        $this->assertEquals(2, $order->deliveryPrice);
    }

    public function testDeliveryPriceBetween13and15()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 14]));
        // Delivery price is the difference between the price and 15 for orders from 13 € to 15 €
        $this->assertEquals(1, $order->deliveryPrice);
    }

    public function testDeliveryPriceFrom15()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 15]));
        // Delivery is free for orders of 15 € or above
        $this->assertEquals(0, $order->deliveryPrice);
    }

    public function testHasFullPriceAttribute()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->addProduct(factory(Product::class)->create(['price' => 14]));
        $this->assertNotNull($order->fullPrice);
        $this->assertEquals(15, $order->fullPrice);
    }

    public function testIsAccepted()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals($order->accepted_at !== null, $order->isAccepted());
    }

    public function testIsDeclined()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $this->assertEquals($order->declined_at !== null, $order->isDeclined());
    }

    public function testAcceptUpdatesModel()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->accept();
        $this->assertNotNull(Order::find($order->id)->accepted_at);
        $this->assertTrue($order->isAccepted());
    }

    public function testDeclineUpdatesModel()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->decline('No.');
        $this->assertNotNull(Order::find($order->id)->declined_at);
        $this->assertTrue($order->isDeclined());
        $this->assertEquals('No.', $order->declineMessage);
    }

    public function testCreationFiresEvent()
    {
        Event::fake();
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        Event::assertDispatched(OrderCreated::class, function ($event) use ($order) {
            return $event->order->id === $order->id;
        });
    }

    public function testAcceptingFiresEvent()
    {
        Event::fake();
        $order = factory(Order::class)->make([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $order->accept();
        Event::assertDispatched(OrderAccepted::class, function ($event) use ($order) {
            return $event->order->id === $order->id;
        });
    }

    public function testDecliningFiresEvent()
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

    public function testHasInformation()
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
}
