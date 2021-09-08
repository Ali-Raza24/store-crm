<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusinessStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $business;

    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($business, $status)
    {
        $this->business = $business;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.business-status')->to($this->business->owner_email)->subject('Business-'.$this->status);
    }
}
