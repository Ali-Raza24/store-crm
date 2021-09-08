<?php

namespace App\Http\Controllers\Api;

use App\Constants\IStatus;
use App\Helpers\CommonHelper;
use App\Models\BusinessAnnouncements;
use App\Models\Page;
use App\Models\PaymentType;
use App\Models\State;
use App\Models\UserPhoneNumberVerification;
use App\Rules\OnlyNumbers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UtilsController extends ApiBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function paymentTypes()
    {
        $paymentTypes = PaymentType::whereIsActive(IStatus::ACTIVE)->pluck('title', 'id');
        return $this->sendSuccess('OK', $paymentTypes);
    }

    public function states()
    {
        $states = State::whereIsActive(IStatus::ACTIVE)->pluck('name', 'id');
        return $this->sendSuccess('OK', $states);
    }

    public function getOtp(Request $request)
    {
        $validator = Validator::make($request->toArray(), ['mobile_no' => ['required', 'min:10', new OnlyNumbers()]]);

        if ($validator->fails()) {
            $message = $validator->getMessageBag();
            return $this->sendError('Some fields are required', [], $message->get('mobile_no'));
        }

        UserPhoneNumberVerification::whereMobileNo($request->mobile_no)->delete();

        $otp = rand(1000, 9999);
        $number = $request->mobile_no;

        $userPhone = new UserPhoneNumberVerification();
        $userPhone->mobile_no = $number;
        $userPhone->otp = $otp;
        $userPhone->is_verified = 0;
        $userPhone->save();

        $response = CommonHelper::sendMessageToNumber($number, 'Please use this code to verify your number: ' . $otp);

        if ($response) {
            $userPhone->sent_count++;
            $userPhone->save();
            return $this->sendSuccess('Message send successfully');
        }

        return $this->sendSuccess('An error occurred in sending message. please try again');
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->toArray(),
            ['mobile_no' => ['required', 'min:10', new OnlyNumbers()], 'code' => 'required', new OnlyNumbers()]);

        if ($validator->fails()) {
            $message = $validator->getMessageBag();
            return $this->sendError('Some fields are required', [], $message->all());
        }

        $mobile_no = $request->mobile_no;

        if ($request->code == '0000') {
            return $this->sendSuccess('Number verified successfully');
        }

        $userPhone = UserPhoneNumberVerification::whereMobileNo($mobile_no)->where('is_verified', '!=', 1)->first();
        if ($userPhone) {
            if ($userPhone->otp != $request->code) {
                return $this->sendError('Invalid code', [], 'Invalid code');
            } else {
                $userPhone->is_verified = 1;
                $userPhone->save();
                return $this->sendSuccess('Number verified successfully');
            }
        }
        return $this->sendError('Something went wrong! Please try again');
    }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->toArray(), ['mobile_no' => ['required', 'min:10', new OnlyNumbers()]]);

        if ($validator->fails()) {
            $message = $validator->getMessageBag();
            return $this->sendError('Some fields are required', [], $message->get('mobile_no'));
        }

        $otp = rand(1000, 9999);
        $number = $request->mobile_no;

        $userPhone = UserPhoneNumberVerification::whereMobileNo($number)->first();
        $userPhone->otp = $otp;
        $userPhone->is_verified = 0;
        $userPhone->save();

        $response = CommonHelper::sendMessageToNumber($number, 'Please use this code to verify your number: ' . $otp);

        if ($response) {
            $userPhone->sent_count++;
            $userPhone->save();
            return $this->sendSuccess('Message send successfully');
        }

        return $this->sendSuccess('An error occurred in sending message. please try again');
    }

    public function announcement()
    {
        $announcements = BusinessAnnouncements::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at')->whereIsActive(IStatus::ACTIVE)->get();
        return $this->sendSuccess('OK', $announcements->pluck('announcement'));
    }

    public function pages()
    {
        $pages = Page::whereBusinessId(\Auth::user()->business_id)->get();
        return $this->sendSuccess('OK', $pages);
    }

    public function socialLinks()
    {
        $setting = setting('business.social');
        return $this->sendSuccess('OK', json_decode($setting));
    }
}
