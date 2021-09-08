<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Helpers\CommonHelper;
use App\Mail\Admin\BusinessRegister;
use App\Models\Business;
use App\Models\Image;
use App\Models\Page;
use App\Models\PermissionModel;
use App\Models\Role;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BusinessService
{
    private $userService;

    private $storeService;

    private $imageService;

    /**
     * @var $model \Eloquent
     */
    private $model;

    public function __construct(UserService $userService, StoreService $storeService, ImageService $imageService)
    {
        $this->userService = $userService;
        $this->model = new Business();
        $this->storeService = $storeService;
        $this->imageService = $imageService;
    }

    /**
     * @param Request $request
     * @return false|mixed
     */
    public function register($request, $web = false, $onlyBusiness = false)
    {
//        try {
        DB::beginTransaction();
        $increment_id = $this->model->orderBy('id', 'DESC')->first();
        if ($increment_id) {
            $increment_id = $increment_id->id;
        } else {
            $increment_id = 0;
        }

        if (!empty($request->business_id)) {
            $business = $this->findById($request->business_id);
        } else {
            $business = $this->model;
            $business->code = CommonHelper::generateBusinessCode($increment_id + 1);
        }

        if (!empty($request->name)) {
            $business->name = $request->name;
        }
        if (!empty($request->email)) {
            $business->email = $request->email;
        }

        if ($request->has('phone')) {
            $business->phone = $request->phone;
        }
        if (!empty($request->mobile)) {
            $business->mobile = $request->mobile;
        }
        if (!empty($request->owner_name)) {
            $business->owner_name = $request->owner_name;
        }
        if (!empty($request->owner_email)) {
            $business->owner_email = $request->owner_email;
        }
        if ($request->has('owner_phone')) {
            $business->owner_phone = $request->owner_phone;
        }
        if (!empty($request->owner_mobile)) {
            $business->owner_mobile = $request->owner_mobile;
        }
        if (!empty($request->brand_color)) {
            $business->brand_color = $request->brand_color;
        }
        if (!empty($request->minimum_order_amount)) {
            $business->minimum_order_amount = $request->minimum_order_amount;
        }
        if (!empty($request->business_type_id)) {
            $business->business_type_id = $request->business_type_id;
        }
        if (!empty($request->url)) {
            $business->url = Str::slug($request->url);
        }
        if (!empty($request->plan_id)) {
            $business->plan_id = $request->plan_id;
        }
        if ($request->business_id) {
            $business->business_status_id = IStatus::BUSINESS_ACTIVE;
        } else {
            $business->business_status_id = IStatus::BUSINESS_PENDING;
        }
        if ($request->has('address_1')) {
            $business->address_1 = $request->address_1;
        }
        if ($request->has('address_2')) {
            $business->address_2 = $request->address_2;
        }
        if ($request->has('country_id')) {
            $business->country_id = $request->country_id;
        }
        if ($request->has('state_id')) {
            $business->state_id = $request->state_id;
        }
        $business->save();

        //generate pages for business


        $this->generatePages($business->id);
        if (!$web) {
            if ($request->has('images')) {
                if (is_array($request->images) && !empty($request->images[0])) {
                    $image = Image::where([
                        'imageable_id' => $business->id,
                        'imageable_type' => Business::class
                    ])->first();
                    if ($image) {
                        $image->delete();
                    }
                }
                $this->imageService->save($request, $business->id, Business::class, 'business');
            }
        } else {
            if ($request->file('images')) {
                if (!empty($request->images['logo'])) {
                    $image = Image::whereImageableId($business->id)
                        ->whereImageableType(Business::class)
                        ->where('key', '=', 'logo');
                    if ($image->first()) {
                        Image::whereImageableId($business->id)
                            ->whereImageableType(Business::class)
                            ->where('key', '=', 'logo')->delete();
                    }
                }
                if (!empty($request->images['logo_mobile'])) {
                    $image = Image::whereImageableId($business->id)
                        ->whereImageableType(Business::class)
                        ->where('key', '=', 'logo_mobile');
                    if ($image->first()) {
                        Image::whereImageableId($business->id)
                            ->whereImageableType(Business::class)
                            ->where('key', '=', 'logo_mobile')->delete();
                    }
                }
                if (!empty($request->images['eid'])) {
                    $image = Image::whereImageableId($business->id)
                        ->whereImageableType(Business::class)
                        ->where('key', '=', 'eid');
                    if ($image->first()) {
                        Image::whereImageableId($business->id)
                            ->whereImageableType(Business::class)
                            ->where('key', '=', 'eid')->delete();
                    }
                }
                if (!empty($request->images['trade'])) {
                    $image = Image::whereImageableId($business->id)
                        ->whereImageableType(Business::class)
                        ->where('key', '=', 'trade');
                    if ($image->first()) {
                        Image::whereImageableId($business->id)
                            ->whereImageableType(Business::class)
                            ->where('key', '=', 'trade')->delete();
                    }
                }
                if (!empty($request->images['profile'])) {
                    $image = Image::whereImageableId($business->id)
                        ->whereImageableType(Business::class)
                        ->where('key', '=', 'profile');
                    if ($image->first()) {
                        Image::whereImageableId($business->id)
                            ->whereImageableType(Business::class)
                            ->where('key', '=', 'profile')->delete();
                    }
                }
            }
            if (!empty($request->images['logo'])) {
                $this->imageService->saveImage($request, $business->id, Business::class, 'business');
            }else{
                $this->imageService->saveImage($request, $business->id, Business::class, 'business');
            }
        }

        if (!empty($request->stores[0])) {
            $storeData = json_decode(json_encode($request->stores[0]));
            $this->storeService->save($request->stores[0], $business->id);
        }

        if (!$onlyBusiness) {
            if (!empty($request->owner_email)) {
                \request()->request->add([
                    'business_id' => $business->id,
                    'is_business' => 1,
                    'user_type_id' => 1,
                    'location_id' => 0
                ]);

                $this->userService->save($request, true, $business->id);
            }

            if (empty($request->business_id)) {
                $admin_notify_email = new BusinessRegister($business);
                Mail::send($admin_notify_email);
            }
        }

        $this->defaultRoles($business->id);
        $this->checkoutSetting($business->id);
        DB::commit();
        return $business;
//        } catch (\Exception | \Throwable $excepxtion) {
//            return DB::rollBack();
//        }
    }

    public function findById($id)
    {
        try {
            return Business::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return "Not Found";
        }
    }

    public function search($params)
    {
        $business = Business::whereNull('deleted_at');
        if (url()->current() === route('admin-business-list-new')) {
            $currentDate = Carbon::now();
            $business = $business->whereDate('created_at', '>=', $currentDate->subDay()->format('Y-m-d'));
        }
        if (url()->current() === route('admin-business-list-active') || url()->current() === route('admin-customers-active-list')) {
            $business = $business->whereBusinessStatusId(IStatus::BUSINESS_ACTIVE);
        }

        if (url()->current() === route('admin-business-list-suspended') || url()->current() === route('admin-customers-suspended-list')) {
            $business = $business->whereBusinessStatusId(IStatus::BUSINESS_SUSPENDED);
        }

        if (url()->current() === route('admin-business-list-upcoming')) {
            $business = $business;
        }

        if (isset($params['state'])){
            $business = $business->whereIn('state_id', $params['state']);
        }

        if (isset($params['plan'])){
            $business = $business->whereIn('plan_id', $params['plan']);
        }

        if (!empty($params['from_date'])){
            $business = $business->whereDate('created_at','>=', $params['from_date']);
        }
        if (!empty($params['to_date'])){
            $business = $business->whereDate('created_at','<=', $params['to_date']);
        }

        if (!empty($params['search_business_name'])) {
            $business = $business->where('name','LIKE','%'.$params['search_business_name'].'%');
        }

        if (isset($params['business_status_id'])) {
            $business = $business->whereBusinessStatusId($params['business_status_id']);
        }

        if (!empty($params['count'])){
            return $business->count('id');
        }

        if (!empty($params['paginate_small'])) {
            return $business->orderBy('id','desc')->paginate(AppConstants::PAGINATE_SMALL);
        }

        return $business->orderBy('id','desc')->paginate(AppConstants::PAGINATE_LARGE);
    }

    private function generatePages($id)
    {
        $pageTitles = [
            1 => 'About Us',
            2 => 'Terms & Condition',
            3 => 'Privacy Policy',
            4 => 'Refund Policy',
            5 => 'Main Page'
        ];
        if (!empty($id)) {
            //insert pages data in page table
            for ($i = 1; $i <= count($pageTitles); $i++) {
                $newSlug = Str::slug($pageTitles[$i], "-");
                $exists = Page::where('business_id', '=', $id)->where('slug', '=', $newSlug)->first();
                //return $businessess;
                if (!$exists) {
                    $page = new Page();
                    $page->slug = $newSlug;
                    $page->name = $pageTitles[$i];
                    $page->title = $pageTitles[$i];
                    $page->meta_discription = Str::random(50);
                    $page->heading = $pageTitles[$i];
                    $page->sub_heading = $pageTitles[$i];
                    $page->content = Str::random(50);
                    $page->business_id = $id;
                    $page->is_active = 1;
                    $page->save();
                }
            }
        }
    }

    public function defaultRoles($business_id)
    {
        $defaultRoles = [
            [
                'name' => 'Admin',
                'business_id' => $business_id,
                'permissions' => PermissionModel::whereIn('name', [
                    'business-dashboard',
                    'order-list',
                    'order-edit',
                    'order-view',
                    'order-invoice-generate',
                    'order-invoice',
                    'invoice-print',
                    'order-payment',
                    'order-status',
                    'order-bulk-status',
                    'order-cancel',
                    'order-refund',
                    'reports-simple',
                    'reports-advanced',
                    'customer-list',
                    'customer-create',
                    'customer-edit',
                    'customer-view',
                    'customer-delete',
                    'customer-status',
                    'customer-bulk-status',
                    'customer-bulk-delete',
                    'product-list',
                    'product-create',
                    'product-edit',
                    'product-delete',
                    'product-view',
                    'product-status',
                    'product-bulk-status',
                    'product-bulk-delete',
                    'discount-list',
                    'discount-create',
                    'discount-edit',
                    'discount-delete',
                    'discount-view',
                    'discount-status',
                    'discount-bulk-status',
                    'discount-bulk-delete',
                    'store-info',
                    'eid-and-trade-license',
                    'store-create',
                    'account-info',
                    'notification-setting',
                    'bank-details',
                    'checkout-setting',
                    'payment-setting',
                    'page-list',
                    'page-create',
                    'page-edit',
                    'page-view',
                    'page-delete',
                    'page-status',
                    'page-bulk-status',
                    'page-bulk-delete',
                    'brand-list',
                    'brand-create',
                    'brand-edit',
                    'brand-view',
                    'brand-delete',
                    'brand-status',
                    'brand-bulk-status',
                    'brand-bulk-delete',
                    'category-list',
                    'category-create',
                    'category-edit',
                    'category-view',
                    'category-delete',
                    'category-status',
                    'category-bulk-status',
                    'category-bulk-delete',
                    'addon-list',
                    'addon-create',
                    'addon-edit',
                    'addon-view',
                    'addon-delete',
                    'addon-status',
                    'addon-bulk-status',
                    'addon-bulk-delete',
                    'shipping-general',
                    'shipping-areas',
                    'zone-list',
                    'zone-create',
                    'zone-edit',
                    'zone-delete',
                    'zone-areas',
                    'user-list',
                    'user-create',
                    'user-edit',
                    'user-view',
                    'user-delete',
                    'user-status',
                    'user-bulk-status',
                    'user-bulk-delete',
                    'role-list',
                    'role-create',
                    'role-edit',
                    'role-view',
                    'role-delete',
                    'role-status',
                ])->whereIsBusiness(1)->get()->pluck('id')
            ],
            [
                'name' => 'Manager',
                'business_id' => $business_id,
                'permissions' => PermissionModel::whereIn('name', [
                    'business-dashboard',
                    'order-list',
                    'order-edit',
                    'order-view',
                    'order-invoice-generate',
                    'order-invoice',
                    'invoice-print',
                    'order-payment',
                    'order-status',
                    'order-bulk-status',
                    'order-cancel',
                    'order-refund',
                    'reports-simple',
                    'customer-list',
                    'customer-create',
                    'customer-edit',
                    'customer-view',
                    'customer-status',
                    'customer-bulk-status',
                    'product-list',
                    'product-create',
                    'product-edit',
                    'product-delete',
                    'product-view',
                    'product-status',
                    'product-bulk-status',
                    'product-bulk-delete',
                    'discount-list',
                    'discount-create',
                    'discount-edit',
                    'discount-view',
                    'discount-status',
                    'discount-bulk-status',
                    'store-info',
                    'notification-setting',
                    'checkout-setting',
                    'page-list',
                    'page-create',
                    'page-edit',
                    'page-view',
                    'page-status',
                    'page-bulk-status',
                    'brand-list',
                    'brand-create',
                    'brand-edit',
                    'brand-view',
                    'brand-status',
                    'brand-bulk-status',
                    'category-list',
                    'category-create',
                    'category-edit',
                    'category-view',
                    'category-status',
                    'category-bulk-status',
                    'addon-list',
                    'addon-create',
                    'addon-edit',
                    'addon-view',
                    'addon-status',
                    'addon-bulk-status',
                    'shipping-general',
                    'shipping-areas',
                    'zone-list',
                    'zone-create',
                    'zone-edit',
                    'zone-delete',
                    'zone-areas',
                    'role-list',
                    'role-create',
                    'role-edit',
                    'role-view',
                    'role-status',
                ])->whereIsBusiness(1)->get()->pluck('id')
            ],
            [
                'name' => 'Supervisor',
                'business_id' => $business_id,
                'permissions' => PermissionModel::whereIn('name', [
                    'business-dashboard',
                    'order-list',
                    'order-view',
                    'order-invoice-generate',
                    'order-invoice',
                    'invoice-print',
                    'order-payment',
                    'order-status',
                    'order-bulk-status',
                    'order-cancel',
                    'customer-list',
                    'customer-create',
                    'customer-view',
                    'customer-status',
                    'customer-bulk-status',
                    'product-list',
                    'product-create',
                    'product-edit',
                    'discount-list',
                    'discount-view',
                    'discount-status',
                    'discount-bulk-status',
                    'checkout-setting',
                    'page-list',
                    'page-view',
                    'page-status',
                    'page-bulk-status',
                    'brand-list',
                    'brand-create',
                    'brand-view',
                    'brand-status',
                    'brand-bulk-status',
                    'category-list',
                    'category-create',
                    'category-view',
                    'category-status',
                    'category-bulk-status',
                    'addon-list',
                    'addon-create',
                    'addon-view',
                    'addon-status',
                    'addon-bulk-status',
                    'shipping-general',
                    'shipping-areas',
                    'zone-list',
                    'zone-create',
                    'zone-areas'
                ])->whereIsBusiness(1)->get()->pluck('id')
            ],
            [
                'name' => 'Staff',
                'business_id' => $business_id,
                'permissions' => PermissionModel::whereIn('name', [
                    'business-dashboard',
                    'order-list',
                    'order-view',
                    'order-status',
                    'order-bulk-status',
                    'product-list',
                    'product-status',
                    'product-bulk-status',
                    'product-create',
                    'product-edit',
                    'discount-list',
                    'page-list',
                    'page-view',
                    'brand-list',
                    'category-list',
                    'addon-list',
                    'shipping-general',
                    'shipping-areas',
                    'zone-list',
                    'zone-areas'
                ])->whereIsBusiness(1)->get()->pluck('id')
            ]
        ];

        foreach ($defaultRoles as $role) {
            $existRole = Role::whereName($role['name'])->whereBusinessId($business_id)->first();
            if (!$existRole){
                $newRole = new Role();
                $newRole->name = $role['name'];
                $newRole->is_business = 1;
                $newRole->guard_name = 'web';
                $newRole->business_id = $business_id;
                $newRole->save();
                $newRole->syncPermissions($role['permissions']);
            }
        }
    }

    public function checkoutSetting($business_id)
    {
        $arr['checkout'] = [
            'with_mobile' => true,
            'with_email' => true,
            'tip_option' => false,
            'allow_change_billing' => false,
            'cash_payment' => true,
            'card_payment' => true,
            'tax_inclusive' => false,
            'no_tax' => false,
        ];

        $setting = new Setting();
        $setting->business_id = $business_id;
        $setting->key = 'checkout';
        $setting->value = json_encode($arr['checkout']);
        $setting->save();

    }
}
