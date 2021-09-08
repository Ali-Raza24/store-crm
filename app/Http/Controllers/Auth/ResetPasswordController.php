<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiBaseController;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResetPasswordController extends ApiBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request)
    {
        return view('auth.reset-password');
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        return $this->sendSuccess('Password reset successfully');
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|same:password'
        ];
    }

    protected function validationErrorMessages()
    {
        return [
            'password_confirmation.required' => 'The confirm password field is required',
            'password_confirmation.same' => 'The confirm password must be same as password'
        ];
    }

    public function resetSuccess(Request $request)
    {
        return view('email.reset-success');
    }
}
