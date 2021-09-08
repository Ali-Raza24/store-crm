<?php

namespace App\Http\Resources\Api;

use App\Constants\IStatus;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;
use Str;
use function Symfony\Component\Translation\t;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var $this Category
         */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => isset($this->slug) ? $this->slug : Str::slug(strtolower($this->title)),
            'products' => ProductResource::collection($this->products()->active()->get()),
            'total_products' => $this->products()->active()->count('products.id')
        ];
    }
}
