<?php

namespace App\Http\Resources;

use App\Models\StoreZone;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessAreaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->area->id,
            'area_id' => $this->area->id,
            'title' => $this->area->title,
            'name' => $this->area->title,
            'state_id' => $this->area->state_id,
            'delivery_company_id' => $this->area->delivery_company_id,
            'zone' => $this->zone->count('id')
        ];
    }
}
