<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusinessRegister extends Mailable
{
    use Queueable, SerializesModels;

    public $business;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($business)
    {
        $this->business = $business->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.admin.new-business')->to(config('app.admin_email'));
    }
}
