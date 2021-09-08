<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Resources\StoreZoneResource;
use App\Http\Resources\ZoneAreaResource;
use App\Models\BusinessStoreArea;
use App\Models\DeliveryCompany;
use App\Models\Plan;
use App\Models\PlanOptions;
use App\Models\Store;
use App\Models\StoreZone;
use App\Models\ZoneArea;
use App\Services\BusinessService;
use App\Services\StoreService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class StoreController extends ApiBaseController
{
    private $storeService;

    private $businessService;

    public function __construct(StoreService $storeService, BusinessService $businessService)
    {
        $this->storeService = $storeService;
        $this->businessService = $businessService;
        parent::__construct();
        $this->middleware('permission:store-create')->only(['create', 'store']);
    }

    public function index(Request $request)
    {
        $stores = Store::selectRaw('if(is_active=2,CONCAT(name," (","InActive",")"), name) as name, slug')
            ->whereBusinessId(Auth::user()->business_id)
            ->whereNull('deleted_at')->get()->pluck('name', 'slug');
        if ($request->ajax()) {
            return $this->sendSuccess('Success', $stores);
        }

        return view("business.stores.select", compact('stores'));
    }

    public function create(Request $request)
    {
        $plan = Plan::find(Auth::user()->business->plan_id);
        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_STORES)->first();
        $storeCount = Store::whereBusinessId(Auth::user()->business_id)->whereNull('deleted_at')->count('id');

        if ($planOption->values <=  $storeCount){
            flash('You have reached to your maximum store limit. Please upgrade your subscription to continue!')->error();
            return redirect()->route('store-select');
        }
        $store = $this->storeService->findByBusiness(Auth::user()->business_id, true);
        $url = '';
        if ($store > 0) {
            $url = \auth()->user()->business->url;
        }
        return view("business.stores.add", compact('url', 'store'));
    }

    public function store(StoreRequest $request)
    {

        $plan = Plan::find(Auth::user()->business->plan_id);
        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_STORES)->first();
        $storeCount = Store::whereBusinessId(Auth::user()->business_id)->whereNull('deleted_at')->count('id');

        if ($planOption->values <= $storeCount){
            return $this->sendError('You have reached to your maximum store limit. Please upgrade your subscription to continue!');
        }

        $business = Auth::user()->business->toArray();
        foreach ($business as $key => $value) {
            if ($key !== 'url') {
                \request()->request->add([$key => $value]);
            }
        }

        \request()->request->add(['business_id' => Auth::user()->business_id]);

        $business = $this->businessService->register($request);
        $store = $this->storeService->findLatestByBusiness($business->id);

        session()->put('store-name', $store->slug);
        $store = Store::whereSlug(session()->get('store-name'))->first();

        if ($store) {
            session()->put('store-data', $store);
        }

        return $this->sendSuccess('Store Created', $store);
    }

    public function changeStore($name)
    {
//        session()->remove('store-name');
        session()->put('store-name', $name);

        $store = Store::whereSlug(session()->get('store-name'))->whereBusinessId(Auth::user()->business_id)->first();

        if ($store) {
            session()->put('store-data', $store);
        }
        if (url()->previous() == route('general-setting-store')){
            return redirect()->back();
        }
        return redirect()->route('business-dashboard');
    }

    public function status(Request $request)
    {
        $store = Store::find($request->store_id);
        $plan = Plan::find(Auth::user()->business->plan_id);
        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_STORES)->first();

        $storeCount = Store::whereBusinessId(Auth::user()->business_id)->whereNull('deleted_at')->count('id');

        if ($store) {
            if (!empty($planOption->values) && ($planOption->values > $storeCount || $store->is_active == IStatus::ACTIVE)) {
                if ($store->is_active == IStatus::ACTIVE) {
                    $store->is_active = IStatus::DISABLE;
                    flash('Store inactivated successfully')->success()->important();
                } else {
                    $store->is_active = IStatus::ACTIVE;
                    flash('Store activated successfully')->success()->important();
                }
                $store->save();
                session()->put('store-data', $store);
                session()->put('store-name', $store->name);
            } else {
                flash('Cannot active this store. You have reached to your maximum store limit. Please upgrade your subscription to continue! ')->error()->important();
            }
        } else {
            flash('Error while disabling store')->error();
        }

        return redirect()->back();
    }

    public function getStore($name)
    {
        session()->put('store-name', $name);

        $store = Store::whereSlug(session()->get('store-name'))->whereBusinessId(Auth::user()->business_id)->first();

        if ($store) {
            session()->put('store-data', $store);
        }

        return redirect()->route('general-setting-store');
    }

    public function saveLocation(Request $request)
    {
        $request->validate(['address' => ['required','string']]);
        $store = Store::find($request->store_id);

        if ($store){
            $store->latitude = $request->lat;
            $store->longitude = $request->lng;
            $store->address_1 = $request->address;
            $store->delivery_company_id = DeliveryCompany::whereTitle('Aramex')->first()->id;
            $store->save();
            return $this->sendSuccess('Store location update successfully');
        }
        return $this->sendError('Error while updating store location');
    }

    public function getStoreById(Request $request, $id)
    {
        return $this->sendSuccess('OK', $this->storeService->findById($id));
    }
}
