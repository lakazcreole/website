<?php

namespace Tests\Unit;

use App\Subscription;
use Tests\TestCase;
use App\Events\SubscriptionCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
    public function testCreationFiresEvent()
    {
        Event::fake();
        $sub = factory(Subscription::class)->create();
        Event::assertDispatched(SubscriptionCreated::class, function ($event) use ($sub) {
            return $event->subscription->id === $sub->id;
        });
    }
}
