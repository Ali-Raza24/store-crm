<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Events\AccountInfoUpdated as AccountInfoUpdatedEvent;
use App\Events\StoreInfoUpdated as StoreInfoUpdatedEvent;
use App\Http\Requests\AccountSettingRequest;
use App\Http\Requests\StoreSettingRequest;
use App\Models\Bank;
use App\Models\Business;
use App\Models\Order;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Store;
use App\Models\User;
use App\Notifications\AccountInfoUpdated as AccountInfoUpdatedNotify;
use App\Notifications\StoreInfoUpdated as StoreInfoUpdatedNotify;
use App\Rules\OnlyNumbers;
use App\Services\BusinessService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use function Symfony\Component\Translation\t;

class GeneralSettingsController extends Controller
{

    private $businessService;

    private $imageService;

    public function __construct(BusinessService $businessService, ImageService $imageService)
    {
        $this->businessService = $businessService;
        $this->imageService = $imageService;
        parent::__construct();
    }

    public function page(Request $request)
    {
        session()->remove('showMainPageTab');
        $pages = Page::whereNull('deleted_at')->where('business_id', '=',
            Auth::user()->business_id)->paginate(AppConstants::PAGINATE_SMALL);
        return view("business.settings.pages.index", ['pages' => $pages]);
    }

    public function store(StoreSettingRequest $request)
    {
        $store = session()->get('store-data');
        if (!$store) {
            $store = Store::whereBusinessId(Auth::user()->business_id)->first();
            session()->put('store-data', $store);
            session()->put('store-name', $store->name);
        }
        $business = Business::find(Auth::user()->business_id);
        $store = Store::find($store->id);

        if ($request->getMethod() == Request::METHOD_PUT || $request->getMethod() == Request::METHOD_POST) {
            $rule = [];
            if (!empty($request->eid_upload)) {
                $rule = ['images.eid' => ['required', 'mimes:jpeg,png,jpg,gif,docs,doc,pdf']];
            }

            if (!empty($request->trade_upload)) {
                $rule = ['images.trade' => ['required']];
            }

            if (!empty($request->images['profile'])) {
                $rule = ['images.profile' => [/*Rule::dimensions()->ratio('1:1'),*/ 'max:2000', 'mimes:jpg,bmp,png']];
            }

            if (!empty($request->images['logo'])) {
                $rule = ['images.logo' => ['mimes:jpg,bmp,png', /*Rule::dimensions()->ratio('1:1'),*/ 'max:2000']];
            }

            if (!empty($request->images['logo_mobile'])) {
                $rule = ['images.logo_mobile' => ['mimes:jpg,bmp,png', /*Rule::dimensions()->width('140')->height('35'),*/ 'max:2000']];
            }

            $validator = Validator::make($request->all(), $rule, [
                'images.eid.required' => 'Eid is required',
                'images.trade.required' => 'Trade License is required',
                'images.profile.dimensions' => 'Profile image must be in square i.e 1:1 ratio',
                'images.logo.dimensions' => 'Logo image must be in square i.e 1:1 ratio',
                'images.logo_mobile.dimensions' => 'Please upload image of resolution 140 X 35',
                'images.logo.max' => 'Logo must be less than 2MB',
                'images.profile.max' => 'Profile image must be less than 2MB',
                'images.logo_mobile.max' => 'Mobile logo must be less than 2MB',
                'images.logo.mimes' => 'Please upload only supported file types. (JPG, PNG, BMP)',
                'images.profile.mimes' => 'Please upload only supported file types. (JPG, PNG, BMP)',
                'images.logo_mobile.mimes' => 'Please upload only supported file types. (JPG, PNG, BMP)',
            ]);

            $messages = $validator->getMessageBag()->toArray();

            if (\Arr::has($messages, 'images.eid')) {
                return response()->json(['error' => \Arr::first($messages['images.eid'])], 422);
            }
            if (\Arr::has($messages, 'images.trade')) {
                return response()->json(['error' => \Arr::first($messages['images.trade'])], 422);
            }

            if (\Arr::has($messages, 'images.profile')) {
                return response()->json(['error' => \Arr::first($messages['images.profile'])], 200);
            }
            if (\Arr::has($messages, 'images.logo')) {
                return response()->json(['error' => \Arr::first($messages['images.logo'])], 200);
            }
            if (\Arr::has($messages, 'images.logo_mobile')) {
                return response()->json(['error' => \Arr::first($messages['images.logo_mobile'])], 200);
            }
            $file = $request->all();
            $key = Arr::first(array_keys($file['images']));
            $url = '';

            if (!in_array($key, ['logo', 'logo_mobile', 'profile'])) {
                $this->businessService->register($request, true);
            }else{
                $url = $this->imageService->saveImageObj($request->images[$key], $key, Auth::user()->business_id, Business::class, 'business');
            }

            $requestData = $request->all();
            if (isset($requestData['stores'])) {

                $stores = Arr::first($requestData['stores']);

                $store = Store::find($stores['store_id']);


                session()->put('store-data', $store);
                session()->put('store-name', $store->name);

                $object = new \stdClass();
                $object->user = Auth::user()->name;
                $object->store_name = $store->name;
                $object->store_slug = $store->slug;

                Business::find(Auth::user()->business_id)->user->notify(new StoreInfoUpdatedNotify($object));

                event(new StoreInfoUpdatedEvent());
            }
            if ($request->ajax()){
                $business = Business::find(Auth::user()->business_id);
                $file = $request->all();
                if (!empty($file['images'])) {
                    $key = array_keys($file['images']);
                    $image = $url;
                    return response()->json(['url' => $image, 'status' => 'OK']);
                }
                return response()->json(['error' => 'Please select an image']);
            }else{
                flash('Store information updated')->success();
                return redirect()->route('general-setting-store');
            }
        }
        return view('business.settings.general.store', compact('store', 'business'));
    }

    public function account(AccountSettingRequest $request)
    {
        $business = Business::find(Auth::user()->business_id);
        $bank = Bank::where(['business_id' => Auth::user()->business_id])->first();
        $social = json_decode(\setting('business.social'));
        if ($request->getMethod() === Request::METHOD_PUT) {

            $setting = Setting::whereIn('key',
                ['business.social'])->where(['business_id' => Auth::user()->business_id])->delete();

            $setting = new Setting();
            $setting->business_id = Auth::user()->business_id;
            $setting->key = 'business.social';
            $setting->value = json_encode($request->social);
            $setting->save();
//            flash("Social info updated")->success();

            if (!empty($request->user)) {

                $user = User::find(Auth::user()->id);
                if ($user) {
                    $user->name = $request->user['name'];
                    $user->save();
                }
            }

            $this->businessService->register($request, true, true);

            $bank = \request('bank');
            if (!empty($bank['bank_name']) || !empty($bank['branch']) || !empty($bank['account_title']) || !empty($bank['account_number']) || !empty($bank['iban']) || !empty($bank['swift_code'])) {
                if (!empty($request->bank['bank_id'])) {
                    $bank = Bank::find($request->bank['bank_id']);
                } else {
                    $bank = new Bank();
                }
                $bank->business_id = Auth::user()->business_id;
                $bank->bank_name = $request->bank['bank_name'];
                $bank->branch = $request->bank['branch'];
                $bank->account_title = $request->bank['account_title'];
                $bank->account_number = $request->bank['account_number'];
                $bank->iban = $request->bank['iban'];
                $bank->swift_code = $request->bank['swift_code'];
                $bank->save();
            }
            $flashMessage = 'Account information updated.';

            $object = new \stdClass();
            $object->user = Auth::user()->name;

            Business::find(Auth::user()->business_id)->user->notify(new AccountInfoUpdatedNotify($object));

            event(new AccountInfoUpdatedEvent());

            flash($flashMessage)->success();

            return redirect()->route('general-setting-account');
        }
        return view('business.settings.general.account', compact('business', 'bank', 'social'));
    }

    public function order(Request $request)
    {
        $order = json_decode(\setting('order'));
        $invoice = json_decode(\setting('invoice'));
        $minNumber = Order::whereBusinessId(Auth::user()->business_id)->max('invoice_number');

        $rule = '';
        if (is_null($minNumber)){
            $minNumber = 0;
        }
        if (empty(check_setting('invoice','invoice_start'))){
            $rule = 'min:'.($minNumber+1);
        }

        $request->validate(
            [
                'invoice.invoice_start' => ['nullable', new OnlyNumbers('invoice start'), 'numeric', $rule],
                'invoice.prepend_invoice' => ['nullable','string', 'min:1', 'max:9'],
                'order.prepend_order' => ['nullable','string', 'min:1', 'max:9'],
            ],
            [
                'invoice.invoice_start.min' => 'Invoice start must be greater than '.$minNumber,
                'invoice.prepend_invoice.min' => 'Prepend invoice number max length is 9',
                'invoice.prepend_invoice.max' => 'Prepend invoice number max length is 9',
                'invoice.prepend_order.min' => 'Prepend order number max length is 9',
                'invoice.prepend_order.max' => 'Prepend order number max length is 9',
            ]
        );


        if ($request->getMethod() === Request::METHOD_PUT) {
            $setting = Setting::whereIn('key',
                ['order','invoice'])->where(['business_id' => Auth::user()->business_id])->delete();

            $requestData = $request->all();
            unset($requestData['_token']);
            unset($requestData['_method']);

            foreach ($requestData as $key => $value) {
                $setting = new Setting();
                $setting->business_id = Auth::user()->business_id;
                $setting->key = $key;
                $setting->value = json_encode($value);
                $setting->save();
            }

            flash('Information updated successfully')->success();

            return redirect()->route('general-setting-order');
        }
        return view('business.settings.general.order', compact('order', 'invoice'));
    }

    public function payment(Request $request)
    {
        $bank = Bank::where(['business_id' => Auth::user()->business_id])->first();
        if ($request->getMethod() == Request::METHOD_PUT) {

            flash('Bank added successfully')->success();
            return redirect()->route('general-setting-payment');
        }
        return view('business.settings.general.payment', compact('bank'));
    }

    public function notification(Request $request)
    {
        if ($request->getMethod() == Request::METHOD_PUT) {
            $setting = Setting::whereIn('key',
                ['notification', 'email'])->where(['business_id' => Auth::user()->business_id])->delete();
            $requestData = $request->all();
            unset($requestData['_token']);
            unset($requestData['_method']);
            foreach ($requestData as $key => $value) {
                $setting = new Setting();
                $setting->business_id = Auth::user()->business_id;
                $setting->key = $key;
                $setting->value = json_encode($value);
                $setting->save();
            }
            if (\Arr::has($requestData,'notification')){
                session()->flash('notification', 'Notifications settings updated');
            }

            if (\Arr::has($requestData,'email')){
                session()->flash('email', 'Email setting updated');
            }

            return redirect()->route('general-setting-notification');
        }
        return view('business.settings.general.notification');
    }

    public function checkout(Request $request)
    {
        if ($request->getMethod() == Request::METHOD_PUT) {
            Setting::where('key', 'checkout')->where(['business_id' => Auth::user()->business_id])->delete();
            $requestData = $request->all();
            unset($requestData['_token']);
            unset($requestData['_method']);
            foreach ($requestData as $key => $value) {
                $setting = new Setting();
                $setting->business_id = Auth::user()->business_id;
                $setting->key = $key;
                $setting->value = json_encode($value);
                $setting->save();
            }
            flash('Settings update')->success();
            return redirect()->route('general-setting-checkout');
        }
        return view('business.settings.general.checkout');
    }

    public function fbPixel(Request $request)
    {
        if ($request->getMethod() == Request::METHOD_PUT) {
            Setting::where('key', 'pixel')->where(['business_id' => Auth::user()->business_id])->delete();
            $requestData = $request->all();
            unset($requestData['_token']);
            unset($requestData['_method']);
            foreach ($requestData as $key => $value) {
                $setting = new Setting();
                $setting->business_id = Auth::user()->business_id;
                $setting->key = $key;
                foreach ($value as $subKey => $item){
                    $setting->value = json_encode([$subKey => htmlentities($item)]);
                }
                $setting->save();
            }
            flash('Facebook pixel setting update')->success();
            return redirect()->route('general-setting-fb-pixel');
        }
        return view('business.settings.general.fb-pixel');
    }

    public function password(Request $request)
    {
        $business = Business::find(Auth::user()->business_id);
        if ($request->getMethod() === Request::METHOD_PUT) {

            $request->validate(
                [
                    'old_password' => [
                        'required',
                        'current_password:web'
                    ],
                    'new_password' => [
                        'required',
                        'confirmed',
                        'min:8'
                    ]
                ],
                ['old_password.current_password' => 'Old password does not match to you password']
            );
            $flashMessage = '';

            if (!empty($request->old_password)) {
                if (!\Hash::check($request->old_password, \auth()->user()->password)) {
                    $flashMessage .= 'Old password doesn\'t match';
                    flash($flashMessage)->error();

                    return redirect()->route('general-setting-password');
                }
                if (\Hash::check($request->old_password, \auth()->user()->password)) {
                    $user = User::find(Auth::user()->id);
                    if ($user) {
                        $user->password = \Hash::make($request->new_password);
                        $user->save();
                        Auth::login($user);
                    }
                    $flashMessage .= ' New password updated.';
                }
            }
            flash($flashMessage)->success();

            return redirect()->route('general-setting-password');
        }
        return view('business.settings.general.password', compact('business'));
    }
}
