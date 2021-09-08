<?php

namespace App\Mail\Business;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var $order Order
     */
    private $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
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
        $user = $this->order->business->owner_name;
        $url = route('orders-detail', ['id' => $this->order->id]);
        return $this->view('email.business.new-order', compact('user', 'url'));
    }
}
