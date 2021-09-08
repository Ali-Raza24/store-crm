<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CustomerPasswordReset;
use App\Mail\CustomerRegisterMail;
use App\Models\Customer;
use App\Models\User;
use App\Models\UserEmailVerification;
use App\Rules\AlphaSpaces;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Newsletter\Newsletter;
use Spatie\Newsletter\NewsletterFacade;

class UserController extends ApiBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => ['required', new AlphaSpaces(),'max:50'],
            'email' => ['required','email:rfc,dns',Rule::unique('customers','email')->where('business_id', Auth::user()->business_id),'max:50'],
            'password' => ['required','min:8','max:50']
        ]);

        if ($validator->fails()){
            return $this->sendError('Invalid data', [], $validator->messages());
        }

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->business_id = \Auth::user()->business_id;
        $customer->password = Hash::make($request->password);
        $customer->save();

        /*$user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->username = $request->email;
        $user->business_id = \Auth::user()->business_id;
        $user->save();*/

        $customerEmail = new CustomerRegisterMail($customer, true);
        \Mail::send($customerEmail);

        return $this->sendSuccess('User created successfully', $customer);
    }

    public function forgotPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), ['email' => ['required','exists:customers']], ['email.exists' => 'No record found for this email']);

        if ($validator->fails()){
            return $this->sendError('Invalid data', [], $validator->messages());
        }

        $customer = Customer::whereEmail($request->email)->whereBusinessId(\Auth::user()->business_id)->first();
        if ($customer) {
            $customerEmail = new CustomerPasswordReset($customer);
            \Mail::send($customerEmail);

            return $this->sendSuccess('Email sent successfully');
        }else{
            return $this->sendError('No customer found');
        }
    }

    public function validateCode(Request $request)
    {
        $validator = \Validator::make($request->all(), ['email' => ['required','exists:customers']], ['email.exists' => 'No record found for this email']);
        if ($validator->fails()){
            return $this->sendError('Invalid data', [], $validator->messages());
        }

        $validateCode = UserEmailVerification::whereEmail($request->email)->first();
        if (!$validateCode){
            return $this->sendError('Invalid data');
        }

        if ($request->code != $validateCode->code){
            return $this->sendError('Invalid code');
        }

        $validateCode->is_verified = 1;
        $validateCode->save();
        return $this->sendSuccess('Code verified');
    }

    public function verifyUser(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => ['required','exists:customers'],
        ], ['email.exists' => 'No record found for this email']);
        if ($validator->fails()){
            return $this->sendError('Invalid data', [], $validator->messages());
        }

        $user = Customer::whereEmail($request->email)->whereBusinessId(Auth::user()->business_id)->first();

        if (!empty($user->email_verified_at)){
            return $this->sendSuccess('Account already verified');
        }
        if ($user && ($request->new_customer == true || $request->new_cusotmer == true)){
            $user->email_verified_at = Carbon::now();
            $user->save();
            return $this->sendSuccess('Account successfully verified');
        }
        return $this->sendError('Error in account verification', [], 'Error in account verification');
    }

    public function resetPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => ['required','exists:customers'],
            'password' => ['required','confirmed','min:8']
        ], ['email.exists' => 'No record found for this email']);
        if ($validator->fails()){
            return $this->sendError('Invalid data', [], $validator->messages());
        }

        if ($request->new_customer == true || $request->new_cusotmer == true){
            $user = Customer::whereEmail($request->email)->whereBusinessId(Auth::user()->business_id)->first();
            $user->password = Hash::make($request->password);
            $user->email_verified_at = Carbon::now();
        }else{
            $validateCode = UserEmailVerification::whereEmail($request->email)->first();
            if (!$validateCode){
                return $this->sendError('Invalid data');
            }
            $user = Customer::whereEmail($request->email)->whereBusinessId(Auth::user()->business_id)->first();
            $user->password = Hash::make($request->password);
            $user->email_verified_at = Carbon::now();
        }
        $user->save();
        if ($request->new_customer == true || $request->new_cusotmer == true){
            return $this->sendSuccess('Account successfully verified and password updated');
        }
        return $this->sendSuccess('Password successfully updated');
    }
}
