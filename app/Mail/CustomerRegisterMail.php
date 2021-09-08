<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class CustomerRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var $customer Customer
     */
    private $customer;

    private $registeredCustomer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer, $registeredCustomer = false)
    {
        $this->customer = $customer;
        $this->registeredCustomer = $registeredCustomer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = config('urls.store_url').'/'.$this->customer->business->url.'/password/update/'.base64_encode($this->customer->email).'?registered='.(bool)$this->registeredCustomer;
        return $this->view('email.new-customer',['user' => $this->customer, 'url' => $url])->to($this->customer->email);
    }
}
