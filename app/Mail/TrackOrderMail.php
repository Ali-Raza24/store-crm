<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrackOrderMail extends Mailable
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
        $user = $this->order->customer;
        $url = config('urls.store_url').'/'.$this->order->business->url.'/track_order/'.$this->order->order_number;
        $business = $this->order->business;
        return $this->view('email.track-order', compact('user', 'url', 'business'))->subject('Order Confirmation');
    }
}
