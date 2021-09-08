<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Helpers\ArrayHelper;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductAddons;
use App\Models\ProductCategories;
use App\Models\ProductStores;
use App\Models\ProductVariant;
use App\Models\ProductVariantOptions;
use App\Models\ProductVariantsOption;
use App\Models\ProductVariations;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Str;

class ProductService
{
    private $imageService;

    /**
     * @var $model Product
     */
    private $model;

    public function __construct(ImageService $imageService)
    {

        $this->imageService = $imageService;
        $this->model = new Product();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function save($request)
    {
        \DB::beginTransaction();
        if (! empty($request->product_id)) {
            $product = Product::find($request->product_id);
        }else{
            $product = new Product();
        }

        $product->business_id = \Auth::user()->business_id;
        $product->title = $request->title;
        $product->slug = isset($request->slug) ? $request->slug : Str::slug(strtolower($request->title));
        $product->description = $request->description;
        $product->brand_id = $request->brand_id;
        $product->cost_price = isset($request->cost_price) ? $request->cost_price : 0;
        $product->retail_price = $request->retail_price;
        $product->discounted_price = $request->discounted_price;
        $product->barcode = $request->barcode;
        $product->sku = $request->sku;
        $product->weight = $request->weight;
        $product->volume = $request->volume;
        $product->has_addons_or_variants = isset($request->has_addons_or_variants) ? $request->has_addons_or_variants : 0;
        $product->product_type = \Auth::user()->business->business_type_id;
        $product->save();

        if ($request->has('stores')) {
            $this->productStores($request->stores, $product->id);
        }

        if ($request->has('categories')) {
            $this->productCategories($request->categories, $product->id);
        }

        if ($request->file('images')) {
            if (!empty($request->images['main'])){
                $image = Image::whereImageableId($product->id)
                    ->whereImageableType(Product::class)
                    ->where('key','=','main');
                if ($image->first()) {
                    if (File::exists(public_path('thumbnails/product/' . $image->first()->title))) {
                        unlink(public_path('thumbnails/product/' . $image->first()->title));
                    }
                    $image->delete();
                }
            }
            if (!empty($request->images)){
                $keys = array_keys($request->images);
                $images = Image::whereImageableId($product->id)
                    ->whereImageableType(Product::class)
                    ->whereIn('key', $keys)->get();

                foreach ($images as $image) {
                    if ($image) {
                        if (File::exists(public_path('thumbnails/product/' . $image->title))) {
                            unlink(public_path('thumbnails/product/' . $image->title));
                        }
                        $image->delete();
                    }
                }
            }
            $this->imageService->saveImage($request, $product->id, Product::class, 'products', 352, 398);
        }

        $this->saveProductVariant($request, $product->id);

        $this->saveAddons($request, $product->id);

        \DB::commit();
    }

    public function saveAddons($request, $product_id){
        ProductAddons::whereProductId($product_id)->delete();
        if (!empty($request->addon)) {
            if ($request->has_addons_or_variants == 1) {
                foreach ($request->addon as $item) {
                    $addon = new ProductAddons();
                    $addon->product_id = $product_id;
                    $addon->addon_id = $item;
                    $addon->save();
                }
            }
        }
    }

    public function productStores($stores, $product_id)
    {
        ProductStores::whereProductId($product_id)->delete();
        foreach ($stores as $store) {
            $productStore = new ProductStores();
            $productStore->product_id = $product_id;
            $productStore->store_id = $store;
            $productStore->save();
        }
    }

    public function productCategories($categories, $product_id)
    {
        ProductCategories::whereProductId($product_id)->delete();
        foreach ($categories as $category) {
            $productCategory = new ProductCategories();
            $productCategory->product_id = $product_id;
            $productCategory->category_id = $category;
            $productCategory->save();
        }
    }

    public function search($params)
    {
        $product = Product::whereBusinessId(\Auth::user()->business_id)
            ->whereProductType(\Auth::user()->business->business_type_id)
            ->whereNull('deleted_at');

        if (!empty($params['sum'])) {
            return $product->sum($params['field']);
        }

        if (!empty($params['status'])) {
            $product = $product->whereIsActive($params['status']);
        }

        if (!empty($params['count'])) {
            return $product->count('id');
        }

        if (url()->current() == route('products-list-inactive') || !empty($params['inactive'])) {
            $product = $product->whereIsActive(IStatus::DISABLE);
        }

        if (url()->current() == route('products-list-discounted') || !empty($params['discounted'])) {
            $product = $product->where('discounted_price','>',0);
        }

        if (!empty($params['categories'])) {
            $product = $product->whereHas('categories', function ($q) use ($params){
               $q->whereIn('category_id', $params['categories']);
            });
        }

        if (!empty($params['stores'])) {
            $product = $product->whereHas('stores', function ($q) use ($params){
                $q->whereIn('store_id', $params['stores']);
            });
        }

        if (!empty($params['brands'])) {
            $product = $product->whereIn('brand_id', $params['stores']);
        }

        if (!empty($params['paginate'])) {
            return $product->orderBy('id', 'desc')->paginate(AppConstants::PAGINATE_LARGE);
        }
        return $product->get();
    }

    private function saveProductVariant($request, $product_id)
    {
        if (ProductVariations::whereProductId($product_id)->count()>0){
            if (!empty($request->variant)){
                foreach ($request->variantList as $list){
                    $variants = ProductVariant::whereProductId($product_id)->whereVariant($list)->first();
                    if ($variants){
                        $options = explode(',', Arr::first($list['options']));
                        foreach ($options as $option){
                            if (!ProductVariantsOption::whereVariantId($variants->id)->whereOption($option)->first()){
                                $productVariantOptions = new ProductVariantsOption();
                                $productVariantOptions->variant_id = $variants->id;
                                $productVariantOptions->option = $option;
                                $productVariantOptions->save();
                            }
                        }
                    }else {
                        foreach ($request->variantList as $item) {
                            $productVariant = new ProductVariant();
                            $productVariant->product_id = $product_id;
                            $productVariant->variant = $item['name'];
                            $productVariant->save();

                            $options = explode(',', Arr::first($item['options']));
                            foreach ($options as $option) {
                                $productVariantOptions = new ProductVariantsOption();
                                $productVariantOptions->variant_id = $productVariant->id;
                                $productVariantOptions->option = $option;
                                $productVariantOptions->save();
                            }
                        }
                    }
                }

                $variantsIds = ProductVariant::whereProductId($product_id)->pluck('id')->toArray();
                $options = ProductVariantsOption::whereIn('variant_id', $variantsIds)->get();
                $list = [];
                foreach ($options as $option){
                    $list[$option->variant_id][] = $option->option;
                }

                $newCombinations = ArrayHelper::combinations(array_values($list));

                $variants = $request->variant;

                foreach ($newCombinations as $combination){
                    if (is_array($combination)){
                        $formattedCombination = join('/', $combination);
                    }else{
                        $formattedCombination = $combination;
                    }
                    $productVariation = ProductVariations::where('title','like', '%'.$formattedCombination.'%')->whereProductId($product_id)->first();

                    $productVariationList = ProductVariations::whereProductId($product_id)->pluck('title', 'id')->toArray();
                    foreach ($productVariationList as $key => $item){

                        if (Str::contains($formattedCombination, $item)) {

                            $productVariation = ProductVariations::find($key);
                            $productVariation->title = $formattedCombination;
                            $productVariation->save();

                            $options = explode('/', $formattedCombination);
                            foreach ($options as $option) {
                                $variantOption = ProductVariantsOption::whereOption($option)->latest()->first();

                                if(!ProductVariantOptions::whereProductVariantId($productVariation->id)->whereVariantOptionId($variantOption->id)->first()) {
                                    $productVariantOption = new ProductVariantOptions();
                                    $productVariantOption->product_variant_id = $productVariation->id;
                                    $productVariantOption->variant_option_id = $variantOption->id;
                                    $productVariantOption->save();
                                }
                            }

                        }
                    }


                    if (!$productVariation){

                        $variant = Arr::first($variants);

                        $productVariation = new ProductVariations();
                        $productVariation->product_id = $product_id;
                        $productVariation->title = $formattedCombination;
                        $productVariation->cost_price = isset($variant['cost_price']) ? $variant['cost_price'] : 0;
                        $productVariation->retail_price = isset($variant['retail_price']) ? $variant['retail_price'] : 0;
                        $productVariation->discounted_price = isset($variant['discounted_price']) ? $variant['discounted_price'] : 0;
                        $productVariation->barcode = isset($variant['barcode']) ? $variant['barcode'] : null;
                        $productVariation->sku = isset($variant['sku']) ? $variant['sku'] : null;
                        $productVariation->is_active = isset($variant['is_active']) ? $variant['is_active'] : 0;
                        $productVariation->save();

                        if (!empty($variant['image'])) {
                            Image::whereImageableId($productVariation->id)->whereImageableType(ProductVariations::class)->delete();
                            $this->imageService->saveImageObj($variant['image'], 'variant', $productVariation->id,
                                ProductVariations::class, 'product', 352, 398);
                        }

                        $options = explode('/', $variant['options']);
                        foreach ($options as $option) {
                            $variantOption = ProductVariantsOption::whereOption($option)->latest()->first();

                            $productVariantOption = new ProductVariantOptions();
                            $productVariantOption->product_variant_id = $productVariation->id;
                            $productVariantOption->variant_option_id = $variantOption->id;
                            $productVariantOption->save();
                        }
                    }
                }
            }

        }else {
            if (is_array($request->variant) && count($request->variant) > 0) {
                foreach ($request->variantList as $item) {
                    $productVariant = new ProductVariant();
                    $productVariant->product_id = $product_id;
                    $productVariant->variant = $item['name'];
                    $productVariant->save();

                    $options = explode(',', Arr::first($item['options']));
                    foreach ($options as $option) {
                        $productVariantOptions = new ProductVariantsOption();
                        $productVariantOptions->variant_id = $productVariant->id;
                        $productVariantOptions->option = $option;
                        $productVariantOptions->save();
                    }
                }
            }
            if (is_array($request->variant)) {
                foreach ($request->variant as $variant) {
                    $productVariation = new ProductVariations();
                    $productVariation->product_id = $product_id;
                    $productVariation->title = $variant['options'];
                    $productVariation->cost_price = isset($variant['cost_price']) ? $variant['cost_price'] : 0;
                    $productVariation->retail_price = isset($variant['retail_price']) ? $variant['retail_price'] : 0;
                    $productVariation->discounted_price = isset($variant['discounted_price']) ? $variant['discounted_price'] : 0;
                    $productVariation->barcode = isset($variant['barcode']) ? $variant['barcode'] : null;
                    $productVariation->sku = isset($variant['sku']) ? $variant['sku'] : null;
                    $productVariation->is_active = isset($variant['is_active']) ? $variant['is_active'] : 0;
                    $productVariation->save();

                    if (!empty($variant['image'])) {
                        Image::whereImageableId($productVariation->id)->whereImageableType(ProductVariations::class)->delete();
                        $this->imageService->saveImageObj($variant['image'], 'variant', $productVariation->id,
                            ProductVariations::class, 'product', 352, 398);
                    }

                    $options = explode('/', $variant['options']);
                    foreach ($options as $option) {
                        $variantOption = ProductVariantsOption::whereOption($option)->latest()->first();

                        $productVariantOption = new ProductVariantOptions();
                        $productVariantOption->product_variant_id = $productVariation->id;
                        $productVariantOption->variant_option_id = $variantOption->id;
                        $productVariantOption->save();
                    }

                }
            }
        }
    }

    public function imageUpload(Request $request)
    {
        $product = null;
        if (! empty($request->product_id)) {
            $product = Product::find($request->product_id);
        }
        if ($product) {
            if ($request->file('images')) {
                if (!empty($request->images['main'])) {
                    $image = Image::whereImageableId($product->id)
                        ->whereImageableType(Product::class)
                        ->where('key', '=', 'main');
                    if ($image->first()) {
                        if (File::exists(storage_path('thumbs/product/' . $image->first()->title))) {
                            unlink(public_path('thumbnails/product/' . $image->first()->title));
                        }
                        $image->delete();
                    }
                }
                if (!empty($request->images)) {
                    $keys = array_keys($request->images);
                    $images = Image::whereImageableId($product->id)
                        ->whereImageableType(Product::class)
                        ->whereIn('key', $keys)->get();

                    foreach ($images as $image) {
                        if ($image) {
                            if (File::exists(public_path('thumbnails/product/' . $image->title))) {
                                unlink(public_path('thumbnails/product/' . $image->title));
                            }
                            $image->delete();
                        }
                    }
                }
                $this->imageService->saveImage($request, $product->id, Product::class, 'products', 352, 398);
            }
        }
        return $product;
    }


    public function variantImageUpload(Request $request)
    {
        $variant = null;
        if (! empty($request->variant)) {
            $variant = ProductVariations::find($request->variant);
        }
        if ($variant) {
            if ($request->file('images')) {
                if (!empty($request->images)) {
                    $keys = array_keys($request->images);
                    $images = Image::whereImageableId($variant->id)
                        ->whereImageableType(ProductVariations::class)
                        ->whereIn('key', $keys)->get();

                    foreach ($images as $image) {
                        if ($image) {
                            if (File::exists(public_path('thumbnails/variants/' . $image->title))) {
                                unlink(public_path('thumbnails/variants/' . $image->title));
                            }
                            $image->delete();
                        }
                    }
                }
                $this->imageService->saveImage($request, $variant->id, ProductVariations::class, 'variants', 352, 398);
            }
        }
        return $variant;
    }

}
