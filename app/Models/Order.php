<?php

namespace App\Models;


use App\Constants\AppConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin IdeHelperOrder
 */
class Order extends Model
{
    use HasFactory;

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function fulfillmentStatus()
    {
        return $this->belongsTo(FulfillmentStatus::class, 'fulfilment_status_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddresses::class, 'order_id')->where('type', '=',
            AppConstants::ADDRESS_TYPE_SHIPPING);
    }

    public function billingAddress()
    {

        return $this->hasOne(OrderAddresses::class, 'order_id')->where('type', '=', AppConstants::ADDRESS_TYPE_BILLING);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function deliveryCompany()
    {
        return $this->belongsTo(DeliveryCompany::class, 'delivery_company_id');
    }

    public function payment(){
        return $this->hasOne(Payment::class, 'order_id')->orderBy('id','desc');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function getInvoiceNumberAttribute($invoice_number)
    {
        return $this->formatted_inv_number;
    }

    public function shippingDeliveryResponse()
    {
        return $this->hasOne(DeliveryCompanyResponses::class, 'order_id')->where('type', '=', AppConstants::ARAMEX_SHIPPING);
    }

    public function pickupDeliveryResponse()
    {
        return $this->hasOne(DeliveryCompanyResponses::class, 'order_id')->where('type', '=', AppConstants::ARAMEX_PICKUP);
    }

    public function lablePrintDeliveryResponse()
    {
        return $this->hasOne(DeliveryCompanyResponses::class, 'order_id')->where('type', '=', AppConstants::ARAMEX_LABEL_PRINT);
    }
}
