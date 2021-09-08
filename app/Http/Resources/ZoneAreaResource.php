<?php

namespace App\Http\Resources;

use App\Models\ZoneArea;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoneAreaResource extends JsonResource
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
         * @var $this ZoneArea
         */
        return [
            'id' => $this->id,
            'zone_id' => $this->zone_id,
            'area_id' => $this->area_id,
            'title' => $this->area->title,
            'state_id' => $this->area->state_id,
            'zone' => $this->zone
        ];
    }
}
