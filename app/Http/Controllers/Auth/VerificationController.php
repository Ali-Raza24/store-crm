<?php

namespace App\Http\Controllers\Auth;

use App\Constants\IStatus;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Mail\BusinessStatusMail;
use App\Models\Business;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\UrlSigner\Exceptions\InvalidSignatureKey;

class VerificationController extends ApiBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        $user = User::find($request->id);

        if ($request->route('id') != $user->getKey()) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()){
            session()->put('verified_already','true');
            return redirect(route('verified-success'))->with('verified_already', true);
        }
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $business = Business::find($user->business_id);

        if (!empty($business)){
            $business->business_status_id = IStatus::BUSINESS_ACTIVE;
            $business->save();

            /*$businessStatusMail = new BusinessStatusMail($business, 'Activated');
            \Mail::send($businessStatusMail);*/
        }
        session()->put('verified','true');
        return redirect(route('verified-success'))->with('verified', true);
    }

    public function verifiedSuccess()
    {
        return view('auth.verified-success');
    }

    public function resend(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        \Auth::login($user);
        if ($request->user()->hasVerifiedEmail()) {
            return $this->sendSuccess('Account already verified.');
        }

        $request->user()->sendEmailVerificationNotification();
        \Auth::logout();
        return $this->sendSuccess('An email sent to your email address. Please verify your account to continue.');
    }
}
