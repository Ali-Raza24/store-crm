<?php

namespace App\Http\Controllers\Auth;

use App\Constants\IStatus;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\Translation\t;

class LoginController extends ApiBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['adminBusinessLogin', 'adminBusinessLogout']);
        $this->middleware('guest')->except(['logout', 'adminBusinessLogin', 'adminBusinessLogout']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make(
            $request->all(),
            $this->validateLogin()
        );
        if ($validator->fails()) {
            return $this->sendError('',[],$validator->messages());
        }

        if ($request->captcha === false) {
            return $this->sendError('',[],['captcha' => ['captcha verification is required']]);
        }

        $user = User::whereEmail($request->email)->whereNull('deleted_at')->first();

        if (!$user) {
            return $this->sendError('',[],['invalid' => ['Invalid credentials']]);
        }

        if (! password_verify($request->password,$user->password)){
            return $this->sendError('',[],['invalid' => ['Invalid credentials']]);
        }

        if ($user->is_business == 1) {
            if (optional($user->business)->business_status_id == IStatus::BUSINESS_PENDING || empty($user->email_verified_at)) {
                return $this->sendError('',[],['email_verification_pending' => ['Your account is not yet activated, please check your email to get verified.']]);
            }

            if (optional($user->business)->business_status_id == IStatus::BUSINESS_INACTIVE) {
                return $this->sendError('',[],['invalid' => ['Your account is disabled by Administrator']]);
            }

            if (optional($user->business)->business_status_id == IStatus::BUSINESS_SUSPENDED) {
                return $this->sendError('',[],['invalid' => ['Your account is suspended by Administrator']]);
            }
        }
        if (empty($user->email_verified_at)) {
            return $this->sendError('',[],['email_verification_pending' => ['Your account is not yet activated, please check your email to get verified.']]);
        }
        if (!$user->is_active === IStatus::USER_DISABLED) {
            return $this->sendError('',[],['invalid' => ['User disabled by Administrator']]);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $this->sendLoginResponse($request);
            return $this->sendSuccess('User logged in successfully', new UserResource($user));
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        $this->sendFailedLoginResponse($request);
        return $this->sendError('Invalid credentials');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }

    protected function validateLogin()
    {
        return [
            $this->username() => 'required|string|email:rfc,dns',
            'password' => 'required|string'
        ];
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login');
    }

    public function adminBusinessLogin(Request $request)
    {

        $user = User::whereEmail($request->email)->first();

        if($user){
            \Auth::login($user);
            session()->put('isAdmin', true);
            return redirect()->route('store-select');
        }
        return abort(404);
    }

    public function adminBusinessLogout(Request $request)
    {
        $user = User::whereHas('roles', function ($q){
            $q->where('name','=','Super Admin');
        })->first();

        if($user){
            \Auth::login($user);
            session()->remove('isAdmin');
            return redirect()->route('admin-dashboard');
        }
        return abort(404);
    }
}
