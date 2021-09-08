<?php

namespace App\Http\Controllers\Admin;

use App\Constants\IStatus;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Customer;
use App\Models\User;
use App\Services\BusinessService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $orderService;
    private $businessService;

    public function __construct(OrderService $orderService, BusinessService $businessService)
    {
        $this->orderService = $orderService;
        $this->businessService = $businessService;
        parent::__construct('customer');
    }

    public function index(Request $request)
    {
        $allCustomersCount = $this->businessService->search(['count' => true]);
        $activeCustomersCount = $this->businessService->search(['count' => true, 'business_status_id' => IStatus::BUSINESS_ACTIVE]);
        $suspendedCustomersCount = $this->businessService->search(['count' => true, 'business_status_id' => IStatus::BUSINESS_SUSPENDED]);

        $ordersCount = $this->orderService->search(['count' => true]);

        $allCustomers = $this->businessService->search($request->all());
        return view("admin.customers.list",
            compact('allCustomers',
                [
                    'allCustomersCount',
                    'activeCustomersCount',
                    'suspendedCustomersCount',
                    'ordersCount'
                ]));
    }

    public function bulkStatus(Request $request)
    {
        $ids = $request->customer_id;
        //return $request->discount_id;
        $customerIds = explode(',',$ids);
        $status = $request->status_id;
        foreach ($customerIds as $id) {
            $Customer = Business::find($id);
            if ($Customer){
                $Customer->business_status_id = $status;
                $Customer->save();
                //updte user status

                if($status == 3){
                    $User = User::where('email','=',$Customer->owner_email)->where('business_id',$Customer->id)->first();
                    //return $User;
                    $User->is_active = 1;
                    $User->update();
                }else{
                    $User = User::where('email','=',$Customer->owner_email)->where('business_id',$Customer->id)->first();
                    $User->is_active = 2;
                    $User->update();

                }
            }
        }
        flash('Customer status successfully updated')->success();
        return redirect()->route('admin-customers-list');
    }
}
