<?php

namespace App\Listeners;

use App\Mail\NewOrder;
use App\Events\OrderCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewOrderMail
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        Mail::to('laurane@lakazcreole.fr')->send(new NewOrder($event->order));
        Log::info('New order mail sent to laurane@lakazcreole.fr');
    }
}
