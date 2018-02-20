<?php

namespace Tests\Unit;

use App\Order;
use Tests\TestCase;
use App\Events\OrderDeclined;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendOrderDeclinedMail;
use Illuminate\Foundation\Testing\WithFaker;
use App\Mail\OrderDeclined as OrderDeclinedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderDeclinedTest extends TestCase
{
    public function testHasListeners()
    {
        $this->assertTrue(Event::hasListeners(OrderDeclined::class));
    }

    // public function testSendsOrderDeclinedMail()
    // {
    //     Mail::fake();
    //     $order = factory(Order::class)->create();
    //     $listener = new SendOrderDeclinedMail();
    //     $listener->handle(new OrderDeclined($order));
    //     Mail::assertSent(OrderDeclinedMail::class, function ($mail) use ($order) {
    //         $mail->build();
    //         return $mail->hasTo($order->customer->email) &&
    //             $mail->hasFrom(config('app.mail.username'));
    //     });
    // }
}
