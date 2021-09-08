<?php

namespace App\Http\Controllers\Api;

use App\Constants\IStatus;
use App\Http\Resources\StoreResource;
use App\Http\Resources\ZoneAreaResource;
use App\Models\Area;
use App\Models\Business;
use App\Models\BusinessArea;
use App\Models\Store;
use App\Models\StoreZone;
use App\Models\ZoneArea;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StoresController extends ApiBaseController
{
    /**
     * @var StoreService
     */
    private $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $stores = $this->storeService->search(['active' => true]);
        return $this->sendSuccess('OK', StoreResource::collection($stores));
    }

    public function areas(Request $request)
    {
        $store = $request->store_id;
        $state = $request->state_id;

        $storeDelivery = Store::find($store)->delivery_company_id;
        if (empty($storeDelivery) || $storeDelivery < 1) {
            $storeDelivery = 0;
        }

        $zones = StoreZone::whereBusinessId(\Auth::user()->business_id)->whereStoreId($store)->whereDeliveryCompanyId($storeDelivery)->get()->pluck('id');
        $areas = Area::whereIsActive(IStatus::ACTIVE)->whereStateId($state)->get()->pluck('id');

        $zoneAreas = ZoneArea::whereIn('zone_id',$zones)->whereIn('area_id',$areas)->get();
        return $this->sendSuccess('OK', ZoneAreaResource::collection($zoneAreas));
    }
}
