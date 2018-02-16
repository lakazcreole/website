<?php

namespace App\Listeners;

use App\Mail\NewSubscription;
use App\Events\SubscriptionCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewSubscriptionMail
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
     * @param  SubscriptionCreated  $event
     * @return void
     */
    public function handle(SubscriptionCreated $event)
    {
        Mail::to('laurane@lakazcreole.fr')
            ->send(new NewSubscription($event->subscription));
        Log::info('New subscription mail sent to laurane@lakazcreole.fr');
    }
}
