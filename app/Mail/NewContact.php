<?php

namespace App\Mail;

use App\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewContact extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The contact instance.
     *
     * @var Contact
     */
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->contact->subject)
            ->markdown('emails.new_contact')
            ->with([
                'name' => $this->contact->name,
                'email' => $this->contact->email,
                'message' => $this->contact->message
            ]);
    }
}
