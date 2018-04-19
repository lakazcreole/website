<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

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
        $this->order->load('customer', 'lines.product');
        return $this->subject("Commande de {$this->order->customer->firstName} - {$this->order->date} {$this->order->date}")
            ->markdown('emails.new_order')
            ->with([
                'customerName' => $this->order->customer->firstName,
                'customerEmail' => $this->order->customer->email,
                'customerPhone' => $this->order->customer->phone,
                'lines' => $this->order->lines,
                'address' => "{$this->order->address1} {$this->order->address2} {$this->order->address3}",
                'zip' => $this->order->zip,
                'information' => $this->order->information,
                'date' => $this->order->date,
                'time' => $this->order->time,
                'totalPrice' => $this->order->totalPrice,
                'acceptUrl' => $this->order->acceptUrl,
                'declineUrl' => $this->order->declineUrl,
            ]);
    }
}
