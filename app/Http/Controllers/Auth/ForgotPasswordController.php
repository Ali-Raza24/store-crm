<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(
            ['email' => 'required|email:rfc,dns|' . Rule::exists('users')],
            [
                'email.exists' => "No record found against this email",
                'email.email' => 'Please enter a valid email address'
            ]);
    }
}
