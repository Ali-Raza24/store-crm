<?php

namespace App\Http\Controllers;

use App\Constants\IStatus;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\AreaRequest;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Resources\AreaResource;
use App\Http\Resources\BusinessAreaResource;
use App\Http\Resources\StoreZoneResource;
use App\Http\Resources\ZoneAreaResource;
use App\Models\Area;
use App\Models\Business;
use App\Models\BusinessArea;
use App\Models\Store;
use App\Models\StoreZone;
use App\Models\ZoneArea;
use App\Services\AreaService;
use App\Services\StoreService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AreaController extends ApiBaseController
{
    private $areaService;

    private $storeService;

    public function __construct(AreaService $areaService, StoreService $storeService)
    {
        $this->areaService = $areaService;
        $this->storeService = $storeService;
//        $this->middleware('permission:shipping-areas')->only('index');
    }

    public function index(Request $request)
    {
        $request->request->add(['active' => true]);
        $areas = $this->areaService->search($request);
        return $this->sendSuccess('Success', AreaResource::collection($areas));
    }

    public function businessAreas(Request $request)
    {
        $businessArea = BusinessArea::whereBusinessId(Auth::user()->business_id)->get();
        if (count($businessArea) > 0){
            return $this->sendSuccess('success', BusinessAreaResource::collection($businessArea));
        }
        return $this->sendSuccess('success', []);
    }

    public function edit(Request $request, $id){
        $area = $this->areaService->findById($id);
        if ($area){
            return $this->sendSuccess('Found', (new AreaResource($area)));
        }
        return $this->sendError('Not found');
    }

    public function saveBusinessAreas(Request $request)
    {
        $businessZones = StoreZone::whereBusinessId(Auth::user()->business_id)->pluck('id');

        if (count($request->areas) > 1){
            foreach ($request->areas as $area) {
                BusinessArea::where(['business_id' => Auth::user()->business_id, 'area_id' => $area['area_id']])->delete();
                ZoneArea::whereAreaId($area['area_id'])->whereIn('zone_id',$businessZones)->delete();
                $businessArea = new BusinessArea();
                $businessArea->business_id = Auth::user()->business_id;
                $businessArea->area_id = $area['area_id'];
                $businessArea->save();
            }
            return $this->sendSuccess('Success',[]);
        }

        if (BusinessArea::where(['business_id' => Auth::user()->business_id, 'area_id' => $request->areas[0]['area_id']])->first()){
            BusinessArea::where(['business_id' => Auth::user()->business_id, 'area_id' => $request->areas[0]['area_id']])->delete();
            ZoneArea::whereAreaId($request->areas[0]['area_id'])->whereIn('zone_id',$businessZones)->delete();
        } else {
            foreach ($request->areas as $area) {
                $businessArea = new BusinessArea();
                $businessArea->business_id = Auth::user()->business_id;
                $businessArea->area_id = $area['area_id'];
                $businessArea->save();
            }
        }
        return $this->sendSuccess('Success',[]);
    }

    public function saveZones(StoreZoneRequest $request)
    {
        $store_id = $request->store_id;
        $delivery_company = $request->delivery_company_id;
        $title = $request->name;
        if (empty($request->id)){
            $exist = StoreZone::where([
                'store_id' => $store_id,
                'delivery_company_id' => $delivery_company,
            ])->whereBusinessId(Auth::user()->business_id)
                ->whereRaw('lower(title) = "'. strtolower($title).'"')->first();
        }else{
            $exist = StoreZone::where('id','!=',$request->id)
                ->where([
                    'store_id' => $store_id,
                    'delivery_company_id' => $delivery_company,
                    ])
                ->whereBusinessId(Auth::user()->business_id)
                ->whereRaw('lower(title) = "'. strtolower($title).'"')->first();
        }

        $validator = Validator::make($request->all(),[]);

        if ($exist){
            return response()->json(['errors' => ['name' => ['Zone name already exist']]],422);
        }

        $this->storeService->saveZone($request);
        return $this->sendSuccess('Successfully saved');
    }

    public function list(Request $request)
    {
        $stores = Store::whereBusinessId(Auth::user()->business_id)->whereIsActive(IStatus::ACTIVE)->get()->pluck('name', 'id');
        return $this->sendSuccess('Success', $stores);
    }

    public function zones(Request $request)
    {
        $zones = StoreZone::whereBusinessId(Auth::user()->business_id)->whereNull('deleted_at');
        $zones = $zones->whereStoreId($request->store_id);
        $zones = $zones->whereDeliveryCompanyId($request->delivery_company_id);;;
        $zones = $zones->get();

        if (count($zones) > 0)
        {
            return StoreZoneResource::collection($zones);
        }
        return $this->sendError('Not found');
    }

    public function activeBusinessArea(Request $request)
    {
        $businessArea = BusinessArea::whereBusinessId(Auth::user()->business_id)->get();
        return $this->sendSuccess('success',
            BusinessAreaResource::collection($businessArea));
    }

    public function getActiveZoneAreas(Request $request){
        $zoneArea = ZoneArea::whereHas('zone',function($q) use ($request){
            $q->whereStoreId($request->store_id);
            $q->whereDeliveryCompanyId($request->delivery_company_id);
        })->orderBy('area_id', 'ASC')->get();
        return $this->sendSuccess('success',ZoneAreaResource::collection($zoneArea));
    }

    public function zoneAreasSave(Request $request)
    {
        if (count($request->areas) > 1){
            if (empty($request->all_unselect)) {
                foreach ($request->areas as $area) {
                    ZoneArea::where(['zone_id' => $area['zone_id'], 'area_id' => $area['area_id']])->delete();
                    $zoneArea = new ZoneArea();
                    $zoneArea->zone_id = $area['zone_id'];
                    $zoneArea->area_id = $area['area_id'];
                    $zoneArea->save();
                }
            } else {
                foreach ($request->areas as $area) {
                    ZoneArea::where(['zone_id' => $area['zone_id'], 'area_id' => $area['area_id']])->delete();
                }
            }
            return $this->sendSuccess('Success',[]);
        }
        if (isset($request->areas[0])) {
            if (ZoneArea::where([
                'zone_id' => $request->areas[0]['zone_id'],
                'area_id' => $request->areas[0]['area_id']
            ])->first()) {
                ZoneArea::where([
                    'zone_id' => $request->areas[0]['zone_id'],
                    'area_id' => $request->areas[0]['area_id']
                ])->delete();
            } else {
                foreach ($request->areas as $area) {
                    $zoneArea = new ZoneArea();
                    $zoneArea->zone_id = $area['zone_id'];
                    $zoneArea->area_id = $area['area_id'];
                    $zoneArea->save();
                }
            }
        }
    }

    public function updateDelivery(Request $request)
    {
        $request->validate(['delivery_company_id' => 'required', 'store_id' => 'required']);
        $store = Store::whereBusinessId(Auth::user()->business_id)->whereId($request->store_id)->first();


        if ((empty($store->latitude) || empty($store->longitude)) && $request->delivery_company_id > 0) {
            return $this->sendError('Please update your store location first','','Please update your store location first');
        }
        if ($store) {
            $store->delivery_company_id = $request->delivery_company_id;
            $store->save();
        }
        return $this->sendSuccess('Successfully update');
    }

    public function deleteZone(Request $request, $id)
    {
        $zone = StoreZone::find($id);
        if ($zone){
            ZoneArea::whereZoneId($id)->delete();
            $zone->delete();
        }
        return $this->sendSuccess('Success');
    }

    public function editZone(Request $request, $id){
        $zone = StoreZone::find($id);
        if ($zone){
            return $this->sendSuccess('Found', (new StoreZoneResource($zone)));
        }
        return $this->sendError('Not found');
    }
}
