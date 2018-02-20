<?php

namespace Tests\Unit;

use App\Contact;
use Tests\TestCase;
use App\Mail\NewContact;
use App\Events\ContactCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Listeners\SendNewContactMail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactCreatedTest extends TestCase
{
    public function testHasListeners()
    {
        $this->assertTrue(Event::hasListeners(ContactCreated::class));
    }

    public function testSendsNewContactMail()
    {
        Mail::fake();
        $contact = factory(Contact::class)->make();
        $listener = new SendNewContactMail();
        $listener->handle(new ContactCreated($contact));
        Mail::assertSent(NewContact::class, function ($mail) use ($contact) {
            $mail->build();
            return $mail->hasTo('laurane@lakazcreole.fr') &&
                $mail->subject === $contact->subject;
        });
    }
}
