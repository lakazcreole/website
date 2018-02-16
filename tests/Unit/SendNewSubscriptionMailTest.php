<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Subscription;
use App\Mail\NewSubscription;
use App\Events\SubscriptionCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Listeners\SendNewSubscriptionMail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendNewSubscriptionMailTest extends TestCase
{
    public function testSendsNewSubscriptionMail()
    {
        Mail::fake();
        $sub = factory(Subscription::class)->make();
        $listener = new SendNewSubscriptionMail();
        $listener->handle(new SubscriptionCreated($sub));
        Mail::assertSent(NewSubscription::class, function ($mail) use ($sub) {
            return $mail->hasTo('laurane@lakazcreole.fr');
        });
    }
}
