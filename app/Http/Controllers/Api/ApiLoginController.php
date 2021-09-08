<?php

namespace App\Http\Controllers\Api;

use App\Constants\IStatus;
use App\Helpers\ArrayHelper;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\StoreResource;
use App\Models\Business;
use App\Models\BusinessAnnouncements;
use App\Models\BusinessToken;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DeliveryCompaniesCity;
use App\Models\DeliveryCompanyArea;
use App\Models\Page;
use App\Models\PaymentType;
use App\Models\State;
use App\Models\User;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ApiLoginController extends ApiBaseController
{
    private $storeService;

    public function __construct(StoreService $storeService)
    {
        parent::__construct();
        $this->storeService = $storeService;
    }

    public function login(Request $request)
    {
        $business = Business::whereNull('deleted_at')
            ->whereRaw('LOWER(url) = "'.strtolower($request->business_url).'"')
            ->whereBusinessStatusId(IStatus::BUSINESS_ACTIVE)
            ->first();

        if ($business){
            $user = $business->user;



            $token = Str::uuid();

//            BusinessToken::where('business_id',$business->id)->delete();

            $businessToken = new BusinessToken();
            $businessToken->id = Str::uuid();
            $businessToken->business_id = $business->id;
            $businessToken->token = $token;
            $businessToken->save();

            if ($user) {
                \Auth::login($user);

                $stores = $this->storeService->search(['active' => true]);

                $store = null;
                if (\Arr::first($stores)){
                    $store = \Arr::first($stores);
                }

                $categories = [];

                if ($store) {
                    $categories = Category::with([
                        'products' => function ($q) use ($store) {
                            $q->whereNull('deleted_at');
                            $q->whereHas('stores', function ($q2) use ($store) {
                                $q2->whereStoreId($store->id);
                            });
                        }
                    ])->activeBusiness()->get();
                }

                $page = Page::whereBusinessId(\Auth::user()->business_id)->whereSlug('main-page')->first();

                $plan = optional(Auth::user()->business)->plan;
                $selectedPlanOptions =  optional($plan)->planoption;

                $optionValues = array_column($selectedPlanOptions->toArray(),'values');
                $optionsList = [];
                foreach ($optionValues as $value){
                    $seprated = explode(',', $value);
                    if (count($seprated) > 1) {
                        foreach ($seprated as $item) {
                            $optionsList[] = $item;
                        }
                    }else{
                        $optionsList[] = $value;
                    }
                }
                $checkoutSetting = [];

                $decodedCheckout = json_decode(setting('checkout'));
                if (is_array($decodedCheckout) || is_object($decodedCheckout)) {
                    foreach ($decodedCheckout as $key => $item) {
                        if (ArrayHelper::hasAnyValues($optionsList, ['online-payments']) && $key == 'card_payment') {
                            $checkoutSetting[$key] = $item;
                        } elseif (ArrayHelper::hasAnyValues($optionsList,
                                ['cash-on-delivery']) && $key == 'cash_payment') {
                            $checkoutSetting[$key] = $item;
                        } elseif ($key != 'cash_payment' && $key != 'card_payment') {
                            $checkoutSetting[$key] = $item;
                        }
                    }
                }

                return $this->sendSuccess('OK', [
                    'accessToken' => \Crypt::encrypt($token),
                    'logo' => \Auth::user()->business->logo,
                    'slider' => [
                        'mobile_logo' => \Auth::user()->business->logo_mobile,
                        'image' => optional($page)->web_banner,
                        'mobile_image' => optional($page)->mobile_banner,
                        'heading' => optional($page)->heading,
                        'sub_heading' => optional($page)->sub_heading,
                        'description' => optional($page)->content
                    ],
                    'social' => json_decode(setting('business.social')),
                    'contact' => [
                        'email' => isset($business->email) ? $business->email : $business->owner_email,
                        'phone' => isset($business->phone) ? $business->phone : $business->owner_phone,
                        'mobile' => isset($business->mobile) ? $business->mobile : $business->owner_mobile,
                        'address_1' => $business->address_1,
                        'address_2' => $business->address_2,
                    ],
                    'fb_pixel' =>  html_entity_decode(check_setting('pixel','script')),
                    'brand_color' => isset($business->brand_color) ? $business->brand_color : '#000000',
                    'checkout_setting' => $checkoutSetting,
                    'tax_value' => json_decode(setting('tax')),
                    'stores' => StoreResource::collection($stores),
                    'products' =>  CategoryResource::collection($categories),
                    'states' => State::whereIsActive(IStatus::ACTIVE)->pluck('name','id'),
                    'paymentTypes' => PaymentType::whereIsActive(IStatus::ACTIVE)->pluck('title','id'),
                    'announcements' => BusinessAnnouncements::whereBusinessId(\Auth::user()->business_id)
                        ->whereNull('deleted_at')
                        ->whereIsActive(IStatus::ACTIVE)
                        ->get()
                        ->pluck('announcement'),
                    'pages' => Page::whereBusinessId(\Auth::user()->business_id)->whereNotIn('slug',['main-page'])->whereIsActive(IStatus::ACTIVE)->get(),
                    'aramex_cities' => $this->mapAramexCities(),
                    'permissions' => [
                        'discount' => plan_permission('discount')
                    ]
                ]);
            } else {
                return $this->sendError('No store found', []);
            }
        }

        return $this->sendError('No store found', []);

    }

    private function mapAramexCities(){
        $cities = DeliveryCompaniesCity::all()->pluck('city_name','id');
        $list = [];
        foreach ($cities as $key => $city) {
            $list[] = [
                'id' => $key,
                'title' => $city,
                'areas' => optional(DeliveryCompanyArea::whereStateId($key)->get(['id','area']))->toArray()
            ];
        }
        return $list;
    }

    public function customerLogin(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => ['required', 'exists:customers'],
            'password' => ['required']
        ], ['email.exists' => 'Invalid credentials']);

        if ($validator->fails()){
            return $this->sendError('Invalid credentials', [],$validator->messages());
        }

        $user = Customer::whereEmail($request->email)->whereBusinessId(\Auth::user()->business_id)->first();

        if (empty($user->email_verified_at)){
            return $this->sendError('Please confirm your email address');
        }

        if (!$user){
            return $this->sendError('User not found');
        }

        if (!Hash::check($request->password, $user->password)){
            return $this->sendError('Invalid credentials');
        }

        $customer = Customer::whereEmail($request->email)->whereBusinessId(\Auth::user()->business_id)->first();

        session()->put('customer', $customer);

        return $this->sendSuccess('User loggedIn Successfully', session()->get('customer'));
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'exists:customers']]);

    }
}
