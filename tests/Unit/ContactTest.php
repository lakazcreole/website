<?php

namespace Tests\Unit;

use App\Contact;
use Tests\TestCase;
use App\Events\ContactCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    public function testCreationFiresEvent()
    {
        Event::fake();
        $contact = factory(Contact::class)->create();
        Event::assertDispatched(ContactCreated::class, function ($event) use ($contact) {
            return $event->contact->id === $contact->id;
        });
    }
}
