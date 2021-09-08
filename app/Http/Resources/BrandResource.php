<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Brand;

class BrandResource extends JsonResource
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
            'title' => $this->title,
            'url' => $this->url,
            'created_at' => $this->created_at,
            'business_id' => $this->business_id,
            'is_active' => $this->is_active,
            'image' => [
                'url' => !empty($this->image) ? optional($this->image)->url : asset('img/camera_icon.png'),
                'thumbnail' => !empty($this->image) ? optional($this->image)->thumbnail : asset('img/camera_icon.png'),
            ]

        ];
    }
}
