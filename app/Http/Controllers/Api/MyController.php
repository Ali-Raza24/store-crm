<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class MyController extends ApiBaseController
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        parent::__construct();
    }

    public function orders(Request $request)
    {
        \request()->request->add(['api' => true]);
        $orders = $this->orderService->search($request);
        return $this->sendSuccess('OK', OrderResource::collection($orders), $orders);
    }
}
