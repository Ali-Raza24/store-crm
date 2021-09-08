<?php

namespace App\Http\Controllers;

use App\Constants\IStatus;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\CustomerRequest;
use App\Services\CustomerService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends ApiBaseController
{
    private $customerService;

    private $orderService;

    public function __construct(CustomerService $customerService, OrderService $orderService)
    {
        $this->customerService = $customerService;
        $this->orderService = $orderService;
//        parent::__construct('customer');
        $this->middleware('permission:customer-list');
        $this->middleware('permission:customer-edit')->only(['edit','store','create','update']);
        $this->middleware('permission:customer-delete')->only(['destroy']);
        $this->middleware('permission:customer-status')->only(['status']);
        $this->middleware('permission:customer-bulk-status')->only(['statusBulk']);
        $this->middleware('permission:customer-bulk-delete')->only(['destroyBulk']);
    }

    public function index(Request $request)
    {
        $customers = $this->customerService->search($request->toArray());

        $totalCustomers = $this->customerService->search(['count' => true]);
        $totalOrders = $this->orderService->search(['count' => true]);
        $totalSpent = $this->orderService->search(['sum' => true, 'sum_field' => 'total']);

        return view("business.customers.list", compact('customers', 'totalCustomers', 'totalOrders', 'totalSpent'));
    }

    public function store(CustomerRequest $request)
    {
        $customer = $this->customerService->save($request);
        if (!\request()->ajax()) {
            flash('Customer updated successfully')->success();
            return redirect()->route('customers-edit',['id' => $customer->id]);
        }
        return $this->sendSuccess('Customer created successfully', $customer);
    }
    public function edit(Request $request, $id)
    {
        $customer = $this->customerService->findById($id);
        $orders = $this->orderService->search(['customer_id' => $id]);
        return view("business.customers.edit", compact('customer', 'orders'));
    }

    public function detail(Request $request, $id)
    {
        $customer = $this->customerService->findById($id);
        $orders = $this->orderService->search(['customer_id' => $id]);
        return view("business.customers.detail", compact('customer', 'orders'));
    }

    public function destroy(Request $request)
    {
        $id = $request->customer_id;

        $customer = $this->customerService->findById($id);
        if ($customer){
            $customer->deleted_at = Carbon::now();
            $customer->save();
            flash('Customer deleted successfully')->success();
            return redirect()->route('customers-list');
        }
        flash('No record found')->error();
        return redirect()->route('customers-list');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->customer_id;

        $ids = explode(',',$ids);

        foreach ($ids as $id) {
            $customer = $this->customerService->findById($id);
            if ($customer) {
                $customer->deleted_at = Carbon::now();
                $customer->save();
            }
        }
        flash('Customers deleted successfully')->success();
        return redirect()->route('customers-list');
    }

    public function status(Request $request)
    {
        $id = $request->customer_id;
        $status = $request->status_id;

        $customer = $this->customerService->findById($id);
        if ($customer){
            $customer->is_active = $status;
            $customer->save();

            if ($status == IStatus::ACTIVE){
                flash('Customer activated successfully')->success();
            } else {
                flash('Customer inactivated successfully')->success();
            }
            return redirect()->route('customers-list');
        }
        flash('No record found')->error();
        return redirect()->route('customers-list');
    }

    public function statusBulk(Request $request)
    {
        $ids = $request->customer_id;

        $ids = explode(',',$ids);
        $status = $request->status_id;
        foreach ($ids as $id) {
            $customer = $this->customerService->findById($id);
            if ($customer){
                $customer->is_active = $status;
                $customer->save();
            }
        }
        if ($status == IStatus::ACTIVE){
            flash('Customer activated successfully')->success();
        } else {
            flash('Customer inactivated successfully')->success();
        }
        return redirect()->route('customers-list');
    }
}
