<?php

namespace App\Http\Controllers;

use App\Constants\IStatus;
use App\Models\ActivityLog;
use App\Models\DeliveryCompaniesCity;
use App\Models\DeliveryCompaniesCountry;
use App\Models\Store;
use App\Services\CustomerService;
use App\Services\OrderService;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Carbon\Carbon;
use Octw\Aramex\Aramex;

class HomeController extends Controller
{
    private $orderService;

    private $customerService;

    public function __construct(OrderService $orderService, CustomerService $customerService)
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        parent::__construct();
        $this->middleware('permission:business-dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $store = Store::whereBusinessId(\Auth::user()->business_id)->first();
        session()->put('store-name', $store->slug);

        if ($store) {
            session()->put('store-data', $store);
        }

        $totalSales = $this->orderService->search(['sum' => true, 'sum_field' => 'total']);
        $ordersCount = $this->orderService->search(['count' => true]);
        $pendingOrdersCount = $this->orderService->search([
            'count' => true,
            'fulfilment_status' => [IStatus::PROCESSING]
        ]);
        $customersCount = $this->customerService->search(['count' => true]);

        $recentActivities = ActivityLog::whereBusinessId(\Auth::user()->business_id)->latest()->take(10)->get();
        $latestOrders = $this->orderService->search(['limit' => 5]);

        $dates = [];
        $salesData = [];
        $customersData = [];
        for ($i = now()->startof('week')->day - now()->weekday(); $i <= now()->day; $i++) {
            $dates[] = date('Y') . "/" . date('m') . "/" . str_pad($i, 2, '0', STR_PAD_LEFT);
            $salesData[] = $this->orderService->search([
                'sum' => true,
                'sum_field' => 'total',
                'from_date' => \Arr::last($dates),
                'to_date' => \Arr::last($dates)
            ]);
            $customersData[] = $this->customerService->search([
                'count' => true,
                'from_date' => \Arr::last($dates),
                'to_date' => \Arr::last($dates)
            ]);
        }

        $salesChart = LarapexChart::lineChart()
            ->setTitle(false)
            ->setGrid(false, '#dadada', 0.1)
            ->addData('Total sales', $salesData)
            ->setLabels($dates);

        $customersChart = LarapexChart::areaChart()
            ->setTitle(false)
            ->setGrid(false, '#dadada', 0.1)
            ->addData('Customer Registers', $customersData)
            ->setLabels($dates);

        return view('business.dashboard',
            compact('totalSales', 'ordersCount', 'pendingOrdersCount', 'customersCount', 'latestOrders', 'salesChart',
                'customersChart', 'recentActivities'));
    }
}
