<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class NewRoleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $role;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = route('role-list');
        $business = Auth::user()->business;
        $role = $this->role;
        return $this->view('email.new-role', compact('url', 'business', 'role'))->to($business->email)->subject('New Role Created');
    }
}
