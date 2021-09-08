<?php

namespace App\Http\Controllers\Admin;

use App\Constants\IStatus;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        parent::__construct('order');
    }
    public function index(Request $request)
    {
        $allOrders = $this->orderService->search(['count' => true]);
        $unpaidOrders = $this->orderService->search(['count' => true, 'payment_status' => [IStatus::PAYMENT_PENDING]]);
        $unfulfilledOrders = $this->orderService->search(['count' => true, 'fulfilment_status' => [IStatus::PROCESSING]]);
        $outForDelivery = $this->orderService->search(['count' => true, 'fulfilment_status' => [IStatus::OUT_FOR_DELIVERY]]);
        $businesses = Business::whereNull('deleted_at')->get()->pluck('name','id');

        $orders = $this->orderService->search(array_merge($request->all()));

        return view("admin.orders.list", compact('orders','allOrders', 'unfulfilledOrders', 'unpaidOrders', 'outForDelivery', 'businesses'));
    }

    public function detail(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        return view("admin.orders.detail", compact('order'));
    }
}
