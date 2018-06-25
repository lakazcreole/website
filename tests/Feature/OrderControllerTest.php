<?php

namespace Tests\Feature;

use App\User;
use App\Order;
use App\Product;
use App\Customer;
use Tests\TestCase;
use App\Mail\OrderAccepted;
use App\Mail\OrderDeclined;
use Illuminate\Support\Facades\Mail;
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

    public function testIndex()
    {
        $this->actingAs(factory(User::class)->make(['admin' => true]))
            ->get(route('dashboard.orders.index'))
            ->assertViewIs('orders.index')
            ->assertViewHas('orders', Order::all());
    }

    public function testGetAcceptForm()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->get(route('dashboard.orders.accept', $order))
            ->assertViewIs('orders.accept_form')
            ->assertViewHas('address1', $order->address1)
            ->assertViewHas('address2', $order->address2)
            ->assertViewHas('address3', $order->address3)
            ->assertViewHas('zip', $order->zip)
            ->assertViewHas('deliveryPrice', $order->deliveryPrice)
            ->assertViewHas('fullPrice', $order->fullPrice)
            ->assertStatus(200);
    }

    public function testAccept()
    {
        Mail::fake();
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->post(route('dashboard.orders.accept', $order), ['message' => 'Okay cya l8er.', 'notify' => true])
            ->assertViewIs('orders.accepted')
            ->assertViewHas('address', "{$order->address1} {$order->address2} {$order->address3}")
            ->assertStatus(200);
        $order = Order::find($order->id);
        $this->assertTrue($order->isAccepted());
        $this->assertEquals('Okay cya l8er.', $order->acceptMessage);
        Mail::assertQueued(OrderAccepted::class, function ($mail) use ($order) {
            $mail->build();
            return $mail->hasTo($order->customer->email);
        });
    }

    public function testAcceptWithoutEmail()
    {
        Mail::fake();
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->post(route('dashboard.orders.accept', $order), ['message' => 'Okay cya l8er.', 'notify' => false])
            ->assertViewIs('orders.accepted')
            ->assertViewHas('address', "{$order->address1} {$order->address2} {$order->address3}")
            ->assertStatus(200);
        $order = Order::find($order->id);
        $this->assertTrue($order->isAccepted());
        $this->assertEquals('Okay cya l8er.', $order->acceptMessage);
        Mail::assertNotQueued(OrderAccepted::class);
    }

    public function testAcceptValidatesData()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->post(route('dashboard.orders.accept', $order), [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['message', 'notify']);
    }

    public function testGetDeclineForm()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->get(route('dashboard.orders.decline', $order))
            ->assertViewIs('orders.decline_form')
            ->assertViewHas('address', "{$order->address1} {$order->address2} {$order->address3}")
            ->assertStatus(200);
    }

    public function testDecline()
    {
        Mail::fake();
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->post(route('dashboard.orders.decline', $order), ['message' => 'No.', 'notify' => true])
            ->assertViewIs('orders.declined')
            ->assertViewHas('address', "{$order->address1} {$order->address2} {$order->address3}")
            ->assertStatus(200);
        $order = Order::find($order->id);
        $this->assertTrue($order->isDeclined());
        $this->assertEquals('No.', $order->declineMessage);
        Mail::assertQueued(OrderDeclined::class, function ($mail) use ($order) {
            $mail->build();
            return $mail->hasTo($order->customer->email);
        });
    }

    public function testDeclineWithoutEmail()
    {
        Mail::fake();
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->post(route('dashboard.orders.decline', $order), ['message' => 'No.', 'notify' => false])
            ->assertViewIs('orders.declined')
            ->assertViewHas('address', "{$order->address1} {$order->address2} {$order->address3}")
            ->assertStatus(200);
        $order = Order::find($order->id);
        $this->assertTrue($order->isDeclined());
        $this->assertEquals('No.', $order->declineMessage);
        Mail::assertNotQueued(OrderDeclined::class);
    }

    public function testDeclineValidatesData()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->post(route('dashboard.orders.decline', $order), [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['message', 'notify']);
    }

    public function testCancel()
    {
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->post(route('dashboard.orders.cancel', $order))
            ->assertStatus(200);
        $order = Order::find($order->id);
        $this->assertTrue($order->isCanceled());
    }
}
