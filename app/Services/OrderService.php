<?php

namespace App\Services;

use App\Models\PaymentStatus;
use App\Models\Product;
use App\Constants\{AppConstants, AramexConstants, IStatus};
use ExtremeSa\Aramex\API\Classes\Address;
use ExtremeSa\Aramex\API\Classes\Contact;
use ExtremeSa\Aramex\API\Classes\LabelInfo;
use ExtremeSa\Aramex\API\Classes\Party;
use ExtremeSa\Aramex\API\Classes\Pickup;
use ExtremeSa\Aramex\API\Classes\PickupItem;
use ExtremeSa\Aramex\API\Classes\Shipment;
use ExtremeSa\Aramex\API\Classes\ShipmentDetails;
use ExtremeSa\Aramex\API\Classes\Weight;
use ExtremeSa\Aramex\API\Response\Shipping\PickupCreationResponse;
use ExtremeSa\Aramex\API\Response\Shipping\ShipmentCreationResponse;
use ExtremeSa\Aramex\Aramex;
use App\Events\OrderCancel as OrderCancelEvent;
use App\Events\OrderDelivered as OrderDeliveredEvent;
use App\Events\OrderPlaced;
use App\Events\PaymentRefund as PaymentRefundEvent;
use App\Helpers\CommonHelper;
use App\Mail\Business\NewOrderMail;
use App\Mail\OrderCancelConfirmationMail;
use App\Mail\OrderRefundMail;
use App\Mail\TrackOrderMail;
use App\Models\Business;
use App\Models\DeliveryCompanyResponses;
use App\Models\Discount;
use App\Models\DiscountLogs;
use App\Models\DiscountProduct;
use App\Models\FulfillmentStatus;
use App\Models\Order;
use App\Models\OrderAddons;
use App\Models\OrderAddresses;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use App\Models\Payment;
use App\Models\Status;
use App\Notifications\{OrderCancel, OrderDelivered, PaymentRefund};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    //
    public function save($request)
    {
        $prependOrder = check_setting('invoice','prepend_invoice');
        $startFrom = check_setting('invoice','invoice_start');

        $orderNumberMax = Order::selectRaw('max(CAST(order_number AS UNSIGNED)) as max_number')->whereBusinessId(Auth::user()->business_id)->first();

        $orderNumberMax = $orderNumberMax->max_number;
        if (is_null($orderNumberMax)){
            $orderNumberMax = 0;
        }

        if ($orderNumberMax < $startFrom){
            $orderNumberMax = $startFrom;
        }

        $orderNumberMax +=1;

        /**
         * @var $discount Discount
         */

        $discount = [];
        if (!empty($request->discount_code)) {
            $discount = Discount::whereCode($request->discount_code)->first();
        }

        if (!empty($request->order_id)){
            $order = $this->findById($request->order_id);
//            $request = json_decode(json_encode($request->all()));
        } else {
            $order = new Order();
        }
        $order->business_id = \Auth::user()->business_id;

        $order->customer_id = isset($request->customer_id) ? $request->customer_id : 0;

        $order->order_number = !empty($order->order_number) ? $order->order_number : $orderNumberMax;

        $order->formatted_number = !empty($order->formatted_number) ? $order->formatted_number : $prependOrder.$orderNumberMax;

        if (!empty($request->store_id)) {
            $order->store_id = $request->store_id;
        }
        if (!empty($request->subtotal)) {
            $order->subtotal = $request->subtotal;
        }
        /*if (!empty($request->discount_code)) {
            $order->discount_code = $request->discount_code;
            if (!empty($discount->discount_type_id)) {
                $order->discount_type = $discount->discount_type_id;
            }
            if (!empty($discount->discount_value)) {
                $order->discount_value = $discount->discount_value;
            }
            $order->discount = $request->discount;
        }*/

        $order->tax = isset($request->tax) ? $request->tax : 0;

        if (!empty($request->total)) {
            $order->total = $request->total;
        }
        if (!empty($request->refunded_amount)) {
            $order->refunded_amount = $request->refunded_amount;
        }
        if (!empty($request->refund_reason)) {
            $order->refund_reason = $request->refund_reason;
        }
        if (!empty($request->delivery_charges)) {
            $order->delivery_charges = $request->delivery_charges;
        }
        if ($request->has('delivery_company_id')) {
            $order->delivery_company_id = $request->delivery_company_id;
        }

        if ($request->has('delivery_type')) {
            $order->delivery_type = $request->delivery_type;
        }

        if (!empty($request->is_gift)) {
            $order->is_gift = $request->is_gift;
        }
        if ($request->customer_notes) {
            $order->customer_notes = $request->customer_notes;
        }

        $payment = $request->payment;
        if(isset($payment)) {
            $order->payment_type_id = $payment['type'];

            $order->payment_method_id = $payment['payment_method_id'];
        }

        $order->payment_status_id = isset($request->payment_status_id) ? $request->payment_status_id : IStatus::PAYMENT_PENDING;

        $order->fulfilment_status_id = isset($request->fulfilment_status_id) ? $request->fulfilment_status_id : IStatus::ORDER_PLACED;

        $order->order_status_id = isset($request->order_status_id) ? $request->order_status_id : IStatus::ORDER_PLACED;

        $order->save();

        $this->orderHistoryOnCreate($order->id, $order->fulfilment_status_id, AppConstants::ORDER_STATUS_TYPE_FULFILMENT);
        $this->orderHistoryOnCreate($order->id ,$order->payment_status_id, AppConstants::ORDER_STATUS_TYPE_PAYMENT);

        $this->orderDetails($request, $order->id);

        $this->orderAddresses($request, $order->id);

        if (!empty($payment['type']) && $payment['type'] == AppConstants::PAYMENT_CCAVENUE){
            $this->payment($request, $order->id);
        }

        if (empty($request->order_id)){
            $order = Order::find($order->id);
            if (!empty(optional($order->customer)->email)) {
                $orderMail = new TrackOrderMail($order);
                \Mail::to($order->customer->email)->send($orderMail);
            }

            if (!empty($order->business->email)){
                $newOrderMail = new NewOrderMail($order);
                \Mail::to($order->business->email)->send($newOrderMail);
            }

            $object = new \stdClass();
            $object->user = $order->customer->name;
            $object->order_number = $order->formatted_number;
            $object->order_id = $order->id;

            Business::find(Auth::user()->business_id)->user->notify(new \App\Notifications\OrderPlaced($object));

            event(new OrderPlaced());
        }

        return $order;
    }

    /**
     * @param $price
     * @param $qty
     * @param $discount_code
     * @param int $type // 1 = all, 2 = product
     * @return array|false|int
     */
    private function orderTotal($price, $qty, $discount_code, $type = 1, $product_id = 0)
    {
        $discountPrice = 0;

        $total = $qty * $price;

        if ($discount_code) {
            $discount = Discount::whereCode($discount_code)->whereNull('deleted_at')->whereBusinessId(\Auth::user()->business_id)->first();

            if (!$discount){
                return false;
            }
            if ($type == 2) {
                if (empty(DiscountProduct::whereDiscountId($discount->id)->whereProductId($product_id)->first())) {
                    return false;
                }
                if (optional(Product::find($product_id))->discount_not_allowed == 1) {
                    return false;
                }
            }

            $startTime = $discount->from_date . ' ' . $discount->from_time;
            $endTime = $discount->to_date . ' ' . $discount->to_time;

            $start = now()->diffInMinutes(Carbon::parse($startTime), false);
            $end = now()->diffInMinutes(Carbon::parse($endTime), false);

            if ($discount->minimum_amount > ($qty * $price)) {
                return false;
            }
            if ($discount->minimum_quantity > $qty) {
                return false;
            }

            if (($start > 0 && $end > 0) || ($start < 0 && $end < 0)) {
                return false;
            }

            $discountValue = $discount->discount_value;
            $discountType = $discount->discount_type_id;

            if ($discountType == 1) {
                $discountPrice = round($total * $discountValue / 100, 2);
            } else {
                $discountPrice = round($total - $discountValue, 2);
            }
            return $discountPrice;
        }
        return false;
    }

    public function orderDetails($request, $order_id)
    {
        OrderDetail::whereOrderId($order_id)->delete();
        $total = 0;
        $totalQty = 0;
        /**
         * @var $cart OrderDetail
         */
        foreach ($request->cart as $cart) {
            $productPrice = 0;
            $productQty = 0;
            $cart = json_decode(json_encode($cart));
            /**
             * @var $discount Discount
             */
            $discount = [];
            if (!empty($cart->discount_code)) {
                $discount = Discount::whereCode($cart->discount_code)->first();
            }
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order_id;
            if (!empty($cart->product_id)) {
                $orderDetail->product_id = $cart->product_id;
            }
            if (!empty($cart->selectedVariant->id)) {
                $orderDetail->product_variation_id = $cart->selectedVariant->id;
            }
            if (!empty($cart->addOns) && is_array($cart->addOns)) {
                foreach ($cart->addOns as $addon) {
                    $orderAddon = new OrderAddons();
                    $orderAddon->order_id = $order_id;
                    $orderAddon->addon_id = $addon->id;
                    $orderAddon->price = $addon->price;
                    $orderAddon->save();
                }
            }
            if (!empty($cart->category_id)) {
                $orderDetail->category_id = $cart->category_id;
            }
            if (!empty($cart->qty)) {
                $totalQty += $productQty = $orderDetail->qty = $cart->qty;
            }
            if (!empty($cart->price)) {
                $productPrice = $orderDetail->price = $cart->price;
            }

            if (!empty($cart->discount_code)) {
                $discountVal = $this->orderTotal($cart->price, $cart->qty, $cart->discount_code, 2, $cart->product_id);
                if (!empty($discountVal)) {
                    $orderDetail->discount = $discountVal;
                    $orderDetail->discount_code = $discount->code;
                    $orderDetail->discount_type = $discount->discount_type_id;
                    $orderDetail->discount_value = $discount->discount_value;

                    $discountLog = new DiscountLogs();
                    $discountLog->order_id = $order_id;
                    $discountLog->product_id = $cart->product_id;
                    $discountLog->discount_id = $discount->id;
                    $discountLog->amount = $discountVal;
                    $discountLog->save();
                }
            }
            $total += $orderDetail->total = $productQty * $productPrice;
            $orderDetail->save();
        }
        /**
         * @var $order Order
         */
        $order = Order::find($order_id);
        $order->subtotal = $total;
        $order->tip_amount = $request->tip;
        $order->tax = $request->tax;

        $discountVal = $this->orderTotal($total, $totalQty, $request->discount_code, 1);
        if (!empty($discountVal)) {
            $discount = [];
            $discount = Discount::whereCode($request->discount_code)->first();
            $order->discount = $discountVal;
            $order->discount_code = $discount->code;
            $order->discount_type = $discount->discount_type_id;
            $order->discount_value = $discount->discount_value;

            $discountLog = new DiscountLogs();
            $discountLog->order_id = $order_id;
            $discountLog->product_id = $cart->product_id;
            $discountLog->discount_id = $discount->id;
            $discountLog->amount = $discountVal;
            $discountLog->save();
        }
        $order->save();
    }


    public function saveAddress($address, $order_id, $type, $same = false)
    {
        if (!empty($address->id)){
            $orderAddress = OrderAddresses::find($address->id);
        } else {
            $orderAddress = new OrderAddresses();
        }
        $orderAddress->order_id = $order_id;
        $orderAddress->email = !empty($address->email) ? $address->email : $orderAddress->email;
        $orderAddress->name = !empty($address->name) ? $address->name : $orderAddress->name;
        $orderAddress->city_id = !empty($address->state) ? $address->state : $orderAddress->city_id;
        $orderAddress->area_id = !empty($address->area) ? $address->area : $orderAddress->area_id;
        $orderAddress->address = !empty($address->address) ? $address->address : $orderAddress->address;
        $orderAddress->company_name = !empty($address->company) ? $address->company : $orderAddress->company_name;
        $orderAddress->phone = !empty($address->phone) ? $address->phone : $orderAddress->phone;
        $orderAddress->zipcode = !empty($address->zip) ? $address->zip : $orderAddress->zipcode;
        $orderAddress->type = $type;
        $orderAddress->same_address = $same;
        $orderAddress->save();
    }

    public function orderAddresses($request, $order_id)
    {
        $billingName = '';
        $billingPhone = '';
        $shippingName = '';
        $shippingPhone = '';

        $request->shippingInfo = json_decode(json_encode($request->shippingInfo));

        if (!empty($request->shippingInfo->shipping_address)) {

            $this->saveAddress($request->shippingInfo->shipping_address, $order_id,
                AppConstants::ADDRESS_TYPE_SHIPPING);

            $shippingName = $request->shippingInfo->shipping_address->name;
            $shippingPhone = $request->shippingInfo->shipping_address->phone;

            if (is_string($request->shippingInfo->same_billing_address)){
                $request->shippingInfo->same_billing_address = $request->shippingInfo->same_billing_address == "true" ? true : false;
            }
            if (!empty($request->shippingInfo->same_billing_address) && $request->shippingInfo->same_billing_address == true) {

                $this->saveAddress($request->shippingInfo->shipping_address, $order_id,
                    AppConstants::ADDRESS_TYPE_BILLING, true);

                $billingName = $request->shippingInfo->shipping_address->name;
                $billingPhone = $request->shippingInfo->shipping_address->phone;
                $billingAddress = $request->shippingInfo->shipping_address;

            } else {

                if (!empty($request->shippingInfo->billing_address)) {
                    $this->saveAddress($request->shippingInfo->billing_address, $order_id,
                        AppConstants::ADDRESS_TYPE_BILLING);
                    $billingName = $request->shippingInfo->billing_address->name;
                    $billingPhone = $request->shippingInfo->billing_address->phone;
                    $billingAddress = $request->shippingInfo->billing_address;
                }

            }

            if (!empty($billingName) && !empty($billingPhone)) {

                $customer = $this->customerService->save($billingAddress);
                if ($customer) {
                    $order = Order::find($order_id);
                    $order->customer_id = $customer->id;
                    $order->save();
                }

            }

            if (!empty($shippingName) && !empty($shippingPhone)) {

                if ($shippingPhone != $billingPhone && $shippingName != $billingName) {
                    $this->customerService->save($request->shippingInfo->shipping_address);
                }
            }
        }

    }

    public function search($params)
    {
        if (\Auth::user()->id ==1){
            $orders = Order::whereNull('deleted_at');
        }else{
            $orders = Order::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at');
        }
        $orders = $orders->whereHas('customer');

        if (empty($params['count'])) {
            if (url()->current() == route('orders-list-unfulfilled')) {
                $orders = $orders->where(['fulfilment_status_id' => IStatus::PROCESSING]);
            }

            if (url()->current() == route('orders-list-delivery-out')) {
                $orders = $orders->where(['order_status_id' => IStatus::OUT_FOR_DELIVERY]);
            }

            if (url()->current() == route('orders-list-unpaid')) {
                $orders = $orders->where(['payment_status_id' => IStatus::PAYMENT_PENDING]);
            }

            if (url()->current() == route('admin-orders-list-un-success')) {
                $orders = $orders->where(['payment_status_id' => IStatus::PAYMENT_PENDING]);
            }
        }

        if (!empty($params['customer_id'])) {
            $orders = $orders->whereCustomerId($params['customer_id']);
        }

        if (!empty($params['stores'])) {
            $orders = $orders->whereIn('store_id', $params['store_id']);
        }

        if (!empty($params['business_id'])) {
            $orders = $orders->whereIn('business_id', $params['business_id']);
        }

        if (!empty($params['state_id'])) {
            $orders = $orders->whereHas('store', function ($q) use ($params){
                $q->whereIn('state_id', $params['state_id']);
            });
        }

        if (!empty($params['payment_status'])) {
            $orders = $orders->whereIn('payment_status_id', $params['payment_status']);
        }

        if (!empty($params['fulfilment_status'])) {
            $orders = $orders->whereIn('fulfilment_status_id', $params['fulfilment_status']);
        }

        if (!empty($params['order_status'])) {
            $orders = $orders->whereIn('order_status_id', $params['order_status']);
        }

        if (!empty($params['from_date'])){
            $orders = $orders->whereDate('created_at','>=', $params['from_date']);
        }
        if (!empty($params['to_date'])){
            $orders = $orders->whereDate('created_at','<=', $params['to_date']);
        }

        if (!empty($params['api']) && empty($params['customer_id'])){
            return [];
        }
        if (!empty($params['count'])){
            return $orders->count('id');
        }

        if (!empty($params['sum'])) {
            return $orders->sum($params['sum_field']);
        }

        if (!empty($params['limit'])) {
            return $orders->limit($params['limit'])->orderBy('id', 'desc')->get();
        }

        return $orders->orderBy('id', 'desc')->paginate(AppConstants::PAGINATE_LARGE);
    }

    public function findById($order_id)
    {
        return Order::findOrFail($order_id);
    }

    public function findByOrderNumber($order_number)
    {
        return Order::whereOrderNumber($order_number)->whereBusinessId(Auth::user()->business_id)->first();
    }

    public function status($request, $type, $id)
    {
        $order = $this->findById($id);
        if ($order) {
            if ($type == 'payment') {
                $order->payment_status_id = $request->status_id;
                $status = CommonHelper::paymentStatus()[$request->status_id];
                $message = 'Order has been successfully marked as '.$status;
                $this->orderHistory($request->status_id, AppConstants::ORDER_STATUS_TYPE_PAYMENT, $id);
            }
            if ($type == 'fulfilment') {
                $order->fulfilment_status_id = $request->status_id;
                $status = CommonHelper::fulfilmentStatus()[$request->status_id];
                $message = 'Order has been successfully marked as '.$status;
                $this->orderHistory($request->status_id, AppConstants::ORDER_STATUS_TYPE_FULFILMENT, $id);
            }
            if ($type == 'order') {
                $order->order_status_id = $request->status_id;
                $status = CommonHelper::orderStatus()[$request->status_id];
                $message = 'Order has been successfully marked as '.$status;
                $this->orderHistory($request->status_id, AppConstants::ORDER_STATUS_TYPE_ORDER, $id);
            }
        }

        $object = new \stdClass();
        $object->user = Auth::user()->name;
        $object->order_number = $order->formatted_number;
        $object->order_id = $order->id;

        if ($request->status_id == IStatus::CANCELLED){
            $cancelMail = new OrderCancelConfirmationMail($order);
            \Mail::to($order->customer->email)->send($cancelMail);

            Business::find(Auth::user()->business_id)->user->notify(new OrderCancel($object));
            event(new OrderCancelEvent());

        }

        if ($request->status_id == IStatus::PAYMENT_REFUNDED){
            $refundMail = new OrderRefundMail($order);
            \Mail::to($order->customer->email)->send($refundMail);

            Business::find(Auth::user()->business_id)->user->notify(new PaymentRefund($object));
            event(new PaymentRefundEvent());
        }

        if ($request->status_id == IStatus::OUT_FOR_DELIVERY){
            $refundMail = new TrackOrderMail($order);
            \Mail::to($order->customer->email)->send($refundMail);
        }

        if ($request->status_id == IStatus::DELIVERED) {
            Business::find(Auth::user()->business_id)->user->notify(new OrderDelivered($object));
            event(new OrderDeliveredEvent());
        }

        $order->save();
        return $message;
    }

    public function orderHistory($status, $type, $id)
    {
        $statuses = array_keys(CommonHelper::orderStatus()->toArray());

        $count = 0;


        if ($type == AppConstants::ORDER_STATUS_TYPE_FULFILMENT) {
            foreach ($statuses as $item) {
                if (Status::find($item)->type == FulfillmentStatus::class) {
                    $newStatusArr[$count]['type'] = AppConstants::ORDER_STATUS_TYPE_FULFILMENT;
                }
                if ($item == $status) {
                    $newStatusArr[$count]['status'] = $item;
                    break;
                }
                $newStatusArr[$count]['status'] = $item;
                $count++;
            }

            foreach ($newStatusArr as $item) {
                if (! OrderHistory::where('status_id', '=', $item['status'])->whereOrderId($id)->first()) {
                    $orderHistory = new OrderHistory();
                    $orderHistory->order_id = $id;
                    $orderHistory->status_id = $item['status'];
                    $orderHistory->type_id = $item['type'];
                    $orderHistory->is_comment = false;
                    $orderHistory->user_id = \Auth::user()->id;
                    $orderHistory->save();
                }
            }
        } else {
            $orderHistory = new OrderHistory();
            $orderHistory->order_id = $id;
            $orderHistory->status_id = $status;
            $orderHistory->type_id = $type;
            $orderHistory->is_comment = false;
            $orderHistory->user_id = \Auth::user()->id;
            $orderHistory->save();
        }
    }

    public function orderHistoryOnCreate($id, $status, $type)
    {
        $orderHistory = new OrderHistory();
        $orderHistory->order_id = $id;
        $orderHistory->status_id = $status;
        $orderHistory->type_id = $type;
        $orderHistory->is_comment = false;
        $orderHistory->user_id = \Auth::user()->id;
        $orderHistory->save();
    }

    public function payment($request, $order_id)
    {
        $paymentData = $request->payment;
        $paymentResponse = $paymentData['payment_response'];
        $payment = new Payment();
        $payment->order_id = $order_id;
        $payment->business_id = \Auth::user()->business_id;
        $payment->payment_type_id = $paymentData['type'];
        $payment->payment_method_id = $paymentData['payment_method_id'];
        $payment->reference_number = $paymentResponse['tracking_id'];
        $payment->amount = $paymentResponse['amount'];
        $payment->status = IStatus::PAYMENT_PAID;
        $payment->is_paid = IStatus::PAYMENT_PAID;
        $payment->payment_data = json_encode($paymentResponse);
        $payment->save();
    }

    /**
     * @param $request
     * @param $order Order
     * @return ShipmentCreationResponse|string[]
     */
    public function createAramexShipping($id)
    {
        $order = $this->findById($id);
        $store = $order->store;

        $shipperAddress = new Address();
        $shipperAddress->setCountryCode('AE');
        $shipperAddress->setCity($store->state->name);
        $shipperAddress->setLine1($store->address_1);
        $shipperAddress->setLine2($store->address_2);

        $shipperContact = new Contact();
        $shipperContact->setCompanyName($store->business->name);
        $shipperContact->setPersonName($store->name);
        $shipperContact->setCellPhone($store->mobile);
        $shipperContact->setPhoneNumber1($store->phone);
        $shipperContact->setEmailAddress($store->email);


        $shipper = new Party();
        $shipper->setPartyAddress($shipperAddress);
        $shipper->setContact($shipperContact);
        if (config()->get('aramex.ENV') == 'TEST'){
            $shipper->setAccountNumber(config('aramex.TEST.AccountNumber'));
        } else {
            $shipper->setAccountNumber(config('aramex.LIVE.AccountNumber'));
        }

        $address = $order->shippingAddress;

        $consigneeAddress = new Address();
        $consigneeAddress->setCountryCode('AE');
        $consigneeAddress->setCity($address->city_name);
        $consigneeAddress->setLine1($address->address);
        $consigneeAddress->setLine2($address->address);


        $consigneeContact = new Contact();
        $consigneeContact->setCompanyName($order->business->name);
        $consigneeContact->setPersonName($address->name);
        $consigneeContact->setCellPhone($address->phone);
        $consigneeContact->setPhoneNumber1($address->phone);
        $consigneeContact->setEmailAddress($address->email);


        $consignee = new Party();
        $consignee->setPartyAddress($consigneeAddress);
        $consignee->setContact($consigneeContact);

        $weight = new Weight();
        $weight->setValue('1');
        $weight->setUnit('KG');

        $shipmentDetails = new ShipmentDetails();
        $shipmentDetails->setActualWeight($weight);
        $shipmentDetails->setNumberOfPieces(1);
        $shipmentDetails->setProductGroup(AramexConstants::PRODUCT_GROUP_DOM);
        $shipmentDetails->setProductType(AramexConstants::PRODUCT_TYPE_OND);
        $shipmentDetails->setPaymentType(AramexConstants::PAYMENT_PREPAID);


        $createShipment = new Shipment();
        $createShipment->setShipper($shipper);
        $createShipment->setConsignee($consignee);
        $createShipment->setReference1('ref');
        $createShipment->setPickupLocation($store->address_1);
        $createShipment->setDetails($shipmentDetails);
        $createShipment->setTransportType(0);
        $createShipment->setShippingDateTime(strtotime(now()));
        $createShipment->setDueDate(strtotime(now()->addDays(7)));

        $shipmentResponse = Aramex::createShipments()->addShipment($createShipment)->run();

        if ($shipmentResponse->isSuccessful()){
            foreach ($shipmentResponse->getShipments() as $shipment) {
                $deliveryResponse = new DeliveryCompanyResponses();
                $deliveryResponse->delivery_company_id = AppConstants::DELIVERY_COMPANY_ARAMEX;
                $deliveryResponse->order_id = $order->id;
                $deliveryResponse->type = AppConstants::ARAMEX_SHIPPING;
                $deliveryResponse->tracking_id = $shipment->ID;
                $deliveryResponse->response_data = json_encode($shipment);
                $deliveryResponse->save();
            }
        }
        return $shipmentResponse;
    }

    /**
     * @param $request
     * @param $order Order
     * @return PickupCreationResponse
     */
    public function createAramexPickup($id)
    {
        $order = $this->findById($id);
        $store = $order->store;
        $address = new Address();
        $address->setLine1($store->address_1)->setCity($store->state->name)->setCountryCode('AE');

        $contact = new Contact();
        $contact->setCompanyName($store->business->name);
        $contact->setPersonName($store->name);
        $contact->setCellPhone($store->phone);
        $contact->setPhoneNumber1($store->phone);
        $contact->setEmailAddress($store->email);


        $weight = new Weight();
        $weight->setUnit('KG');
        $weight->setValue(1);

        $pickupItem = new PickupItem();
        $pickupItem->setNumberOfPieces(1);
        $pickupItem->setNumberOfShipments(1);
        $pickupItem->setPayment(AramexConstants::PAYMENT_COD);
        $pickupItem->setShipmentWeight($weight);

        $pickup = new Pickup();
        $pickup->setPickupAddress($address);
        $pickup->setPickupContact($contact);
        $pickup->setPickupLocation($store->address_1);
        $pickup->setPickupDate(strtotime(now()->addDays(1)));
        $pickup->setReadyTime(strtotime(now()->addDays(1)->addHours(1)));
        $pickup->setLastPickupTime(strtotime(now()->addDays(1)->addHours(2)));
        $pickup->setClosingTime(strtotime(\Carbon\Carbon::parse($store->closing_time)));
        $pickup->setReference1('Ref');
        $pickup->addPickupItem($pickupItem);
        $pickup->setStatus('Ready');


        $pickupResponse = Aramex::createPickup()->setPickup($pickup)->run();
        if ($pickupResponse->isSuccessful()) {

            $pickup = $pickupResponse->getPrecessedPickup();
            $deliveryResponse = new DeliveryCompanyResponses();
            $deliveryResponse->delivery_company_id = AppConstants::DELIVERY_COMPANY_ARAMEX;
            $deliveryResponse->order_id = $order->id;
            $deliveryResponse->type = AppConstants::ARAMEX_PICKUP;
            $deliveryResponse->tracking_id = $pickup->getId();
            $deliveryResponse->response_data = json_encode(
                [
                    'id' => $pickup->getId(),
                    'guid' => $pickup->getGUID(),
                    'reference_1' => $pickup->getReference1()
                ]
            );
            $deliveryResponse->save();
        }

        return $pickupResponse;
    }

    public function trackShipment($id)
    {
        $res = Aramex::trackShipments()
            ->setShipments([$id])
            ->run();
        return $res;
    }

    public function labelPrint($id)
    {
        $orderDeliveryResponse = DeliveryCompanyResponses::whereTrackingId($id)->whereType(AppConstants::ARAMEX_SHIPPING)->first();
        $labelInfo = new LabelInfo();
        $labelInfo->setReportId(9201)
            ->setReportType('URL');

        $response = Aramex::printLabel()
            ->setShipmentNumber($id)
            ->setLabelInfo($labelInfo)
            ->run();

        if ($response->isSuccessful()){
            $deliveryResponse = new DeliveryCompanyResponses();
            $deliveryResponse->delivery_company_id = AppConstants::DELIVERY_COMPANY_ARAMEX;
            $deliveryResponse->order_id = $orderDeliveryResponse->order_id;
            $deliveryResponse->type = AppConstants::ARAMEX_LABEL_PRINT;
            $deliveryResponse->tracking_id = $response->getShipmentNumber();
            $deliveryResponse->response_data = json_encode(['url' => $response->getShipmentLabel()->getLabelUrl()]);
            $deliveryResponse->save();
        }

        return $response;
    }
}
