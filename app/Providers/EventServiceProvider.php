<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ContactCreated' => [
            'App\Listeners\SendNewContactMail',
        ],
        'App\Events\SubscriptionCreated' => [
            'App\Listeners\SendNewSubscriptionMail',
        ],
        'App\Events\OrderCreated' => [
            'App\Listeners\SendNewOrderMail',
        ],
        'App\Events\OrderAccepted' => [
            'App\Listeners\SendOrderAcceptedMail',
        ],
        'App\Events\OrderDeclined' => [
            'App\Listeners\SendOrderDeclinedMail',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
