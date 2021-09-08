<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BusinessRequest;
use App\Http\Resources\BusinessResource;
use App\Mail\BusinessStatusMail;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\Product;
use App\Models\Status;
use App\Models\Store;
use App\Models\User;
use App\Services\BusinessService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessController extends ApiBaseController
{
    private $businessService;

    private $userService;
    public function __construct(BusinessService $businessService, UserService $userService)
    {
        $this->businessService = $businessService;
        $this->userService = $userService;
        parent::__construct('business');
    }

    public function index(Request $request){
        $totalBusiness = Business::count('id');
        $totalStores = Store::count('id');
        $businesses = $this->businessService->search($request->all());
        return view("admin.business.list", compact('totalBusiness', 'totalStores', 'businesses'));
    }
    //settings / featured businesses tab view
    public function featuredBusinessesIndex(Request $request)
    {
        $businesses = $this->businessService->search(array_merge($request->all(), ['paginate_small' => true]));
        return view("admin.settings.general.featured-business",['businesses' => $businesses]);
    }

    public function edit(Request $request, $id){
        $totalStores = Store::whereNull('deleted_at')->whereBusinessId($id)->count('id');
        $totalProducts = Product::whereNull('deleted_at')->whereBusinessId($id)->count('id');
        $business = $this->businessService->findById($id);
        $staffs = $this->userService->search(array_merge($request->all(),['business_id' => $id]));

        $businessTypes = BusinessType::whereIsActive(IStatus::ACTIVE)->get()->pluck('title','id');

        if ($request->ajax()){
            $business = $this->businessService->findById($id);
            return $this->sendSuccess('success', (new BusinessResource($business)));
        }
        return view("admin.business.edit", compact('business', 'totalStores', 'staffs', 'totalProducts', 'businessTypes'));
    }

    public function detail(Request $request, $id){
        $totalStores = Store::whereNull('deleted_at')->whereBusinessId($id)->count('id');
        $totalProducts = Product::whereNull('deleted_at')->whereBusinessId($id)->count('id');
        $business = $this->businessService->findById($id);
        $staffs = $this->userService->search(array_merge($request->all(),['business_id' => $id]));

        if ($request->ajax()){
            $business = $this->businessService->findById($id);
            return $this->sendSuccess('success', (new BusinessResource($business)));
        }
        return view("admin.business.detail", compact('business', 'totalStores', 'staffs', 'totalProducts'));
    }

    public function save(BusinessRequest $request)
    {
        $business = $this->businessService->register($request);
        return $this->sendSuccess('Registered Successfully', (new BusinessResource($business)));
    }

    public function update(Request $request)
    {
        $business = $this->businessService->register($request, true, true);
        flash('Business update successfully')->success()->important();
        return redirect()->back();
    }

    public function destroy(Request $request, $id = null){
        $business = $this->businessService->findById($request->business_id);
        if ($business){
            $business->deleted_at = Carbon::now();
            $business->save();

            $users = User::whereBusinessId($business->id)->get();
            foreach ($users as $user){
                $user->deleted_at = Carbon::now();
                $user->save();
            }

            $stores = Store::whereBusinessId($business->id)->get();
            foreach ($stores as $store){
                $store->deleted_at = Carbon::now();
                $store->save();
            }

            flash('Business deleted successfully')->success()->important();
            return redirect()->back();
        }
        return $this->sendError('Error while deleting business');
    }

    public function bulkDelete(Request $request){
        $ids = explode(',', $request->business_id);
        foreach ($ids as $id){
            $business = $this->businessService->findById($id);
            if ($business){
                $business->deleted_at = Carbon::now();
                $business->save();

                $users = User::whereBusinessId($business->id)->get();
                foreach ($users as $user){
                    $user->deleted_at = Carbon::now();
                    $user->save();
                }

                $stores = Store::whereBusinessId($business->id)->get();
                foreach ($stores as $store){
                    $store->deleted_at = Carbon::now();
                    $store->save();
                }
            }
        }
        flash('Businesses deleted successfully')->success()->important();
        return redirect()->back();
    }

    public function status(Request $request){
        $ids = explode(',', $request->business_id);
        foreach ($ids as $id){
            $business = $this->businessService->findById($id);
            if ($business){
                $business->business_status_id = $request->status_id;
                $business->save();

                if ($request->status_id == IStatus::BUSINESS_ACTIVE){
                    $user = User::whereEmail($business->owner_email)->first();
                    if ($user){
                        $user->is_active = IStatus::ACTIVE;
                        $user->save();
                    }
                }

                $status = '';
                if ($request->status_id == IStatus::BUSINESS_ACTIVE){
                    $status = 'Activated';
                }elseif ($request->status_id == IStatus::BUSINESS_INACTIVE){
                    $status = 'Inactivated';
                }elseif ($request->status_id == IStatus::BUSINESS_SUSPENDED){
                    $status = 'Suspended';
                }elseif ($request->status_id == IStatus::BUSINESS_SUSPENDED){
                    $status = 'Suspended';
                }

                $businessStatusMail = new BusinessStatusMail($business, $status);
                \Mail::send($businessStatusMail);
            }
        }
        flash('Status change to '.$business->business_status.' successfully')->success()->important();
        return redirect()->back();
    }
    public function BusinessesStatusUpdate(Request $request)
    {
        $business_id = $request->get('business_id');
        //$status_id = $request->get('status_id');
        $business = Business::where('id', $business_id)->first();
        if($business->is_featured == 1){
            Business::where('id', $business_id)->update(['is_featured' => 0]);

        }else{
            Business::where('id', $business_id)->update(['is_featured' => 1]);

        }

        $msg = 'Featured';
        if ($business->is_featured == 1) {
            $msg = "UnFeatured  successfully.";


        } else {

            $msg = "Featured  successfully.";
        }
        return response()->json($msg);
    }

    public function updatePlan(Request $request){
        $business = $this->businessService->findById($request->business_id);

        if (!empty($business)){
            $business->plan_id = $request->plan_id;
            $business->save();
            $plan = CommonHelper::plans()[$request->plan_id];
            flash('Plan change to '.$plan.' successfully')->success()->important();
            return redirect()->back();
        }
        return $this->sendError('Error while updating plan');
    }

    public function updateStatus(Request $request){
        $business = $this->businessService->findById($request->business_id);
        if (!empty($business)){
            $business->business_status_id = $request->status_id;
            $business->save();

            $status = '';
            if ($request->status_id == IStatus::BUSINESS_ACTIVE){
                $status = 'Activated';
            }elseif ($request->status_id == IStatus::BUSINESS_INACTIVE){
                $status = 'Inactivated';
            }elseif ($request->status_id == IStatus::BUSINESS_SUSPENDED){
                $status = 'Suspended';
            }elseif ($request->status_id == IStatus::BUSINESS_SUSPENDED){
                $status = 'Suspended';
            }

            $businessStatusMail = new BusinessStatusMail($business, $status);
            \Mail::send($businessStatusMail);

            if ($request->status_id == IStatus::BUSINESS_ACTIVE){
                $user = User::whereEmail($business->owner_email)->first();
                if ($user){
                    $user->is_active = IStatus::ACTIVE;
                    $user->save();
                }
            }

            flash('Status change to '.$business->business_status.' successfully')->success()->important();
            return redirect()->back();
        }
        return $this->sendError('Error while updating plan');
    }

    public function getBusinessStatus()
    {
        return $this->sendSuccess('success', CommonHelper::businessStatus());
    }
}
