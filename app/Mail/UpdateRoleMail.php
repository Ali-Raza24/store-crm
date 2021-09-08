<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class UpdateRoleMail extends Mailable
{
    use Queueable, SerializesModels;

    private $role;

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
        if ($business) {
            return $this->view('email.update-role',
                compact('url', 'business', 'role'))->to($business->email)->subject('Role Updated');
        }
    }
}
