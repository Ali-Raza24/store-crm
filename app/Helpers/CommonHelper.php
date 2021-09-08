<?php

namespace App\Helpers;

use App\Constants\AramexConstants;
use App\Constants\IStatus;
use App\Models\Addon;
use App\Models\Brand;
use App\Models\Business;
use App\Models\Category;
use App\Models\Country;
use App\Models\FulfillmentStatus;
use App\Models\Image;
use App\Models\Industry;
use App\Models\PaymentStatus;
use App\Models\Plan;
use App\Models\State;
use App\Models\Status;
use App\Models\Store;
use App\Models\User;
use App\Models\Variant;
use App\Models\VariantOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CommonHelper
{
    public static function isBusinessAdmin()
    {
        $user = Auth::user()->email;
        $business = Auth::user()->business->owner_email;

        if ($user === $business) {
            return true;
        }
        return false;
    }

    public static function generateBusinessCode($id): string
    {
        return "BUS#" . str_pad($id, 6, "0", STR_PAD_LEFT);
    }

    public static function stores($dropdown = false)
    {
        $stores =  Store::selectRaw('if(is_active=2,CONCAT(name," (","inactive",")"), name) as name, slug, is_active, id')
            ->whereBusinessId(Auth::user()->business_id)
            ->whereNull('deleted_at');
        if ($dropdown){
            return $stores->pluck('name', 'id');
        }
        return $stores->get(['name', 'slug', 'is_active', 'id']);
    }

    public static function businessStatus()
    {
        return Status::whereIsActive(IStatus::ACTIVE)
            ->where('title', '!=', "Pending")
            ->where(['type' => Business::class])
            ->get()->pluck('title', 'id');
    }

    public static function industries()
    {
        return Industry::all()->pluck('title', 'id');
    }

    public static function plans()
    {
        $plans = Plan::whereNull('deleted_at')->get()->pluck('title','id');

        $list = [];
        foreach ($plans as $key => $plan){
            $list[$key] = $plan;
        }

        return $list;
    }

    public static function countries()
    {
        $countries = Country::whereIsActive(IStatus::ACTIVE)->whereCode('AE')->get()->pluck('name', 'id');
        $list = ['--Please Select--'];
        foreach ($countries as $key => $country){
            $list[$key] = $country;
        }
        return $list;
    }

    public static function states()
    {
        $states = State::whereNull('deleted_at')
            ->whereIsActive(IStatus::ACTIVE)
            ->whereCountryCode('AE')
            ->get()->pluck('name', 'id');
        $list = ['--Please Select--'];
        foreach ($states as $key => $state){
            $list[$key] = $state;
        }
        return $list;
    }

    public static function banksList()
    {
        return [
            '' => 'Select Bank',
            'FAB' => 'First Abu Dhabi Bank',
            'ADCB' => 'Abu Dhabi Commercial Bank',
            'CITIBANK' => 'CITI BANK',
            'HSBC' => 'HSBC Bank Middle East Limited',
            'ADIB' => 'Abu Dhabi Islamic Bank',
            'ABK' => 'Al Ahli Bank of Kuwait',
            'AHB' => 'Al Hilal Bank',
            'AKF' => 'Al Khaliji France',
            'ABN' => 'ABN Amro Bank N.V',
            'ABIFT' => 'Arab Bank for Investment & Foreign Trade',
            'AAIB' => 'Arab African International Bank',
            'ABP' => 'Arab Bank PLC (Dubai)',
            'BB' => 'Bank of Baroda',
            'BDC' => 'Banque Du Caire',
            'BMI' => 'Bank Melli Iran',
            'BSI' => 'Bank Saderat Iran',
            'BOS' => 'Bank of Sharjah',
            'BBPLC' => 'Barclays Bank PLC',
            'BBF' => 'Blom Bank France',
            'BNPP' => 'BNP Paribas',
            'CBI' => 'Commercial Bank International',
            'CBD' => 'Commercial Bank of Dubai',
            'DohaBank' => 'Doha Bank',
            'DubaiBank' => 'Dubai Bank',
            'DIB' => 'Dubai Islamic Bank',
            'EIB' => 'Emirates Investment Bank',
            'EISLB' => 'Emirates Islamic bank',
            'ENBD' => 'Emirates NBD Bank',
            'FGB' => 'First Gulf Bank',
            'HBZ' => 'Habib Bank AG Zurich',
            'ICICI' => 'ICICI Bank Ltd',
            'Investbank' => 'Invest bank',
            'AMB' => 'Mashreq Bank',
            'NBAD' => 'National Bank of Abu Dhabi',
            'NBB' => 'National Bank of Bahrain',
            'NBF' => 'National Bank of Fujairah',
            'NBO' => 'National Bank of Oman',
            'NBUAQ' => 'National Bank of Umm Al-Qaiwain',
            'NB' => 'Noor Bank',
            'RAKBANK' => 'National Bank of Ras Al Khaimah',
            'scotiabank' => 'Scotiabank',
            'SCB' => 'Standard Chartered',
            'SIB' => 'Sharjah Islamic Bank',
            'UBS' => 'UBS Group',
            'UBP' => 'Union Bancaire Privée',
            'UNB' => 'Union National Bank',
            'UAB' => 'United Arab Bank'
        ];
    }

    public static function getStatus($id)
    {
        $status = Status::find($id);
        if ($status){
            return $status->title;
        }else{
            return 'Pending';
        }
    }

    public static function brands()
    {
        $brands = Brand::activeBusiness()->pluck('title', 'id');
        $options = ['0' => 'Select Brand'];
        foreach ($brands as $key => $brand){
            $options[$key] = $brand;
        }
        return $options;
    }

    public static function categories()
    {
        $categories = Category::activeBusiness()->pluck('title', 'id');

        return $categories;
    }

    public static function addons()
    {
        $brands = Addon::activeBusiness()->pluck('title', 'id');
        if (count($brands) > 0) {
            return $brands->toArray();
        } else {
            return [];
        }
    }

    public static function variants()
    {
        $variants = Variant::/*where(function ($q) {
            $q->whereNull('business_id')
                ->orWhere('business_id','=','0')
                ->orWhere(['business_id' => Auth::user()->business_id]);
        })->*/get()->toArray();
        $i = 0;
        foreach ($variants as $variant) {
            $options = VariantOptions::select([
                'option as text',
                'id'
            ])->whereVariantId($variant['id'])->get(['text', 'id']);
            if (count($options) > 0) {
                foreach ($options as $option) {
                    $variants[$i]['options'][] = ['id' => $option['text'], 'text' => $option['text']];
                }
            }else{
                $variants[$i]['options'] = [];
            }
            $i++;
        }

        return $variants;
    }

    public static function sendMessageToNumber($number, $messageContent)
    {
        $user="oogo"; //your username
        $password="34127626"; //your password
        $mobilenumbers=$number; //enter Mobile numbers comma seperated
        //$mobilenumbers="00971562025438"; //enter Mobile numbers comma seperated
        $message = $messageContent; //enter Your Message
        $senderid="SMSCntry"; //Your senderid
        $messagetype="N"; //Type Of Your Message
        $DReports="Y"; //Delivery Reports
        //$url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
        $url ="http://api.smscountry.com/SMSCwebservice_bulk.aspx?";
        $message = urlencode($message);

        $postParam = "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports";
        $postRequest = Http::post($url.$postParam,[]);

        if($postRequest->ok()){
            return true;
        } else {
            return false;
        }

    }

    public static function getAddons($addon_ids)
    {
        return optional(Addon::whereIn('id',$addon_ids)->get())->toArray();
    }

    public static function paymentStatus()
    {
        return PaymentStatus::all()->pluck('title','id');
    }

    public static function paymentStatusColor($status_id)
    {
        $color = '';
        switch ($status_id){
            case IStatus::PAYMENT_PAID:
                $color = '';
                break;
            case IStatus::PAYMENT_PENDING:
                $color = 'toggle-warning bg-pending text-white';
                break;
            case IStatus::PAYMENT_REFUNDED:
                $color = '';
                break;
            default:
                break;
        }
        return $color;
    }

    public static function fulfilmentStatus()
    {
        return FulfillmentStatus::all()->pluck('title','id');
    }

    public static function orderStatus($forList = true)
    {
        if ($forList) {
            return Status::whereIn('type', [FulfillmentStatus::class])->where('title','!=','returned')->where('sort','>','0')->orderBy('sort')->get()->pluck('title','id');
        }
        return Status::whereIn('type', [FulfillmentStatus::class, PaymentStatus::class])->where('title','!=','returned')->where('sort','>','0')->orderBy('sort')->get()->pluck('title','id');
    }

    public static function userLogo($type = null)
    {
        if (empty(Auth::user()->business_id) && empty($type)) {
            $image = Image::where([
                'imageable_id' => Auth::user()->id,
                'imageable_type' => User::class
            ])->latest()->first();
        }else {
            if ($type == 'user'){
                $image = Image::where([
                    'imageable_id' => Auth::user()->id,
                    'imageable_type' => User::class,
                    'key' => 'user'
                ])->latest()->first();
            }else{
                $image = Image::where([
                    'imageable_id' => Auth::user()->business_id,
                    'imageable_type' => Business::class,
                    'key' => $type
                ])->latest()->first();
            }
        }
        if ($image) {
            return $image->url;
        }
        return '';
    }

    public static function planOptions()
    {
        return [
            'website'                       =>  ['title' => 'Website',                          'type' => 'radio'],
            'payments'                      =>  ['title' => 'Payments',                         'type' => 'checkbox'],
            'commission_online'             =>  ['title' => 'Commission from online sale',      'type' => 'number'],
//            'commission_all_sale'           =>  ['title' => 'Commission Percent from all sale', 'type' => 'number'],
            'order_type'                    =>  ['title' => 'Order Type',                       'type' => 'checkbox'],
            'analytics'                     =>  ['title' => 'Analytics',                        'type' => 'radio'],
            'staff'                         =>  ['title' => 'Staff Accounts',                   'type' => 'number'],
            'stores'                        =>  ['title' => 'Stores',                           'type' => 'number'],
            'products'                      =>  ['title' => 'Products',                         'type' => 'number'],
            'unlimited_products'            =>  ['title' => 'Unlimited Products',               'type' => 'radio'],
//            'domain_link'                   =>  ['title' => 'Domain Link',                      'type' => 'radio'],
            'mobile_app'                    =>  ['title' => 'Mobile App',                       'type' => 'radio'],
            'free_days'                     =>  ['title' => 'Free Days',                        'type' => 'number'],
//            'includes_plan'                 =>  ['title' => 'Includes Plan',                    'type' => 'checkbox'],
            'coupon_code'                   =>  ['title' => 'Coupon code',                      'type' => 'radio'],
            'change_payment_method'         =>  ['title' => 'Change payment method',            'type' => 'radio'],
            'delivery_service_integration'  =>  ['title' => 'Delivery service integration',     'type' => 'radio'],
            'raise_invoice'                 =>  ['title' => 'Raise Invoice',                    'type' => 'radio'],
            'customer_listing'              =>  ['title' => 'Customer Listing',                 'type' => 'radio'],
            'custom_email_template'         =>  ['title' => 'Custom Email Template',            'type' => 'radio'],
            'sms_manager'                   =>  ['title' => 'SMS Manager',                      'type' => 'radio']
        ];
    }

    public static function planOptionsValeus()
    {
        $plans = Plan::whereNull('deleted_at')->get()->pluck('title', 'id');
        $newPlans = [];
        foreach ($plans as $key => $plan){
            $newPlans[$key] = $plan;
        }
        return [
            'website'                       => ['yes-web' => 'Yes', 'no-web' => 'No'],
            'payments'                      => ['online-payments' => 'Online Payments', 'cash-on-delivery' => 'Cash On Delivery'],
            'commission_type'               => ['all-sales' => 'All Sales', 'online-sales' => 'Online Sales'],
            'order_type'                    => ['dine-in' => 'Dine-in', 'pick-up' => 'Pick-up', 'delivery' => 'Delivery'],
            'analytics'                     => ['basic' => 'Basic', 'advance' => 'Advance', 'super-advance' => 'Super Advance'],
            'unlimited_products'            => ['yes-unlimited' => 'Yes',    'no-unlimited' => 'No'],
            'domain_link'                   => ['yes-domain' => 'Yes',       'no-domain' => 'No'],
            'mobile_app'                    => ['yes-app' => 'Yes',          'no-app' => 'No'],
//            'includes_plan'                 => $newPlans,
            'coupon_code'                   => ['yes-coupon' => 'Yes',       'no-coupon' => 'No'],
            'delivery_service_integration'  => ['yes-delivery' => 'Yes',     'no-delivery' => 'No'],
            'raise_invoice'                 => ['yes-invoice' => 'Yes',      'no-invoice' => 'No'],
            'customer_listing'              => ['yes-customer' => 'Yes',     'no-customer' => 'No'],
            'custom_email_template'         => ['yes-email-temp' => 'Yes',   'no-email-temp' => 'No'],
            'sms_manager'                   => ['yes-sms' => 'Yes',          'no-sms' => 'No'],
            'change_payment_method'         => ['yes-can-change' => 'Yes',   'no-cant-change' => 'No']
        ];
    }

    public static function planOptionsText()
    {
        $arr = [
            'yes-web'                       =>  'Website',
            'no-web'                        =>  'No Website',
            'payments'                      =>  'Online Payment & Cash on Delivery',
            'online-payments'               =>  'Online Payments',
            'cash-on-delivery'              =>  'Cash On Delivery',
            'commission_all_sale'           =>  '% from sales',
            'commission_online'             =>  '% Bank Charges (for online sales only)',
            'commission_percent'            =>  '% Commission',
            'order_type'                    =>  'Order Type',
            'dine-in'                       =>  'Dine-in',
            'pick-up'                       =>  'Pick-up',
            'delivery'                      =>  'Delivery Option',
            'analytics'                     =>  'Analytics',
            'basic'                         =>  'Basic Analytics',
            'advance'                       =>  'Advance Analytics',
            'super-advance'                 =>  'Super Advance Analytics',
            'staff'                         =>  'Staff Account',
            'stores'                        =>  'Stores Location',
            'products'                      =>  'Products Listed',
            'no-unlimited'                  =>  'No Unlimited Products',
            'yes-unlimited'                 =>  'Unlimited Products',
            'yes-domain'                    =>  'Domain Link',
            'no-domain'                     =>  'No Domain Link',
            'yes-app'                       =>  'IOS/ Android App to Manage Orders',
            'no-app'                        =>  'No IOS/ Android App to Manage Orders',
            'free_days'                     =>  'Free Days',
            'includes_plan'                 =>  'plan features included',
            'yes-coupon'                    =>  'Coupon codes',
            'no-coupon'                     =>  'No coupon codes',
            'yes-delivery'                  =>  'Delivery service integration',
            'no-delivery'                   =>  'No Delivery service integration',
            'yes-invoice'                   =>  'Raise Invoice',
            'no-invoice'                    =>  'No raise Invoice',
            'yes-customer'                  =>  'Customer Listing',
            'no-customer'                   =>  'No customer Listing',
            'yes-email-temp'                =>  'Custom Email Template',
            'no-email-temp'                 =>  'No Custom Email Template',
            'yes-sms'                       =>  'SMS Manager',
            'no-sms'                        =>  'No SMS Manager',
            'yes-can-change'                =>  'Ability Change payment method online or Cash on Delivery',
            'no-cant-change'                =>  'Cannot Change payment method online or Cash on Delivery',
        ];
        /*$plans = Plan::whereNull('deleted_at')->get()->pluck('title', 'id')->toArray();

        foreach ($plans as $key => $value){
            $arr = $arr + [$key => $value];
        }*/
        return $arr;
    }

    public static function getImage($image_id, $image_type, $key = null)
    {
        $image = Image::where(['imageable_id' => $image_id, 'imageable_type' => $image_type]);
        if ($key){
            $image = $image->where(['key' => $key]);
        }
        $image = $image->lastest()->first();
        if ($image){
            return $image->url;
        }
        return asset('img/camera_icon.png');
    }

    public static function aramexProductTypes()
    {
        return [
            AramexConstants::PRODUCT_TYPE_OND => 'OND - Only for Product Group DOM',
            AramexConstants::PRODUCT_TYPE_PDX => 'PDX - Priority Document Express',
            AramexConstants::PRODUCT_TYPE_PPX => 'PPX - Priority Parcel Express',
            AramexConstants::PRODUCT_TYPE_PLX => 'PLX - Priority Letter Express',
            AramexConstants::PRODUCT_TYPE_DDX => 'DDX - Deferred Document Express',
            AramexConstants::PRODUCT_TYPE_DPX => 'DPX - Deferred Parcel Express',
            AramexConstants::PRODUCT_TYPE_GDX => 'GDX - Ground Document Express',
            AramexConstants::PRODUCT_TYPE_GPX => 'GPX - Ground Parcel Express',
            AramexConstants::PRODUCT_TYPE_EPX => 'EPX - Economy Parcel Express',
        ];
    }

    public static function aramexPaymentTypes()
    {
        return [
            AramexConstants::PAYMENT_PREPAID => 'P - Prepaid',
            AramexConstants::PAYMENT_COD => 'C - Collect',
            AramexConstants::PAYMENT_THIRD_PARTY => 'Third Party',
        ];
    }

    public static function aramexProductGroups()
    {
        return [
            AramexConstants::PRODUCT_GROUP_DOM => 'DOM - Domestic',
            AramexConstants::PRODUCT_GROUP_EXP => 'EXP - Express',
        ];
    }
}
