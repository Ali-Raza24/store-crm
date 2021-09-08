<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
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
            'id' => $this->id,
            'area_id' => $this->id,
            'title' => $this->title,
            'name' => $this->title,
            'state_id' => $this->state_id,
            'is_active' => $this->is_active,
            'delivery_company_id' => $this->delivery_company_id,
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng
        ];
    }
}
