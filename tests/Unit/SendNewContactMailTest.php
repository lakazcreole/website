<?php

namespace Tests\Unit;

use App\Contact;
use Tests\TestCase;
use App\Mail\NewContact;
use App\Events\ContactCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Listeners\SendNewContactMail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendNewContactMailTest extends TestCase
{
    public function testSendsNewContactMail()
    {
        Mail::fake();
        $contact = factory(Contact::class)->make();
        $listener = new SendNewContactMail();
        $listener->handle(new ContactCreated($contact));
        Mail::assertSent(NewContact::class, function ($mail) use ($contact) {
            return $mail->hasTo('laurane@lakazcreole.fr');
        });
    }
}
