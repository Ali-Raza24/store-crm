<?php

namespace App\Http\Resources;

use App\Constants\IStatus;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use function GuzzleHttp\Promise\all;

class ProductResource extends JsonResource
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
         * @var $product Product
         */
        $product = $this;
        $productVariants = $this->mapVariants($product);
        return [
            'id' => $product->id,
            'title' => $product->title,
            'slug' => isset($product->slug) ? $product->slug : Str::slug(strtolower($product->title)),
            'description' => $product->description,
            'brand' => [
                'id' => $product->brand_id,
                'name' => optional($product->brand)->title,
            ],
            'is_available' => $product->is_active == IStatus::ACTIVE,
            'retail_price' => $product->retail_price,
            'discounted_price' => $product->discounted_price,
            'has_addons_or_variants' => $product->has_addons_or_variants,
            'addons' => $this->mapAddons($product),
            'product_variants' => $this->filterVariants($product, $productVariants),
            'variants' => $productVariants,
            'images' => $this->mapImages($product),
            'weight' => $product->weight,
        ];
    }

    /**
     * @param $product Product
     */
    public function mapImages($product)
    {
        $images = [];
        if ($product->images){
            foreach ($product->images()->get() as $image){
                $images[] = $image->url;
            }
        }
        return $images;
    }

    /**
     * @param $product Product
     */
    public function mapAddons($product)
    {
        $addons = [];
        if ($product->has_addons_or_variants == 1) {
            foreach ($product->addons()->get() as $addon) {
                $addons[] = ['id' => $addon->id, 'name' => optional($addon->addons)->title, 'price' => optional($addon->addons)->price];
            }
        }
        return $addons;
    }

    /**
     * @param $product Product
     */
    public function mapVariants($product)
    {
        $variants = [];
        if ($product->has_addons_or_variants == 2) {
            foreach ($product->variants as $variant) {
                $variants[] = [
                    'id' => $variant->id,
                    'name' => $variant->title,
                    'retail_price' => $variant->retail_price,
                    'discounted_price' => $variant->discounted_price,
                    'options' => explode('/', $variant->title),
                    'image' => optional($variant->images()->first())->url
                ];
            }
        }


        return $variants;
    }

    /**
     * @param $product Product
     */
    public function filterVariants($product, $productVariants)
    {
        $optionsList =  Arr::pluck($productVariants,'options');
        $optionsList = Arr::flatten($optionsList);
        $optionsList = array_unique($optionsList);

        $variantList = [];
        $variants = ProductVariant::whereProductId($product->id)->with('variantOptions')->get();

        if ($variants){
            foreach ($variants as $variant){
                $options = $variant->variantOptions()->distinct('option')->pluck('option', 'id');
                foreach ($options as $key => $value) {
                    if (in_array($value, $optionsList)) {
                        $variantList[$variant->variant][$key] = $value;
                    }
                }
                $variantList[$variant->variant] = array_unique($variantList[$variant->variant]);
            }
        }
        return (object)$variantList;
    }
}
