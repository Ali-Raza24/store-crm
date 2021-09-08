<?php

namespace App\Mail;

use App\Models\UserEmailVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    private $customer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $code = rand(1000,9999);

        UserEmailVerification::whereEmail($this->customer->email)->delete();

        $verify = new UserEmailVerification();
        $verify->code = $code;
        $verify->email = $this->customer->email;
        $verify->is_verified = 0;
        $verify->save();

        return $this->view('email.customer-password-reset',['customer' => $this->customer, 'code' => $code])->to($this->customer->email);
    }
}
