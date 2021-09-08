<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->guard_name,
            'url' => $this->url,
            'created_at' => $this->created_at,
            'user_id' => [
                'user_id' => $this->user_id,
                'name' => "user dummy name",
            ],
            'business_id' => $this->business_id,
            'is_active' => $this->is_active,
            'image' => [
                'url' => !empty($this->image) ? optional($this->image)->url : asset('img/camera_icon.png'),
                'thumbnail' => !empty($this->image) ? asset('thumbnails/addons/'.optional($this->image)->thumbnail) : asset('img/camera_icon.png'),
            ]

        ];
    }
}
