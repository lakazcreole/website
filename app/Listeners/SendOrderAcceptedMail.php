<?php

namespace App\Listeners;

use App\Events\OrderAccepted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\OrderAccepted as OrderAcceptedMail;

class SendOrderAcceptedMail
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
     * @param  OrderAccepted  $event
     * @return void
     */
    public function handle(OrderAccepted $event)
    {
        if ($event->order->notifyAccept)
        {
            Mail::to($event->order->customer->email)
                ->send(new OrderAcceptedMail($event->order));
            Log::info("Order accepted mail sent to {$event->order->customer->email}");
        }
    }
}
