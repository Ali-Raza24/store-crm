<?php

namespace App\Http\Controllers\Admin;

use App\Constants\IStatus;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Services\BusinessService;
use App\Services\OrderService;
use App\Services\StoreService;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $orderService;
    private $businessService;
    private $storeService;

    public function __construct(OrderService $orderService, BusinessService $businessService, StoreService $storeService)
    {
        parent::__construct();
        $this->orderService = $orderService;
        $this->businessService = $businessService;
        $this->storeService = $storeService;
        $this->middleware('permission:admin-dashboard');
    }

    public function index(Request $request)
    {
        $businessTotalCount = $this->businessService->search(['count' => true]);
        $storesTotalCount = $this->storeService->search(['count' => true]);
        $totalSales = $this->orderService->search(['sum' => true, 'sum_field' => 'total']);
        $cancelledOrders = $this->orderService->search(['order_status' => [IStatus::CANCELLED], 'count' => true]);

        $recentActivities = ActivityLog::whereBusinessId(\Auth::user()->business_id)->latest()->take(10)->get();

        $dates = [];
        $businessData = [];
        $storeData = [];
        $salesData= [];
        for($i = now()->startof('week')->day - now()->weekday(); $i <=  now()->day; $i++)
        {
            $dates[] = date('Y') . "/" . date('m') . "/" . str_pad($i, 2, '0', STR_PAD_LEFT);
            $businessData[] = $this->businessService->search(['count' => true, 'from_date' => \Arr::last($dates), 'to_date' => \Arr::last($dates)]);
            $storeData[] = $this->storeService->search(['count' => true, 'from_date' => \Arr::last($dates), 'to_date' => \Arr::last($dates)]);
            $salesData[] = $this->orderService->search(['sum' => true, 'sum_field' => 'total', 'from_date' => \Arr::last($dates), 'to_date' => \Arr::last($dates)]);
        }

        $businessChart = LarapexChart::areaChart()
            ->setTitle(false)
            ->setGrid()
            ->addData('Business Register',$businessData)
            ->setLabels($dates);

        $storeChart = LarapexChart::lineChart()
            ->setTitle(false)
            ->setGrid(false, '#dadada', 0.1)
            ->addData('Stores Register',$storeData)
            ->setLabels($dates);

        $salesChart = LarapexChart::lineChart()
            ->setTitle(false)
            ->setGrid(false, '#dadada', 0.1)
            ->addData('Total sales',$salesData)
            ->setLabels($dates);

        return view("admin.dashboard", compact('businessTotalCount', 'storesTotalCount', 'totalSales', 'cancelledOrders', 'businessChart', 'storeChart', 'salesChart', 'recentActivities'));
    }
}
