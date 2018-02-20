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
}
