<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OogoPayIntegrationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $business;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($business)
    {
        $this->business = $business;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $business = $this->business;
        return $this->view('email.oogo-pay-integration', compact('business'));
    }
}
