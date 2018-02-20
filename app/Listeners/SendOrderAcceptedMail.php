<?php

namespace App\Listeners;

use App\Events\OrderAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        //
    }
}
