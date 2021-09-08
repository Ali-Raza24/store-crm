<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreZoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->title,
            'days' => $this->days,
//            'hours' => Carbon::createFromFormat('H', !empty($this->hours) ? $this->hours : '00')->toAtomString(),
            'hours' => !empty($this->hours) ? $this->hours : '00',
            'min' => $this->minutes,
//            'minutes' => Carbon::createFromFormat('i', !empty($this->minutes) ? $this->minutes : '00')->toAtomString() ,
            'minutes' => !empty($this->minutes) ? $this->minutes : '00',
            'charges' => $this->charges,
            'rate' => $this->charges,
            'store_id' => $this->store_id,
            'delivery_company_id' => $this->delivery_company_id
        ];
    }
}
