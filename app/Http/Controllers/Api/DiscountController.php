<?php

namespace App\Http\Controllers\Api;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountController extends ApiBaseController
{
    public function __construct()
    {
        parent::__construct('discount');
    }

    public function validateDiscount(Request $request)
    {
        $requestData = $request->all();

        $code = $request->discount_code;

        $discount = Discount::whereCode($code)->whereNull('deleted_at')->whereBusinessId(\Auth::user()->business_id)->first();
        if (empty($discount)){
            return $this->sendError('Coupon code not found');
        }
        if ($discount->all_products == 1){
            $discountPrice = $this->validateCode($request->total, $request->total_qty, $discount->code,1);
            $requestData = array_merge($requestData, ['discount_value' => $discountPrice, 'discount_type' => 1]);
            if ($discountPrice == false){
                return $this->sendError('Coupon Invalid');
            }else{
                return $this->sendSuccess('Coupon applied successfully', $requestData);
            }
        }else{

            $productIds = [];
            foreach ($request->cart as $cart){
                $productIds[] = $cart['product_id'];
            }

            $discountProducts = $discount->products->whereIn('product_id', $productIds)->count();

            if (empty($discountProducts)){
                return $this->sendError('Coupon Invalid');
            }

            $i = 0;
            $totalDiscount = 0;
            foreach ($request->cart as $cart){

                if (optional(Product::find($cart['product_id']))->discount_not_allowed == 1) {
                    break;
                }

                $price = $cart['price'] * $cart['qty'];
                $discountPrice = $this->validateCode($price, $cart['qty'], $discount->code, 2, $cart['product_id']);
                $requestData['cart'][$i] = array_merge($requestData['cart'][$i], ['discount_value' => $discountPrice]);
                $totalDiscount += $discountPrice;
                $i++;
            }
            $requestData = array_merge($requestData, ['discount_type' => 2, 'discount_value' => $totalDiscount]);
            return $this->sendSuccess('Coupon applied successfully', $requestData);
        }
        return $this->sendError('Coupon Invalid');
    }

    private function validateCode($price, $qty, $discount_code, $type = 1, $product_id = 0)
    {
        $discountPrice = 0;

        $total = $price;

        if ($discount_code) {
            $discount = Discount::whereCode($discount_code)->whereNull('deleted_at')->whereBusinessId(\Auth::user()->business_id)->first();

            if (!$discount){
                return false;
            }

            if ($type == 2) {
                if (empty(DiscountProduct::whereDiscountId($discount->id)->whereProductId($product_id)->first())) {
                    return false;
                }
            }

            $startTime = $discount->from_date . ' ' . $discount->from_time;
            $endTime = $discount->to_date . ' ' . $discount->to_time;

            $start = now()->diffInMinutes(Carbon::parse($startTime), false);
            $end = now()->diffInMinutes(Carbon::parse($endTime), false);

            if (!empty($discount->minimum_amount) && $discount->minimum_amount > ($qty * $price)) {
                return false;
            }
            if (!empty($discount->minimum_quantity) && $discount->minimum_quantity > $qty) {
                return false;
            }

            if (($start > 0 && $end > 0) || ($start < 0 && $end < 0)) {
                return false;
            }

            $discountValue = $discount->discount_value;
            $discountType = $discount->discount_type_id;

            if ($discountType == 1) {
                $discountPrice = round($total * $discountValue / 100, 2);
            } else {
                $discountPrice = $discountValue;
            }
            return $discountPrice;
        }
        return false;
    }

    public function getDiscounts(Request $request)
    {
        /*$percentageDiscount = Discount::whereNull('deleted_at')
            ->whereBusinessId(\Auth::user()->business_id)
            ->whereAutoApply(1)
            ->whereDiscountTypeId(1)
            ->max('discount_value');

        $fixedDiscount = Discount::whereNull('deleted_at')
            ->whereBusinessId(\Auth::user()->business_id)
            ->whereAutoApply(1)
            ->whereDiscountTypeId(2)
            ->max('discount_value');

        $discount = [];
        $percentageValue = 0;
        $fixedValue = 0;

        if ($percentageDiscount){
            $products =
        }

        if (! $discount->auto_apply){
            return false;
        }

        if (! $discount->)

        return false;*/
    }
}
