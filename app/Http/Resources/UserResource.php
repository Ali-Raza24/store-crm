<?php

namespace App\Http\Resources;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $business = $this->business;
        if (!empty($this->business_id)){
            $business = Business::find($this->business_id);
        }
        /**
         * @var $this User
         */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'user_type_id' => $this->user_type_id,
            'is_business' => $this->is_business,
            'business_id' => $this->business_id,
            'location_id' => $this->location_id,
            'is_active' => $this->is_active,
            'business' => new BusinessResource($business)
        ];
    }
}
