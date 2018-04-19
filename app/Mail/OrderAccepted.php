<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderAccepted extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        setlocale (LC_TIME, 'fr_FR.utf8', 'fra');
        return $this->subject("Confirmation de votre commande")
            ->markdown('emails.orders.accepted')
            ->with([
                'customerName' => $this->order->customer->firstName,
                'customerEmail' => $this->order->customer->email,
                'customerPhone' => $this->order->customer->phone,
                'lines' => $this->order->lines,
                'address1' => $this->order->address1,
                'address2' => $this->order->address2,
                'address3' => $this->order->address3,
                'zip' => $this->order->zip,
                'date' => strftime('%A %d %B %Y', strtotime($this->order->date)),
                'time' => date('H:i', strtotime($this->order->time)),
                'totalPrice' => $this->order->totalPrice
            ]);
    }
}
