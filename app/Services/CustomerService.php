<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Mail\CustomerRegisterMail;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class CustomerService
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function save($request)
    {
        $customerExistPhone = Customer::wherePhone($request->phone)->whereBusinessId(Auth::user()->business_id)->first();

        if ($customerExistPhone){
            if (!empty($request->customer_id)) {
                $customer = $this->findById($request->customer_id);
                $customer = $this->register($customer, $request);
            }
        }

        if (!$customerExistPhone){
            if (empty($request->customer_id)){

                $customerExistEmail = Customer::whereEmail($request->email)->whereBusinessId(Auth::user()->business_id)->first();
                if ($customerExistEmail){
                    return $customerExistEmail;
                }
                $customer = new Customer();

            }else{
                $customer = $this->findById($request->customer_id);
            }
            $customer = $this->register($customer, $request);
            return $customer;
        }

        if (!empty($customer)) {
            return $customer;
        } else {
            return $customerExistPhone;
        }
    }

    public function findById($id)
    {
        return Customer::find($id);
    }

    public function search($params)
    {
        $customers = Customer::whereNull('deleted_at')->whereBusinessId(\Auth::user()->business_id);

        if (!empty($params['from_date'])){
            $customers = $customers->whereDate('created_at','>=', $params['from_date']);
        }
        if (!empty($params['to_date'])){
            $customers = $customers->whereDate('created_at','<=', $params['to_date']);
        }

        if (!empty($params['count'])){
            return $customers->count('id');
        }

        return $customers->orderBy('id', 'desc')->paginate(AppConstants::PAGINATE_LARGE);
    }

    /**
     * @param $customer Customer
     * @param $request Customer
     * @return mixed
     */
    private function register($customer, $request)
    {
        $customer->business_id      = \Auth::user()->business_id;
        $customer->name             = isset($request->name)         ? $request->name        : $request->first_name;
        $customer->first_name       = isset($request->first_name)   ? $request->first_name  : $request->name;
        $customer->last_name        = isset($request->last_name)    ? $request->last_name   : $request->name;
        $customer->email            = isset($customer->email)       ? $customer->email      : $request->email;
        $customer->phone            = isset($request->phone)        ? $request->phone       : $customer->phone;
        $customer->address          = isset($request->address)      ? $request->address     : $customer->address;
        $customer->mobile           = isset($request->mobile)       ? $request->mobile      : $request->phone;
        $customer->zipcode          = isset($request->zip)          ? $request->zip         : $customer->zip;
        $customer->country_id       = isset($request->country_id)   ? $request->country_id  : Country::whereCode('AE')->first()->id;
        $customer->city_id          = isset($request->state)        ? $request->state       : $customer->state;
        $customer->fixed_discount   = isset($request->discount)     ? $request->discount    : 0;
        $customer->notes            = isset($request->notes)        ? $request->notes       : $customer->notes;
        $customer->save();


        if (empty($request->customer_id)){
            $customerEmail = new CustomerRegisterMail($customer);
            \Mail::send($customerEmail);
        }

        if (!empty($request->images)){
            if (!empty($request->customer_id)){
                Image::where(['imageable_type' => Customer::class, 'imageable_id' => $customer->id])->delete();
                $this->imageService->saveImage($request, $customer->id, Customer::class, 'customers');
            }else{
                $this->imageService->save($request, $customer->id, Customer::class, 'customers');
            }
        }
        return $customer;
    }
}
