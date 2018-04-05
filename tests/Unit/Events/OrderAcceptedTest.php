<?php

namespace Tests\Unit\Events;

use App\Order;
use App\Customer;
use Tests\TestCase;
use App\Events\OrderAccepted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendOrderAcceptedMail;
use Illuminate\Foundation\Testing\WithFaker;
use App\Mail\OrderAccepted as OrderAcceptedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderAcceptedTest extends TestCase
{
    use RefreshDatabase;

    public function testHasListeners()
    {
        $this->assertTrue(Event::hasListeners(OrderAccepted::class));
    }

    public function testSendsOrderAcceptedMail()
    {
        Mail::fake();
        $order = factory(Order::class)->create([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $listener = new SendOrderAcceptedMail();
        $listener->handle(new OrderAccepted($order));
        Mail::assertSent(OrderAcceptedMail::class, function ($mail) use ($order) {
            $mail->build();
            return $mail->hasTo($order->customer->email);
        });
    }
}
