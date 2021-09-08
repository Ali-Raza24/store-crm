<?php

namespace App\Exports;

use App\Helpers\CommonHelper;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function collection()
    {
        return $orders = Order::whereNull('deleted_at')->whereBusinessId(\Auth::user()->business_id)->get([
            'id',
            'customer_id',
            'store_id',
            'payment_status_id',
            'fulfilment_status_id',
            'total'
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer',
            'Store',
            'Payment Status',
            'Fulfilment Status',
            'Total'
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            optional($order->customer)->name,
            optional($order->store)->name,
            CommonHelper::paymentStatus()[$order->payment_status_id],
            CommonHelper::fulfilmentStatus()[$order->fulfilment_status_id],
            $order->total
        ];
    }
}
