<?php

namespace App\Listeners;

use App\Mail\NewContact;
use App\Events\ContactCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewContactMail implements ShouldQueue
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
     * @param  ContactCreated  $event
     * @return void
     */
    public function handle(ContactCreated $event)
    {
        Mail::to('laurane@lakazcreole.fr')
            ->send(new NewContact($event->contact));
        Log::info('New contact mail sent to laurane@lakazcreole.fr');
    }
}
