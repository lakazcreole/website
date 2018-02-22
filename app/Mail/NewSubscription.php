<?php

namespace App\Mail;

use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewSubscription extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The subscription instance.
     *
     * @var Subscription
     */
    public $subscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouvel inscrit à la newsletter')
            ->markdown('emails.new_subscription')
            ->with([
                'email' => $this->subscription->email,
            ]);
    }
}
