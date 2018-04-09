<?php

namespace Tests\Feature;

use App\User;
use App\Order;
use App\Product;
use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $this->get('/commande')
            ->assertViewIs('orders.create')
            ->assertStatus(200);
    }

    public function testAdminUsersCanAccept()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->get("/dashboard/orders/{$order->id}/accept")
            ->assertViewIs('orders.accepted')
            ->assertViewHas('address', "{$order->address1} {$order->address2} {$order->address3}")
            ->assertStatus(200);
        $this->assertTrue(Order::find($order->id)->isAccepted());
    }

    public function testStandardUsersCannotAccept()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $user = factory(User::class)->make(['admin' => false]);
        $this->actingAs($user)
            ->get("/dashboard/orders/{$order->id}/accept")
            ->assertStatus(403);
        $this->assertFalse(Order::find($order->id)->isAccepted());
    }

    public function testAdminUsersCanGetDeclineForm()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->get("/dashboard/orders/{$order->id}/decline")
            ->assertViewIs('orders.decline_form')
            ->assertViewHas('address', "{$order->address1} {$order->address2} {$order->address3}")
            ->assertStatus(200);
    }

    public function testStandardUsersCannotGetDeclineForm()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $user = factory(User::class)->make(['admin' => false]);
        $this->actingAs($user)
            ->get("/dashboard/orders/{$order->id}/decline")
            ->assertStatus(403);
    }

    public function testAdminUsersCanDecline()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->post("/dashboard/orders/{$order->id}/decline", ['message' => 'No.'])
            ->assertViewIs('orders.declined')
            ->assertViewHas('address', "{$order->address1} {$order->address2} {$order->address3}")
            ->assertStatus(200);
        $order = Order::find($order->id);
        $this->assertTrue($order->isDeclined());
        $this->assertEquals('No.', $order->declineMessage);
    }

    public function testStandardUsersCannotDecline()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $user = factory(User::class)->make(['admin' => false]);
        $this->actingAs($user)
            ->post("/dashboard/orders/{$order->id}/decline", ['message' => 'No.'])
            ->assertStatus(403);
        $this->assertFalse(Order::find($order->id)->isDeclined());
    }
}
