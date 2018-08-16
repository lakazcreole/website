<?php

namespace Tests\Feature;

use App\User;
use App\Order;
use App\Product;
use App\Customer;
use App\Discount;
use App\PromoCode;
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
        $order->applyPromoCode(factory(PromoCode::class)->create([
            'discount_id' => factory(Discount::class)->create()->id
        ]));
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->get(route('dashboard.orders.accept', $order))
            ->assertStatus(200)
            ->assertViewIs('orders.accept_form')
            ->assertViewHasAll([
                'customerFirstName' => $order->customer->firstName,
                'customerLastName' => $order->customer->lastName,
                'customerEmail' => $order->customer->email,
                'customerPhone' => $order->customer->phone,
                'address1' => $order->address1,
                'address2' => $order->address2,
                'address3' => $order->address3,
                'zip' => $order->zip,
                'city' => $order->city,
                'deliveryPrice' => $order->deliveryPrice,
                'totalProductsPrice' => $order->totalProductsPrice,
                'finalPrice' => $order->finalPrice,
                'discountDescription' => $order->discount->description,
            ]);
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
            ->assertRedirect(route('dashboard.orders.index'))
            ->assertSessionHas('success', "La commande #{$order->id} a été acceptée.");
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
            ->assertRedirect(route('dashboard.orders.index'))
            ->assertSessionHas('success', "La commande #{$order->id} a été acceptée.");
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
        $order->applyPromoCode(factory(PromoCode::class)->create([
            'discount_id' => factory(Discount::class)->create()->id
        ]));
        $admin = factory(User::class)->make(['admin' => true]);
        $this->actingAs($admin)
            ->get(route('dashboard.orders.decline', $order))
            ->assertViewIs('orders.decline_form')
            ->assertStatus(200)
            ->assertViewHasAll([
                'customerFirstName' => $order->customer->firstName,
                'customerLastName' => $order->customer->lastName,
                'customerEmail' => $order->customer->email,
                'customerPhone' => $order->customer->phone,
                'address1' => $order->address1,
                'address2' => $order->address2,
                'address3' => $order->address3,
                'zip' => $order->zip,
                'city' => $order->city,
                'deliveryPrice' => $order->deliveryPrice,
                'totalProductsPrice' => $order->totalProductsPrice,
                'finalPrice' => $order->finalPrice,
                'discountDescription' => $order->discount->description,
            ]);
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
            ->assertRedirect(route('dashboard.orders.index'))
            ->assertSessionHas('success', "La commande #{$order->id} a été refusée.");
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
            ->assertRedirect(route('dashboard.orders.index'))
            ->assertSessionHas('success', "La commande #{$order->id} a été refusée.");
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
            ->assertRedirect(route('dashboard.orders.index'))
            ->assertSessionHas('success', "La commande #{$order->id} a été annulée.");
        $order = Order::find($order->id);
        $this->assertTrue($order->isCanceled());
    }
}
