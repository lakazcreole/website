<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use App\Customer;
use App\OrderLine;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderLineTest extends TestCase
{
    use RefreshDatabase;

    public function testHasProductRelationship()
    {
        $orderLine = factory(OrderLine::class)->make([
            'order_id' => factory(Order::class)->create([
                'customer_id' => factory(Customer::class)->create()->id,
            ])->id,
            'product_id' => factory(Product::class)->create()->id
        ]);
        $this->assertNotNull($orderLine->product);
    }
}
