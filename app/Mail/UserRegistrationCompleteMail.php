<?php

namespace App\Mail;

use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationCompleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $business;

    /**
     * Create a new message instance.
     * @param $business Business
     *
     * @return void
     */
    public function __construct($business)
    {
        $this->user = $business->user;
        $this->business = $business;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $business = $this->business;
        return $this->view('email.user-register-complete', compact('business', 'user'));
    }
}
