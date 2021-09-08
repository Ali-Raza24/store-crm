<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Exports\ProductExport;
use App\Helpers\ArrayHelper;
use App\Helpers\CommonHelper;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductsImport;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Plan;
use App\Models\PlanOptions;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantOptions;
use App\Models\ProductVariantsOption;
use App\Models\ProductVariations;
use App\Models\Store;
use App\Models\Variant;
use App\Models\VariantOptions;
use App\Rules\AlphaNumericHyphen;
use App\Services\ProductService;
use Arr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
//        parent::__construct('product');
        $this->middleware('permission:product-list');
        $this->middleware('permission:product-edit')->only(['edit','store','create']);
        $this->middleware('permission:product-delete')->only(['destroy']);
        $this->middleware('permission:product-status')->only(['status']);
        $this->middleware('permission:product-bulk-status')->only(['bulkStatus']);
        $this->middleware('permission:product-bulk-delete')->only(['bulkDelete']);
    }

    public function index(Request $request)
    {
        $plan = Plan::find(Auth::user()->business->plan_id);
        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS)->first();
        if (empty($planOption)){
            $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_PRODUCTS)->first();
        }

        $productCount = $this->productService->search(['count' => true]);

        $discountCount = $this->productService->search(['sum' => true, 'field' => 'discounted_price']);
        $totalAmount = $this->productService->search(['sum' => true, 'field' => 'retail_price']);
        $totalBrands = Brand::activeBusiness()->count('id');
        $products = $this->productService->search(array_merge($request->all(), ['paginate' => true]));
        return view('business.products.list', compact('products', 'discountCount', 'totalAmount', 'totalBrands', 'productCount', 'planOption'));
    }

    public function create(Request $request)
    {
        $plan = Plan::find(Auth::user()->business->plan_id);

        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS)->first();
        if (empty($planOption)){
            $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_PRODUCTS)->first();
        }

        $productCount = $this->productService->search(['count' => true]);

        if (!empty($planOption) && ($planOption->option == AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS || $planOption->values <=  $productCount)) {
            flash('You have reached to your maximum products limit. Please upgrade your subscription to continue!')->error();
        }
        return redirect()->route('products-list');
    }

    public function store(ProductRequest $request)
    {
        $this->productService->save($request);
        if ($request->product_id) {
            flash('Product updated successfully')->success()->important();
        } else {
            flash('Product added successfully')->success()->important();
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        $product = $this->productService->findById($id);
        if ($product) {
            $singleProduct = /*optional($product->variants()->with([
                'productVariantOptions' => function ($q) {
                    $q->with(['options']);
                }
            ])->get())->toArray();*/[];

            $variantIds = [];
            if ($singleProduct) {
                foreach ($singleProduct as $item) {
                    foreach ($item['product_variant_options'] as $option) {
                        $variantIds[] = $option['options']['variant_id'];
                    }
                }
            }
            $variantIds = array_unique($variantIds);

            $variants = Variant::whereIn('id', $variantIds)->pluck('name', 'id');
            $variantList = [];
            $i = 0;
            foreach ($variants as $key => $variant) {
                $variantList[$i]['name'] = $variant;
                $variantList[$i]['options'] = VariantOptions::whereVariantId($key)->get()->pluck('option')->toArray();
                $i++;
            }

            return view('business.products.edit', compact('product', 'variantList'));
        }
        abort(404);
    }

    public function status(Request $request)
    {
        $plan = Plan::find(Auth::user()->business->plan_id);
        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS)->first();
        if (empty($planOption)){
            $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_PRODUCTS)->first();
        }
        $productCount = $this->productService->search(['count' => true, 'status' => IStatus::ACTIVE]);

        $status = $request->status_id;

        if (!empty($planOption->values) && ($planOption->values == AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS || $planOption->values > $productCount) || $status == IStatus::DISABLE){
            $id = $request->product_id;
            $product = Product::find($id);

            if ($product) {
                $product->is_active = $status;
                $product->save();
            }
            if ($status == IStatus::ACTIVE) {
                flash('Product status activated successfully')->success()->important();
            } else {
                flash('Product status inactivated successfully')->success()->important();
            }
        }else{
            flash('Cannot active this product. You have reached to your maximum products limit. Please upgrade your subscription to continue! ')->error()->important();
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $id = $request->product_id;
        $status = $request->status_id;
        $product = Product::find($id);

        if ($product) {
            $product->deleted_at = Carbon::now();
            $product->save();
        }

        flash('Product deleted successfully')->success()->important();
        return redirect()->route('products-list');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->product_id;
        $productIds = explode(',', $ids);
        foreach ($productIds as $id) {
            $product = Product::find($id);
            if ($product) {
                $product->deleted_at = Carbon::now();
                $product->save();
            }
        }
        flash('Products deleted successfully')->success()->important();
        return redirect()->route('products-list');
    }

    public function bulkStatus(Request $request)
    {
        $ids = $request->product_id;
        $productIds = explode(',', $ids);
        $status = $request->status_id;

        $plan = Plan::find(Auth::user()->business->plan_id);
        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS)->first();
        if (empty($planOption)){
            $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_PRODUCTS)->first();
        }
        $productCount = $this->productService->search(['count' => true, 'status' => IStatus::ACTIVE]);

        if (!empty($planOption->values) && ($planOption->values == AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS || $planOption->values > $productCount) || $status == IStatus::DISABLE){
            $allowedProducts = $planOption->values - $productCount;
            if (count($productIds) > $allowedProducts && $status == IStatus::ACTIVE) {
                flash('Cannot activate these product(s). You can mark only '.($planOption->values - $productCount).' Products. Please upgrade your subscription to activate more products! ')->error()->important();
                return redirect()->back();
            }
            foreach ($productIds as $id) {
                $product = Product::find($id);

                if ($product) {
                    $product->is_active = $status;
                    $product->save();
                }
            }
            if ($status == IStatus::ACTIVE) {
                flash('Product status activated successfully')->success()->important();
            } else {
                flash('Product status inactivated successfully')->success()->important();
            }
        }else{
            flash('Cannot active these product. You have reached to your maximum products limit. Please upgrade your subscription to continue! ')->error()->important();
        }
        return redirect()->back();
    }

    public function categories(Request $request)
    {
        $product = $this->productService->findById($request->product_id);
        return response()->json([
            'image' => isset($product->main_image) ? $product->main_image : asset('img/camera_icon.png'),
            'price' => $product->retail_price,
            'discount' => $product->discounted_price,
            'categories' => $product->categories()->get(['title', 'category_id'])->toArray()
        ]);
    }

    public function updateVariant(Request $request)
    {

        $rules = [
            'variant.cost_price' => ['required', 'numeric'],
            'variant.retail_price' => ['required', 'numeric'],
            'variant.discounted_price' => ['nullable', 'numeric'],
            'variant.barcode' => [
                'nullable',
                new AlphaNumericHyphen(),
                'max:40',
            ],
            'variant.sku' => [
                'nullable',
                new AlphaNumericHyphen(),
                'max:40',
            ]
        ];
        $customRule = [];
        $existingBarcode = ProductVariations::whereHas('product', function ($q){
            $q->whereBusinessId(\Auth::user()->business_id);
        })->whereBarcode($request->variant['barcode'])
            ->where('id', '!=', $request->variant['variant_id'])->first();

        if ($existingBarcode && $existingBarcode->barcode) {
            $customRule['variant.barcode'] = [
                Rule::unique((new ProductVariations())->getTable(), 'barcode')
            ];
        }

        $existingSku = ProductVariations::whereHas('product', function ($q){
            $q->whereBusinessId(\Auth::user()->business_id);
        })->whereBarcode($request->variant['sku'])
            ->where('id', '!=', $request->variant['variant_id'])->first();
        if ($existingSku && $existingSku->sku) {
            $customRule['variant.sku'] = [
                Rule::unique((new ProductVariations())->getTable(), 'sku')
            ];
        }

        $rules = array_merge($rules, $customRule);
        session()->put('variant-validation', true);
        if ($request->validate($rules)){
            $productVariation = ProductVariations::find($request->variant['variant_id']);

            if ($productVariation){
                $productVariation->cost_price = $request->variant['cost_price'];
                $productVariation->retail_price = $request->variant['retail_price'];
                $productVariation->discounted_price = isset($request->variant['discounted_price']) ? $request->variant['discounted_price'] : 0;
                $productVariation->barcode = $request->variant['barcode'];
                $productVariation->sku = $request->variant['sku'];
                $productVariation->save();

                flash('Variant updated successfully')->success();
                return redirect()->route('products-edit', $productVariation->product_id);
            }
            flash('No record found')->error();
        }
        return redirect()->back();
    }

    public function deleteVariant(Request $request){
        $productVariation = ProductVariations::find($request->variant_id);
        if ($productVariation){
            try {
                DB::beginTransaction();
                $productVariantsOptions = ProductVariantOptions::where(['product_variant_id' => $productVariation->id])->get();

                ProductVariantOptions::where(['product_variant_id' => $productVariation->id])->delete();
                ProductVariantsOption::whereDoesntHave('options')->delete();
                ProductVariant::whereProductId($productVariation->product_id)->whereDoesntHave('variantOptions')->delete();
                Image::whereImageableType(ProductVariations::class)->whereImageableId($productVariation->id)->delete();
                ProductVariations::find($request->variant_id)->delete();
                DB::commit();
            }catch (\Exception $exception){
                DB::rollBack();
            }

            flash('Variant deleted successfully')->success();
            return redirect()->back();
        }
        flash('Error while deleting variant')->error();
        return redirect()->back();
    }

    public function uploadImage(Request $request)
    {
        $rule=[];

        if (!empty($request->file('images'))) {
            $rule = ['images.*' => [Rule::dimensions()->minHeight(400)->minWidth(360)]];
        }

        $validator = Validator::make($request->all(), $rule, [
            'images.*.dimensions' => 'Min image dimensions are 360(w) X 400(h)',
        ]);

        $messages = $validator->getMessageBag()->toArray();
        if (\Arr::has($messages, 'images.0')){
            return response()->json(['error' => \Arr::first($messages['images.0'])],422);
        }
        $file = $request->all();

        $key = array_keys($file['images']);

        $key = \Arr::first($key);

        $product = $this->productService->imageUpload($request);

        if ($product){
            $image = CommonHelper::getImage($product->id, Product::class, $key);
            return response()->json(['status' => 'OK', 'url' => $image ]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error uploading image']);
        }
    }

    public function deleteImage(Request $request)
    {
        $image_id = $request->image_id;

        $image = Image::find($image_id);

        if ($image){
            if (\Storage::disk('s3')->exists('products/'.$image->title)){
                \Storage::disk('s3')->delete('products/'.$image->title);
            }
            if (\Storage::disk('s3')->exists('thumbs/products/'.$image->title)){
                \Storage::disk('s3')->delete('thumbs/products/'.$image->title);
            }
            $image->delete();

            if ($request->ajax()){
                return response()->json(['status' => false, 'message' => 'Image deleted successfully']);
            }
            flash('Image deleted successfully')->success();
            return redirect()->back();
        }
        if ($request->ajax()){
            return response()->json(['status' => false, 'message' => 'Error deleting image']);
        }
        flash('Error deleting image')->error();
        return redirect()->back();
    }

    public function validateImage(ProductImagesRequest $request)
    {
        $key = '';
        if (!empty($request->images['main'])){
            $key = 'images-main';
        }
        if (!empty($request->images['1'])){
            $key = 'images-1';
        }
        if (!empty($request->images['2'])){
            $key = 'images-2';
        }
        if (!empty($request->images['3'])){
            $key = 'images-3';
        }
        return response()->json(['status' => true, 'message' => 'Validate' ,'key' => $key]);
    }

    public function uploadVariantImages(Request $request)
    {
        $rule=[];

        if (!empty($request->file('images'))) {
            $rule = ['images.*' => [Rule::dimensions()->minHeight(400)->minWidth(360)]];
        }

        $validator = Validator::make($request->all(), $rule, [
            'images.*.dimensions' => 'Min image dimensions are 360(w) X 400(h)',
        ]);

        $messages = $validator->getMessageBag()->toArray();
        if (\Arr::has($messages, 'images')){
            return response()->json(['error' => \Arr::first($messages['images'])],422);
        }
        $file = $request->all();

        $key = array_keys($file['images']);

        $key = \Arr::first($key);

        $variant = $this->productService->variantImageUpload($request);

        if ($variant){
            $image = CommonHelper::getImage($variant->id, ProductVariations::class, $key);
            return response()->json(['status' => 'OK', 'url' => $image ]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error uploading image']);
        }
    }

    public function export(Excel $excel, ProductExport $productExport)
    {
        $filename = 'products_'.date('YmdHis').'.csv';
        $excel->store($productExport, $filename, 'public');
        return \redirect(asset('storage/'.$filename));
    }

    public function import(Excel $excel, ProductsImport $productsImport, Request $request)
    {
        \request()->request->add(['extension' => strtolower($request->file('products')->getClientOriginalExtension())]);
        $validator = Validator::make($request->all(), ['products' => ['required', 'file'], 'extension' => ['in:csv,xls,xlsx']], ['products.required' => 'The file field is required', 'extension.in' => 'The file must be a file of type: xlsx, csv, xls.']);
        if ($validator->fails()){
            if (Arr::first($validator->getMessageBag()->get('products'))){
                flash(Arr::first($validator->getMessageBag()->get('products')))->error()->important();
            }
            if (Arr::first($validator->getMessageBag()->get('extension'))){
                flash(Arr::first($validator->getMessageBag()->get('extension')))->error()->important();
            }

            return redirect()->back();
        }
        try {
            $excel->import($productsImport, $request->file('products'));
        } catch (ValidationException $exception){
            flash(Arr::first(Arr::first($exception->errors())).'. Products not imported')->error()->important();
            return redirect()->back();
        }
        flash('Products imported successfully')->success();

        return redirect()->route('products-list');
    }
}
