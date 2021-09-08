<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Models\BusinessStoreArea;
use App\Models\Store;
use App\Models\StoreZone;
use App\Models\ZoneArea;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreService
{

    public function findById($id){
        return Store::find($id);
    }

    public function findLatestByBusiness($id){
        return Store::whereBusinessId($id)->orderBy('id','desc')->first();
    }

    public function findByBusiness($id, $count = false){
        if ($count){
            return Store::whereBusinessId($id)->count('id');
        }
        return Store::whereBusinessId($id)->get();
    }
    //
    public function save($request, $business_id = null)
    {
        $request = json_decode(json_encode($request));
        if (!empty($request->store_id)) {
            $store = Store::find($request->store_id);
        } else {
            $store = new Store();
        }
        if (!empty($business_id) || !empty($request->business_id)){
            $store->business_id = isset($business_id) ? $business_id : $request->business_id;
        }
        if (!empty($request->name)){
            $store->slug = Str::slug($request->name);
            $store->name = $request->name;
        }
        if (!empty($request->email)) {
            $store->email = $request->email;
        }
        if (!empty($request->phone)) {
            $store->phone = $request->phone;
        }
        if (!empty($request->mobile)) {
            $store->mobile = $request->mobile;
        }
        if (!empty($request->address_1)) {
            $store->address_1 = $request->address_1;
        }
        if (!empty($request->address_2)) {
            $store->address_2 = $request->address_2;
        }
        if (!empty($request->opening_time)) {
            $store->opening_time = Carbon::parse($request->opening_time)->format('H:i');
        }
        if (!empty($request->closing_time)) {
            $store->closing_time = Carbon::parse($request->closing_time)->format('H:i');
        }
        if (!empty($request->delivery_limit_km)) {
            $store->delivery_limit_km = $request->delivery_limit_km;
        }
        if (!empty($request->is_own_delivery)) {
            $store->is_own_delivery = $request->is_own_delivery;
        }
        if (!empty($request->delivery_company_id)) {
            $store->delivery_company_id = $request->delivery_company_id;
        }
        if (!empty($request->latitude)) {
            $store->latitude = $request->latitude;
        }
        if (!empty($request->longitude)) {
            $store->longitude = $request->longitude;
        }
        if (!empty($request->industry_id)) {
            $store->industry_id = $request->industry_id;
        }
        if (!empty($request->state_id)) {
            $store->state_id = $request->state_id;
        }
        if (!empty($request->country_id)) {
            $store->country_id = $request->country_id;
        }

        $store->is_active = IStatus::ACTIVE;
        $store->save();

        return $store;
    }

    public function saveAreas($request)
    {
        foreach ($request->areas as $area){
            $storeArea = BusinessStoreArea::find($area['id']);
            $storeArea->is_active = $area['is_active'];
            $storeArea->save();
        }
        return true;
    }

    public function saveZone($request)
    {
        if (empty($request->id)){
            $zone = new StoreZone();
        }else{
            $zone = StoreZone::find($request->id);
        }

        $zone->title = $request->name;
        $zone->business_id = Auth::user()->business_id;
        $zone->store_id = $request->store_id;
        $zone->charges = $request->rate;
        $zone->days = $request->days;
        $zone->hours = $request->hours;
        $zone->minutes = $request->minutes;
        $zone->delivery_company_id = isset($request->delivery_company_id) ? $request->delivery_company_id : 0;
        $zone->save();
    }

    public function search($params = [], $paginate = false)
    {
        $stores = Store::whereNull('deleted_at');

        if (Auth::check() && Auth::user()->business_id > 0){
            $stores = $stores->whereBusinessId(Auth::user()->business_id);
        }

        if (isset($params['active'])){
            $stores = $stores->whereIsActive(IStatus::ACTIVE);
        }

        if (!empty($params['from_date'])){
            $stores = $stores->whereDate('created_at','>=', $params['from_date']);
        }

        if (!empty($params['to_date'])){
            $stores = $stores->whereDate('created_at','<=', $params['to_date']);
        }

        if (isset($params['count'])) {
            return $stores->count('id');
        }

        if ($paginate){
            return $stores->paginate(AppConstants::PAGINATE_SMALL);
        }
        return $stores->get();
    }
}
