<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Business;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends ApiBaseController
{
    public function getDeliveryType(Request $request){
        $stores = Store::whereBusinessId(Auth::user()->business_id)->get();
        $data = [];
        if (count($stores) > 0){
            foreach ($stores as $store){
                $data[$store->id] = [
                    'store_id' => $store->id,
                    'delivery_company_id' => $store->delivery_company_id
                ];
            }
        }
        return $this->sendSuccess('Success', $data);
    }

    public function getDeliveryStore(Request $request){
        $store = Store::whereBusinessId(Auth::user()->business_id)->whereId(session()->get('store-data')->id)->first();
        return $this->sendSuccess('Success', [
            'store_id' => $store->id,
            'delivery_company_id' => $store->delivery_company_id
        ]);
    }
}
