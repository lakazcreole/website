<?php

namespace Tests\Unit;

use App\Contact;
use Tests\TestCase;
use App\Mail\NewContact;
use App\Events\ContactCreated;
use Illuminate\Support\Facades\Mail;
use App\Listeners\SendNewContactMail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactCreatedEventTest extends TestCase
{
    public function testSendsNewContactMail()
    {
        Mail::fake();
        $listener = new SendNewContactMail();
        $listener->handle(new ContactCreated(factory(Contact::class)->make()));
        Mail::assertSent(NewContact::class, function ($mail) {
            return $mail->hasTo('laurane@lakazcreole.fr');
        });
    }
}
