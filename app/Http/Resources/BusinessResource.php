<?php

namespace App\Http\Resources;

use App\Constants\IStatus;
use App\Models\Business;
use App\Models\Status;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $business = $this;

        /**
         * @var $business Business
         */
        return [
            "id" => (optional($business))->id,
            "business_id" => (optional($business))->id,
            "code" => optional($business)->code,
            "name" => optional($business)->name,
            "email" => optional($business)->email,
            "password" => '',
            "phone" => optional($business)->phone,
            "mobile" => optional($business)->mobile,
            "owner_name" => optional($business)->owner_name,
            "owner_email" => optional($business)->owner_email,
            "owner_phone" => optional($business)->owner_phone,
            "owner_mobile" => optional($business)->owner_mobile,
            "brand_color" => !empty($business->brand_color) ? $business->brand_color : '#ffffff',
            "minimum_order_amount" => optional($business)->minimum_order_amount,
            "url" => optional($business)->url,
            "business_type_id" => optional($business)->business_type_id,
            "plan_id" => optional($business)->plan_id,
            "plan" => $this->mapPlan(optional($business)->plan_id),
            "business_status_id" => optional($business)->business_status_id,
            "business_status" => $this->mapStatus(optional($business)->business_status_id),
            "address_1" => optional($business)->address_1,
            "address_2" => optional($business)->address_2,
            "country_id" => optional($business)->country_id,
            "state_id" => optional($business)->state_id,
            'created_at' => optional($business)->created_at,
            'images' => [],
            'imagesList' => $this->mapImages(optional($business)->images),
            'has_store' => !empty($business->id) ? Store::whereBusinessId($business->id)->count('id') : 0,
            "stores" => !empty($business->id) && Store::whereBusinessId($business->id)->count('id') > 0 ?
                $this->store($business->stores) :
                $this->store(),
        ];
    }

    public function mapStatus($id){
        if ($id){
            $businessStatus = Status::whereIsActive(IStatus::ACTIVE)->where(['type' => Business::class])->get()->pluck('title','id');
            return $businessStatus[$id];
        }else{
            return 'Pending';
        }

    }

    public function mapImages($image){
        $images = [];
        if (!empty($image->url)){
            $images['url'] = $image->url;
        }
        if (!empty($image->thumbnail)){
            $images['thumbnail'] = asset('thumbnails/business/'.$image->thumbnail);;
        }
        return $images;
    }

    public function mapPlan($id = null){
        if ($id == 1){
            return "Free";
        }
        if ($id == 2){
            return "Basic";
        }
        if ($id == 3){
            return "Standard";
        }
    }

    public function store($stores = [0])
    {
        $list = [];

        foreach ($stores as $store){
            /**
             * @var $store Store
             */
            $list[]= [
                "id" => optional($store)->id,
                "business_id" => optional($store)->business_id,
                "name" => optional($store)->name,
                "email" => optional($store)->email,
                "phone" => optional($store)->phone,
                "mobile" => optional($store)->mobile,
                "address_1" => optional($store)->address_1,
                "address_2" => optional($store)->address_2,
                "opening_time" => optional($store)->opening_time,
                "closing_time" => optional($store)->closing_time,
                "delivery_limit_km" => optional($store)->delivery_limit_km,
                "is_own_delivery" => optional($store)->is_own_delivery,
                "delivery_company_id" => optional($store)->delivery_company_id,
                "latitude" => optional($store)->latitude,
                "longitude" => optional($store)->longitude,
                "industry_id" => optional($store)->industry_id,
                "state_id" => optional($store)->state_id,
                "country_id" => optional($store)->country_id
            ];
        }
        return $list;
    }
}
