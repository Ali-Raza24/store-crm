<?php

namespace App\Http\Resources;

use App\Helpers\CommonHelper;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var $order Order
         */
        $order = $this;
        return [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'format_number' => $order->formatted_number,
            'invoice_number' => $order->invoice_number,
            'total' => $order->total,
            'tax' => $order->tax,
            'discount' => $order->discount,
            'sub_total' => $order->subtotal,
            'shipping_charges' => $order->delivery_charges,
            'created_at' => $order->created_at,
            'order_status' => [
                'id' => $order->order_status_id,
                'title' => optional($order->fulfillmentStatus)->title
            ],
            'payment_status' => [
                'id' => $order->payment_status_id,
                'title' => optional($order->paymentStatus)->title
            ],
            'fulfilment_status' => [
                'id' => $order->fulfilment_status_id,
                'title' => optional($order->fulfillmentStatus)->title
            ],
            'payment_type' => [
                'id' => $order->payment_type_id,
                'title' => optional($order->paymentType)->title
            ],
            'delivery_type' => [
                'id' => $order->delivery_company_id,
                'title' => optional($order->deliveryCompany)->title
            ],
            'details' => $this->mapOrderDetails($order),
            'shipping_info' => [
                'shipping_address' => [
                    'name' => $order->shippingAddress->name,
                    'email' => $order->shippingAddress->email,
                    'phone' => $order->shippingAddress->phone,
                    'zip' => $order->shippingAddress->zipcode,
                    'city' => [
                        'id' => $order->billingAddress->city_id,
                        'name' => $order->billingAddress->city_name
                    ],
                    'company' => $order->shippingAddress->company_name
                ],
                'billing_address' => [
                    'name' => $order->billingAddress->name,
                    'email' => $order->billingAddress->email,
                    'phone' => $order->billingAddress->phone,
                    'zip' => $order->billingAddress->zipcode,
                    'city' => [
                        'id' => $order->billingAddress->city_id,
                        'name' => $order->billingAddress->city_name
                    ],
                    'company' => $order->billingAddress->company_name
                ]
            ],
            'history' => $this->mapOrderHistory($order)
        ];
    }

    /**
     * @param $order Order
     */
    public function mapOrderDetails($order)
    {
        $details = [];
        foreach ($order->details as $detail) {
            $details[] = [
                'product' => [
                    'id' => $detail->product_id,
                    'title' => $detail->product->title,
                    'image' => $detail->product->main_image,
                    'description' => $detail->product->description
                ],
                'qty' => $detail->qty,
                'discount' => $detail->discount_value,
                'price' => $detail->price,
                'total' => ($detail->qty * $detail->price) - $detail->discount_value
            ];
        }
        return $details;
    }

    /**
     * @param $order Order
     */
    public function mapOrderHistory($order)
    {
        $histories = [];
        foreach ($order->history as $history) {
            if (empty($history->is_comment) || $history->is_comment == 0) {
                $histories[] = [
                    'status_id' => $history->status_id,
                    'title' => optional($history->status)->title,
                    'created_at' => $history->created_at
                ];
            }
        }
        return $histories;
    }
}
