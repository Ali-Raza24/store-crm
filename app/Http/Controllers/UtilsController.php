<?php

namespace App\Http\Controllers;

use App\Constants\IStatus;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Brand;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\Category;
use App\Models\Country;
use App\Models\Customer;
use App\Models\DeliveryCompany;
use App\Models\Image;
use App\Models\Industry;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\State;
use App\Models\Store;
use App\Models\User;
use App\Models\VariantOptions;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UtilsController extends ApiBaseController
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function getBusinessTypes(Request $request)
    {
        $businessTypes = BusinessType::active()->pluck('title','id');
        return $this->sendSuccess('Success', $businessTypes);
    }

    public function industries()
    {
        $industries = Industry::all()->pluck('title', 'id');
        return $this->sendSuccess('Success', $industries);
    }

    public function countries()
    {
        $countries = Country::whereCode('AE')->get()->pluck('name', 'id');
        return $this->sendSuccess('Success', $countries);
    }

    public function states()
    {
        $countries = State::whereCountryCode('AE')->get()->pluck('name', 'id');
        return $this->sendSuccess('Success', $countries);
    }

    public function statesList()
    {
        $countries = State::whereCountryCode('AE')->get();
        return $this->sendSuccess('Success', $countries);
    }

    public function deliveryCompanies(Request $request)
    {
        return $this->sendSuccess('Success', DeliveryCompany::whereIsActive(IStatus::ACTIVE)->get()->pluck('title','id'));
    }

    public function getAddons()
    {
        return $this->sendSuccess('success', CommonHelper::addons());
    }

    public function getVariants()
    {
        return $this->sendSuccess('success', CommonHelper::variants());
    }

    public function getVariantOptions(Request $request, $id)
    {
        $options = [];
        $variantOptions = VariantOptions::select([
            'option as text',
            'id'
        ])->whereVariantId($id)->get(['text', 'id']);
        foreach ($variantOptions as $option){
            $options[] = ['id' => $option['text'], 'text' => $option['text']];
        }
        return $this->sendSuccess('OK', $options);
    }

    public function notifications()
    {
        return $this->sendSuccess('Notifications', Auth::user()->notifications()->whereNull('deleted_at')->get(['id', 'type', 'data', 'read_at', 'created_at']));
    }

    public function notificationRead(Request $request, $id)
    {
        $notification = Notification::find($id);
        if ($notification){
            $notification->read_at = Carbon::now();
            $notification->save();
        }

        return $this->sendSuccess('Notification marked as read', []);
    }

    public function notificationDelete(Request $request, $id)
    {
        $notification = Notification::find($id);
        if ($notification){
            $notification->deleted_at = Carbon::now();
            if (empty($notification->read_at)) {
                $notification->read_at = Carbon::now();
            }
            $notification->save();
        }

        return $this->sendSuccess('Notification deleted successfully', []);
    }

    public function search(Request $request)
    {
        $data = [];
        $search = $request->term;
        if (!empty($search)){
            if (!empty(Auth::user()->business_id)) {
                /*$data[] = ['header' => 'Products'];*/

                if (plan_has_permission(['product-list', 'product-edit'])) {
                    $products = Product::selectRaw('title as name, id')->whereBusinessId(Auth::user()->business_id)->where('title',
                        'like', '%' . $search . '%')->latest()->take(5)->get();
                    foreach ($products as $product) {
                        $data[] = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'group' => 'Product',
                            'url' => route('products-edit', $product->id)
                        ];
                    }
                }

                /*$data[] = ['divider' => 'true'];
                $data[] = ['header' => 'Customers'];*/
                if (plan_has_permission(['customer-list', 'customer-view'])) {
                    $customers = Customer::whereBusinessId(Auth::user()->business_id)
                        ->selectRaw('concat(name, ", ",email,", ",phone, ", ",mobile) as name, id')
                        ->where(function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%')
                                ->orWhere('phone', 'like', '%' . $search . '%')
                                ->orWhere('mobile', 'like', '%' . $search . '%');
                        })
                        ->latest()->take(5)->get();
                    foreach ($customers as $customer) {
                        $data[] = [
                            'id' => $customer->id,
                            'name' => $customer->name,
                            'group' => 'Customer',
                            'url' => route('customers-detail', $customer->id)
                        ];
                    }
                }
                /*$data[] = ['divider' => 'true'];
                $data[] = ['header' => 'Stores'];*/
                $stores = Store::whereBusinessId(Auth::user()->business_id)->where('name', 'like',
                    '%' . $search . '%')->latest()->take(5)->get();
                foreach ($stores as $store) {
                    $data[] = [
                        'id' => $store->id,
                        'name' => $store->name,
                        'group' => 'Store',
                        'url' => route('change-store', ['name' => $store->slug, 'toSetting' => true])
                    ];
                }

                $brands = Brand::whereBusinessId(Auth::user()->business_id)->where('title', 'like',
                    '%' . $search . '%')->latest()->take(5)->get();
                foreach ($brands as $brand) {
                    $data[] = [
                        'id' => $brand->id,
                        'name' => $brand->title,
                        'group' => 'Brand',
                        'url' => route('product-setting')
                    ];
                }

                $categories = Category::whereBusinessId(Auth::user()->business_id)->where('title', 'like',
                    '%' . $search . '%')->latest()->take(5)->get();
                foreach ($categories as $category) {
                    $data[] = [
                        'id' => $category->id,
                        'name' => $category->title,
                        'group' => 'Category',
                        'url' => route('product-setting')
                    ];
                }

                if (plan_has_permission(['order-list', 'order-view'])) {
                    $orders = Order::whereBusinessId(Auth::user()->business_id)->where('formatted_number', 'like',
                        '%' . $search . '%')->latest()->take(5)->get();
                    foreach ($orders as $order) {
                        $data[] = [
                            'id' => $order->formatted_number,
                            'name' => $order->formatted_number,
                            'group' => 'Order',
                            'url' => route('orders-detail', $order->formatted_number)
                        ];
                    }
                }
            }else {
                $orders = Order::where('formatted_number', 'like', '%' . $search . '%')->latest()->take(5)->get();
                $data = [];
                foreach ($orders as $order) {
                    $data[] = [
                        'id' => $order->formatted_number,
                        'name' => $order->formatted_number,
                        'group' => 'Order',
                        'url' => route('admin-orders-detail', $order->formatted_number)
                    ];
                }

                $businesses = Business::where('name', 'like', '%' . $search . '%')
                    ->selectRaw('concat(name, ", ",email,", ",phone, ", ",mobile) as name, id')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('mobile', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->latest()->take(5)->get();
                foreach ($businesses as $business) {
                    $data[] = [
                        'id' => $business->id,
                        'name' => $business->name,
                        'group' => 'Business',
                        'url' => route('admin-business-detail', ['id' => $business->id])
                    ];
                }

            }

            return $this->sendSuccess('Successfully fetched', $data);
        }
        return $this->sendSuccess('',[]);
    }

    public function updateCroppedImage(Request $request)
    {
        $file = $request->all();
        if (!empty($file['images'])) {
            $key = array_keys($file['images']);
            Image::whereImageableId(Auth::user()->business_id)->whereImageableType(Business::class)->where('key', '=', \Arr::first($key))->delete();
            $this->imageService->save($request, Auth::user()->business_id,Business::class,'business');
            $business = Business::find(Auth::user()->business_id);
            $image = $business->{\Arr::first($key)};
            return response()->json(['url' => $image, 'status' => 'OK']);
        }
    }
}
