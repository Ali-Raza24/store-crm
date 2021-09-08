<?php

namespace App\Http\Resources;

use App\Constants\AppConstants;
use App\Models\Store;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var $this Store
         */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'address' => $this->address_1,
            'city' => optional($this->state)->name,
            'delivery_company' => [
                'id' => $this->delivery_company_id,
                'type' => ($this->delivery_company_id == 1) ? AppConstants::ARAMEX : AppConstants::OWN,
            ]
        ];
    }
}
