<?php

namespace App\Listeners;

use App\Mail\OrderDeclined as OrderDeclinedMail;
use App\Events\OrderDeclined;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderDeclinedMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderDeclined  $event
     * @return void
     */
    public function handle(OrderDeclined $event)
    {
        Mail::to($event->order->customer->email)->send(new OrderDeclinedMail($event->order));
        Log::info("Order declined mail sent to {$event->order->customer->email}");
    }
}
