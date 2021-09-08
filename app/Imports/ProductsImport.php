<?php

namespace App\Imports;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Plan;
use App\Models\PlanOptions;
use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\ProductStores;
use App\Services\ProductService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\RowValidator;

class ProductsImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $productService;

    public function collection(Collection $collection)
    {
        $this->productService = app(ProductService::class);
        $plan = Plan::find(Auth::user()->business->plan_id);
        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS)->first();
        if (empty($planOption)){
            $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_PRODUCTS)->first();
        }

        /**
         * @var $item Product
         */
        foreach ($collection as $item) {
            $product = Product::whereTitle($item['title'])->whereBusinessId(Auth::user()->business_id)->whereNull('deleted_at')->first();
            if ($product){
                $product->title = $item['title'];
                $product->slug = isset($item['slug']) ? $item['slug'] : \Str::slug($item['title']);
                $product->business_id = Auth::user()->business_id;
                $product->description = isset($item['description']) ? $item['description'] : '';
                $product->cost_price = isset($item['cost_price']) ? $item['cost_price'] : 0;
                $product->retail_price = isset($item['retail_price']) ? $item['retail_price'] : 0;
                $product->barcode = isset($item['barcode']) ? $item['barcode'] : '';
                $product->sku = isset($item['sku']) ? $item['sku'] : '';
                $product->weight = isset($item['weight']) ? $item['weight'] : 0;
                $product->volume = isset($item['volume']) ? $item['volume'] : 0;
                $product->product_type = $item['business_type'] == 'retail' ? 2 : 1;

                $brand = Brand::whereBusinessId(Auth::user()->business_id)->whereTitle($item['brand'])->whereNull('deleted_at')->first();
                if ($brand) {
                    $brand_id = $brand->id;
                } else {
                    $brand = new Brand();
                    $brand->business_id = Auth::user()->business_id;
                    $brand->is_active = IStatus::ACTIVE;
                    $brand->title = $item['brand'];
                    $brand->save();
                    $brand_id = $brand->id;
                }
                $product->brand_id = $brand_id;
                $product->save();

                $categories = explode(',', $item['categories']);
                foreach ($categories as $category){
                    $existCat = Category::whereBusinessId(Auth::user()->business_id)->whereTitle($category)->whereNull('deleted_at')->first();
                    if ($existCat) {
                        $existCatId = $existCat->id;
                        if (!ProductCategories::whereProductId($product->id)->whereCategoryId($existCatId)->first()) {
                            $productCategory = new ProductCategories();
                            $productCategory->category_id = $existCatId;
                            $productCategory->product_id = $product->id;
                            $productCategory->save();
                        }
                    } else {
                        $newCat = new Category();
                        $newCat->business_id = Auth::user()->business_id;
                        $newCat->is_active = IStatus::ACTIVE;
                        $newCat->title = $category;
                        $newCat->save();
                        $existCatId = $newCat->id;

                        if (!ProductCategories::whereProductId($product->id)->whereCategoryId($existCatId)->first()) {
                            $productCategory = new ProductCategories();
                            $productCategory->category_id = $existCatId;
                            $productCategory->product_id = $product->id;
                            $productCategory->save();
                        }

                    }
                }

                $store = session()->get('store-data');
                if (!ProductStores::whereProductId($product->id)->whereStoreId(isset($store['id']) ? $store['id'] : $store->id)->first()){
                    $productStore = new ProductStores();
                    $productStore->store_id = isset($store['id']) ? $store['id'] : $store->id;
                    $productStore->product_id = $product->id;
                    $productStore->save();
                }

            }else {
                $productCount = $this->productService->search(['count' => true]);
                if (!empty($planOption) && ($planOption->option == \App\Constants\AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS || $planOption->values >= $productCount)) {
                    $product = new Product();
                    $product->title = $item['title'];
                    $product->business_id = Auth::user()->business_id;
                    $product->slug = isset($item['slug']) ? $item['slug'] : \Str::slug($item['title']);
                    $product->description = isset($item['description']) ? $item['description'] : null;
                    $product->cost_price = isset($item['cost_price']) ? $item['cost_price'] : 0;
                    $product->retail_price = isset($item['retail_price']) ? $item['retail_price'] : 0;
                    $product->barcode = isset($item['barcode']) ? $item['barcode'] : '';
                    $product->sku = isset($item['sku']) ? $item['sku'] : '';
                    $product->weight = isset($item['weight']) ? $item['weight'] : 0;
                    $product->volume = isset($item['volume']) ? $item['volume'] : 0;
                    $product->product_type = $item['business_type'] == 'retail' ? 2 : 1;

                    $brand = Brand::whereBusinessId(Auth::user()->business_id)->whereTitle($item['brand'])->whereNull('deleted_at')->first();

                    if ($brand) {
                        $brand_id = $brand->id;
                    } else {
                        $brand = new Brand();
                        $brand->business_id = Auth::user()->business_id;
                        $brand->is_active = IStatus::ACTIVE;
                        $brand->title = $item['brand'];
                        $brand->save();
                        $brand_id = $brand->id;
                    }
                    $product->brand_id = $brand_id;
                    $product->save();
                    $categories = explode(',', $item['categories']);
                    foreach ($categories as $category) {
                        $existCat = Category::whereBusinessId(Auth::user()->business_id)->whereTitle($category)->whereNull('deleted_at')->first();
                        if ($existCat) {
                            $existCatId = $existCat->id;

                            $productCategory = new ProductCategories();
                            $productCategory->category_id = $existCatId;
                            $productCategory->product_id = $product->id;
                            $productCategory->save();

                        } else {
                            $newCat = new Category();
                            $newCat->business_id = Auth::user()->business_id;
                            $newCat->is_active = IStatus::ACTIVE;
                            $newCat->title = $category;
                            $newCat->save();
                            $existCatId = $newCat->id;
                            $productCategory = new ProductCategories();
                            $productCategory->category_id = $existCatId;
                            $productCategory->product_id = $product->id;
                            $productCategory->save();
                        }
                    }

                    $store = session()->get('store-data');
                    $productStore = new ProductStores();
                    $productStore->store_id = isset($store['id']) ? $store['id'] : $store->id;
                    $productStore->product_id = $product->id;
                    $productStore->save();
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'brand' => 'required',
            'cost_price' => 'required',
            'retail_price' => 'required',
            'categories' => 'required',
            'business_type' => 'required'
        ];
    }
}
