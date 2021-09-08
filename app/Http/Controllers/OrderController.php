<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Events\InvoiceGenerated as InvoiceGeneratedEvent;
use App\Exports\OrderExport;
use App\Mail\InvoiceGeneratedMail;
use App\Models\Business;
use App\Models\DeliveryCompanyResponses;
use App\Models\OrderHistory;
use App\Notifications\InvoiceGenerated as InvoiceGeneratedNotify;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Excel;

class OrderController extends Controller
{
    private $orderService;
    private $productService;

    public function __construct(OrderService $orderService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
        parent::__construct('order');
    }
    public function index(Request $request)
    {
        $allOrders = $this->orderService->search(['count' => true]);
        $unpaidOrders = $this->orderService->search(['count' => true, 'payment_status' => [IStatus::PAYMENT_PENDING]]);
        $unfulfilledOrders = $this->orderService->search(['count' => true, 'fulfilment_status' => [IStatus::PROCESSING]]);
        $outForDelivery = $this->orderService->search(['count' => true, 'fulfilment_status' => [IStatus::OUT_FOR_DELIVERY]]);

        $orders = $this->orderService->search(array_merge($request->all()));

        return view("business.orders.list", compact('orders','allOrders', 'unfulfilledOrders', 'unpaidOrders', 'outForDelivery'));
    }

    public function status(Request $request, $type)
    {
        $order = $this->orderService->findById($request->order_id);
        if ($order) {
            $message = $this->orderService->status($request, $type, $request->order_id);
            flash($message)->success();
        }

        if ($request->status_id == IStatus::PAYMENT_REFUNDED && $type == 'payment'){
            return \redirect()->route('orders-refund',['id' => $request->order_id]);
        }

        return \redirect()->back();
    }

    public function bulkStatus(Request $request, $type)
    {
        $ids = $request->order_id;
        $orderIds = explode(',',$ids);
        foreach ($orderIds as $id) {
            $order = $this->orderService->findById($id);
            if ($order) {
                $message = $this->orderService->status($request, $type, $id);
                flash($message)->success();
            }
        }
        return \redirect()->back();
    }

    public function add()
    {
        return view("business.orders.add");
    }

    public function detail(Request $request, $id)
    {
        $order = Order::whereBusinessId(Auth::user()->business_id)->whereFormattedNumber($id)->first();
        if (! $order) {
            $order = Order::whereBusinessId(Auth::user()->business_id)->whereId($id)->firstOrFail();
        }
        return view("business.orders.detail", compact('order'));
    }

    public function edit(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $allProducts = $this->productService->search($request);
        return view("business.orders.edit", compact('order', 'allProducts'));
    }
    public function update(Request $request, $id)
    {
        $this->orderService->save($request);
        flash('Order Updated successfully.')->success();
        return Redirect::back();
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        return view("business.orders.cancel-order", compact('order'));
    }

    public function refund(Request $request, $id)
    {
        $order = $this->orderService->findById($id);
        return view("business.orders.refund", compact('order'));
    }

    public function invoice(Request $request, $id)
    {
        $order = Order::find($id);

        $minInvoiceNumber = Order::whereBusinessId(Auth::user()->business_id)->max('invoice_number');

        if (is_null($minInvoiceNumber)) {
            $minInvoiceNumber = 0;
        }

        $settingMinInvoiceNumber = check_setting('invoice','invoice_start');

        if (!empty($settingMinInvoiceNumber) && $settingMinInvoiceNumber > $minInvoiceNumber){
            $minInvoiceNumber = $settingMinInvoiceNumber;
        }
        $prependInvoice = check_setting('order','prepend_invoice');
        if ($order && empty($order->invoice_number)){
            $newINvNumber = ++$minInvoiceNumber;
            $order->invoice_number = $newINvNumber;
            $order->formatted_inv_number = $prependInvoice.$newINvNumber;
            $order->save();

            $object = new \stdClass();
            $object->user = Auth::user()->name;
            $object->order_number = $order->formatted_number;
            $object->order_id = $order->id;

            Business::find(Auth::user()->business_id)->user->notify(new InvoiceGeneratedNotify($object));

            event(new InvoiceGeneratedEvent());

            $invoiceGenerated = new InvoiceGeneratedMail($order);
            \Mail::to($order->customer->email)->send($invoiceGenerated);
        }
        if (empty($order->invoice_number)){
            flash("Invoice not generated for this order. please generate invoice first")->error();
            return redirect()->back();
        }
        return view("business.orders.invoice", compact('order'));
    }

    public function comment(Request $request, $id)
    {
        $order = OrderHistory::whereOrderId($id)->orderBy('id','desc')->first();
        if (! $order){
            $order = Order::find($id);
        }

        $orderHistory = new OrderHistory();
        $orderHistory->order_id = $id;
        $orderHistory->status_id = isset($order->status_id) ? $order->status_id : $order->order_status_id;
        $orderHistory->type_id = isset($order->type_id) ? $order->type_id : AppConstants::ORDER_STATUS_TYPE_ORDER;
        $orderHistory->is_comment = 1;
        $orderHistory->comment = $request->comment;
        $orderHistory->user_id = Auth::user()->id;
        $orderHistory->save();
        return \redirect()->back();
    }

    public function export(Excel $excel, OrderExport $orderExport)
    {
        $filename = 'orders_'.date('YmdHis').'.csv';
        $excel->store($orderExport, $filename, 'public');
        return \redirect(asset('storage/'.$filename));
    }

    public function generateInvoice(Request $request)
    {
        if (empty($request->invoice_number)){
            flash('Invoice Number is required')->error();
            return \redirect()->back();
        }
        $order_id = $request->order_number;

        $order = Order::find($order_id);

        if ($order){
            $order->invoice_number = $request->invoice_number;
            $order->save();
        }else{
            flash('Error in generating invoice')->error();
            return \redirect()->back();
        }

        return \redirect()->route('orders-invoice', $order_id);
    }

    public function createShipment($id)
    {
        $order = $this->orderService->findById($id);

        $message = 'Please add store '.strtoupper($order->store->name).' ';
        $errors = '';
        $errorCount = 0;
        if (empty($order->store->address_1)){
            $errors .= ' address ';
            $errorCount +=1;
        }

        if (empty($order->store->state_id)){
            if ($errorCount > 0) {
                $errors .= ',';
            }
            $errors .=' state ';
            $errorCount +=1;
        }

        if (empty($order->store->phone)){
            if ($errorCount > 0) {
                $errors .= ',';
            }
            $errors .= ' phone number ';
            $errorCount +=1;
        }
        if (empty($order->store->mobile)){
            if ($errorCount > 0) {
                $errors .= ',';
            }
            $errors .= 'mobile number ';
            $errorCount +=1;
        }

        if (empty($order->store->email)){
            if ($errorCount > 0) {
                $errors .= ',';
            }
            $errors .= ' email ';
            $errorCount +=1;
        }

        if ($errorCount > 0){
            flash($message. $errors .'to create Aramex shipping')->error()->important();
            return \redirect()->back();
        }

        if ($order){
            $shipment = $this->orderService->createAramexShipping($id);
            if ($shipment->isSuccessful()){
                flash('Shipment created successfully')->success();
                return \redirect()->route('orders-detail',$id);
            } else {
                $message = \Arr::first($shipment->getMessages());
                flash('Error in creating shipment. '.$message)->error();
                return \redirect()->route('orders-detail',$id);
            }
        }
        flash('Error! order not found')->error();
        return \redirect()->route('orders-detail',$id);
    }

    public function createPickup($id)
    {
        $order = $this->orderService->findById($id);

        $message = 'Please add store '.strtoupper($order->store->name).' ';
        $errors = '';
        $errorCount = 0;
        if (empty($order->store->address_1)){
            $errors .= ' address ';
            $errorCount +=1;
        }

        if (empty($order->store->state_id)){
            if ($errorCount > 0) {
                $errors .= ',';
            }
            $errors .=' state ';
            $errorCount +=1;
        }

        if (empty($order->store->phone)){
            if ($errorCount > 0) {
                $errors .= ',';
            }
            $errors .= ' phone number ';
            $errorCount +=1;
        }
        if (empty($order->store->mobile)){
            if ($errorCount > 0) {
                $errors .= ',';
            }
            $errors .= 'mobile number ';
            $errorCount +=1;
        }

        if (empty($order->store->email)){
            if ($errorCount > 0) {
                $errors .= ',';
            }
            $errors .= ' email ';
            $errorCount +=1;
        }

        if ($errorCount > 0){
            flash($message. $errors .'to create Aramex shipping')->error()->important();
            return \redirect()->back();
        }


        if ($order){
            $shipment = $this->orderService->createAramexPickup($id);
            if ($shipment->isSuccessful()){
                flash('Pickup created successfully')->success();
                return \redirect()->route('orders-detail',$id);
            } else {
                $message = \Arr::first($shipment->getMessages());

                if (\Str::contains($message,'Time should be greater')){
                    $message .= ' Please update your store closing and opening time';
                }

                flash('Error in creating pickup. '.$message)->error();
                return \redirect()->route('orders-detail',$id);
            }
        }
        flash('Error! order not found')->error();
        return \redirect()->route('orders-detail',$id);
    }

    public function trackShipment($id)
    {
        $response = $this->orderService->trackShipment($id);
        if ($response->isSuccessful()) {
            return view('');
        }
        flash('Error in tracking shipment')->error();
        return \redirect()->back();
    }

    public function labelPrint($id)
    {
        $orderDeliveryResponse = DeliveryCompanyResponses::whereTrackingId($id)->whereType(AppConstants::ARAMEX_SHIPPING)->first();
        $response = $this->orderService->labelPrint($id);
        if ($response->isSuccessful()){
            flash('Label Printed successfully')->success();
            return \redirect()->route('orders-detail',$orderDeliveryResponse->order_id);
        }
        flash('Error in printing label')->error();
        return \redirect()->route('orders-detail',$orderDeliveryResponse->order_id);
    }
}
