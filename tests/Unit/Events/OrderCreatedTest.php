<?php

namespace Tests\Unit;

use App\Order;
use App\Customer;
use Tests\TestCase;
use App\Mail\NewOrder;
use App\Events\OrderCreated;
use App\Listeners\SendNewOrderMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderCreatedTest extends TestCase
{
    use RefreshDatabase;

    public function testHasListeners()
    {
        $this->assertTrue(Event::hasListeners(OrderCreated::class));
    }

    public function testSendsNewOrderMail()
    {
        Mail::fake();
        $order = factory(Order::class)->make([
            'customer_id' => factory(Customer::class)->create()->id
        ]);
        $listener = new SendNewOrderMail();
        $listener->handle(new OrderCreated($order));
        Mail::assertQueued(NewOrder::class, function ($mail) use ($order) {
            $mail->build();
            return $mail->hasTo('laurane@lakazcreole.fr') &&
                $mail->subject === "Commande de {$order->customer->firstName} - {$order->date} {$order->date}";
        });
    }
}
