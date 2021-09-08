<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Models\Discount;
use App\Models\DiscountLogs;
use App\Models\DiscountProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DiscountService
{
    private $imageService;

    /**
     * @var $model Discount
     */
    private $model;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->model = new Discount();
    }

    public function search($params)
    {
        /**
         * @var $discounts Discount
         */
        $discounts = Discount::with('products');
        $discounts = $discounts->whereNull('deleted_at')->whereBusinessId(Auth::user()->business_id);



        if (!empty($params['discount_min_used'])) {
            $discounts = $discounts->whereHas('discountLogs', function ($q) use ($params){
               $q->havingRaw('SUM(amount) >= '.$params['discount_min_used']);
            });
        }

        if (!empty($params['discount_max_used'])) {
            $discounts = $discounts->whereHas('discountLogs', function ($q) use ($params){
                $q->havingRaw('SUM(amount) <= '.$params['discount_max_used']);
            });
        }

        if (!empty(($params['discount_min_amount']))){
            $discounts = $discounts->where('discount_value','>=', $params['discount_min_amount']);
        }

        if (!empty(($params['discount_max_amount']))){
            $discounts = $discounts->where('discount_value','<=', $params['discount_max_amount']);
        }

        if (!empty($params['expired']) || url()->current() == route('discount-list-expire')) {
            $discounts = $discounts->whereDate('to_date', '<', Carbon::now()->format('Y-m-d'));
        }

        if (!empty($params['not_expired']) || url()->current() == route('discount-list-active')) {
            $discounts = $discounts->whereDate('to_date', '>=', Carbon::now()->format('Y-m-d'));
        }

        if (!empty($params['active'])) {
            $discounts = $discounts->whereIsActive(IStatus::ACTIVE);
        }

        if (!empty($params['from_date'])){
            $discounts = $discounts->whereDate('from_date','>=', $params['from_date']);
        }
        if (!empty($params['to_date'])){
            $discounts = $discounts->whereDate('to_date','<=', $params['to_date']);
        }

        if (!empty($params['sum'])) {
            return $discounts->sum($params['sum_field']);
        }

        if (!empty($params['count'])) {
            return $discounts->count('id');
        }

        if (!empty($params['paginate'])) {
            return $discounts->paginate(AppConstants::PAGINATE_LARGE);
        }

        return $discounts->get();
    }


    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findByBusinessId($id)
    {
        return Discount::whereBusinessId($id)->first();
    }

    public function save($request)
    {
        if (!empty($request->discount_id)) {
            $discount = Discount::find($request->discount_id);
        } else {
            $discount = new Discount();
        }

        if ($request->has('title')){
            $discount->title = $request->title;
        }

        if ($request->has('code')) {
            $discount->code = $request->code;
        }
        if ($request->has('discount_type')) {
            $discount->discount_type_id = $request->discount_type;
        }
        if ($request->has('max_usage')) {
            $discount->maximum_usage = $request->max_usage;
        }

        if ($request->discount_type == 1) {
            $discount->discount_value = $request->discount_percentage;
        } else {
            $discount->discount_value = $request->discount_value;
        }

        if ($request->auto_apply) {
            $discount->auto_apply = 1;
        }

        if ($request->all_products == 1) {
            $discount->all_products = 1;
        } else {
            $discount->all_products = 0;
        }

        if ($request->min_qty_amount == 1) {
            $discount->minimum_amount = $request->min_purchase_amount;
            $discount->minimum_quantity = 0;
        } else {
            $discount->minimum_amount = 0;
            $discount->minimum_quantity = $request->min_qty_value;
        }

        $discount->from_date = isset($request->start_date) ? Carbon::parse($request->start_date)->format('Y-m-d') : null;
        $discount->to_date = isset($request->end_date) ? Carbon::parse($request->end_date)->format('Y-m-d') : null;
        $discount->from_time = isset($request->start_time) ? Carbon::parse($request->start_time)->format('H:i:s') : null;
        $discount->to_time = isset($request->end_time) ? Carbon::parse($request->end_time)->format('H:i:s') : null;

        $discount->business_id = Auth::user()->business_id;
        $discount->is_active = IStatus::ACTIVE;

        $discount->save();

        $this->updateProducts($request, $discount->id);

        return $discount;
    }

    public function delete($id)
    {
        $discount = Discount::find($id);
        if ($discount) {
            $discount->deleted_at = Carbon::now();
            $discount->save();
        }
    }

    private function updateProducts($request, int $id)
    {
        DiscountProduct::whereDiscountId($id)->delete();
        if ($request->all_products == 2) {
            foreach ($request->products as $product){
                $discountProduct = new DiscountProduct();
                $discountProduct->discount_id = $id;
                $discountProduct->product_id = $product;
                $discountProduct->save();
            }
        }
        return true;
    }
}
