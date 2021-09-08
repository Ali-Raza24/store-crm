<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    private $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $amount)
    {
        $this->amount = $amount;
        $this->user =$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $amount = $this->amount;
        return $this->view('email.payment-success', compact('user', 'amount'));
    }
}
