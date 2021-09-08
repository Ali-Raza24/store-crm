<?php

namespace App\Http\Controllers;

use App\Constants\IStatus;
use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Models\DiscountLogs;
use App\Models\Product;
use App\Services\DiscountService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    private $discountService;

    public function __construct(DiscountService $discountService, $permissionController = 'discount')
    {
        $this->discountService = $discountService;
//        parent::__construct($permissionController);
        $this->middleware('permission:discount-list');
        $this->middleware('permission:discount-edit')->only(['edit','store','create','update']);
        $this->middleware('permission:discount-delete')->only(['destroy']);
        $this->middleware('permission:discount-status')->only(['statusUpdate']);
        $this->middleware('permission:discount-bulk-status')->only(['bulkStatus']);
        $this->middleware('permission:discount-bulk-delete')->only(['bulkDelete']);
    }

    public function index(Request $request)
    {
        $discounts_total = $this->discountService->search(['count' => true]);
        $discounts_total_active = $this->discountService->search([
            'sum' => true,
            'sum_field' => 'discount_value',
            'not_expired' => true
        ]);;
        $discounts_used_total = DiscountLogs::whereHas('discount' , function($q) {
            $q->whereBusinessId(Auth::user()->business_id);
        })->whereNull('deleted_at')->sum('amount');

        $products = Product::active()->pluck('title', 'id');

        $discounts = $this->discountService->search(array_merge($request->all(), ['paginate' => true]));

        return view("business.discounts.list",
            compact('products', 'discounts', 'discounts_total', 'discounts_total_active',
                'discounts_used_total'));
    }


    public function store(DiscountRequest $request)
    {
        $this->discountService->save($request);
        if (empty($request->discount_id)) {
            return response()->json([
                'status' => true,
                'message' => "Discount save successfully",
                'data' => []
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Discount updated successfully",
                'data' => []
            ]);
        }
    }

    public function edit(Request $request, $id) {

        $discounts_total = $this->discountService->search(['sum' => true, 'sum_field' => 'discount_value']);
        $discounts_total_active = $this->discountService->search([
            'sum' => true,
            'sum_field' => 'discount_value',
            'not_expired' => true
        ]);;
        $discounts_used_total = DiscountLogs::whereNull('deleted_at')->sum('amount');

        $products = Product::active()->pluck('title', 'id');

        $discountData = $this->mapDiscount(Discount::find($id));

        $isEdit = true;

        $discounts = $this->discountService->search(array_merge($request->all(), ['paginate' => true]));

        return view("business.discounts.list",
            compact('discounts_used_total', 'discounts_total_active', 'discounts_total', 'discounts', 'products',
                'isEdit', 'discountData'));
    }

    public function update(Request $request) {
        return $request;
    }

    public function statusChange(Request $request) {
        $discount_id = $request->get('discount_id');
        $status_id = $request->get('status_id');
        Discount::where('id', $discount_id)->update(['is_active' => $status_id]);
        $msg = 'active';
        if ($status_id == 1) {
            $msg = "active";
        } else {
            $msg = "InActive";
        }
        return response()->json($msg);
    }

    public function statusUpdate(Request $request) {

        $id = $request->discount_id;
        $status = $request->status_id;
        $discount = Discount::find($id);

        if ($discount) {
            $discount->is_active = $status;
            $discount->save();
        }
        if ($status == IStatus::ACTIVE){
            flash('Discount Status Activated successfully')->success();
        }else{
            flash('Discount Status Inactivated successfully')->success();
        }
        return redirect()->back();
    }

    public function discountCodeCheck(Request $request) {
        $business_id = $request->get('business_id');
        $random_string = $request->get('random_string');
        $discount_result = Discount::where('business_id', $business_id)->where(['code' => $random_string]);
        $msg = 'active';
        if ($discount_result->count() > 0) {
            $msg = 1;
        } else {
            $msg = 0;
        }
        return response()->json($msg);
    }

    public function bulkStatus(Request $request) {
        $ids = $request->discount_id;

        $discountIds = explode(',', $ids);
        $status = $request->status_id;
        foreach ($discountIds as $id) {
            $Discount = discount::find($id);
            if ($Discount) {
                $Discount->is_active = $status;
                $Discount->save();
            }
        }
        if ($status == IStatus::ACTIVE){
            flash('Discount Status Activated successfully')->success();
        }else{
            flash('Discount Status Inactivated successfully')->success();
        }
        return redirect()->back();
    }

    public function bulkDelete(Request $request) {
        $ids = $request->discount_id;
        $discountIds = explode(',', $ids);
        foreach ($discountIds as $id) {
            $discount = discount::find($id);
            if ($discount) {
                $discount->deleted_at = Carbon::now();
                $discount->save();

            }
        }
        flash('Discount deleted successfully')->success();
        return redirect()->route('discount-list');
    }

    public function destroy(Request $request) {
        $this->discountService->delete($request->discount_id);
        flash('Discount deleted successfully.')->success();
        return redirect()->back()->with('success', 'Discount deleted successfully.');
    }

    public function generateCode()
    {
        $code =\Str::random(rand(6, 12));

        if (Discount::whereCode($code)->whereBusinessId(Auth::user()->id)->first()){
            $this->generateCode();
        }

        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data' => ['code' => $code],
        ]);
    }

    /**
     * @param $discount Discount
     * @return array
     */
    private function mapDiscount($discount)
    {
        return [
            'discount_id' => $discount->id,
            'title' => $discount->title,
            'code' => $discount->code,
            'max_usage' => $discount->maximum_usage,
            'auto_apply' => (bool)$discount->auto_apply,
            'discount_type' => $discount->discount_type_id,
            'discount_percentage' => ($discount->discount_type_id == 1) ? $discount->discount_value : 0,
            'discount_amount' => ($discount->discount_type_id == 2) ? $discount->discount_value : 0,
            'all_products' => ($discount->all_products == 1) ? 1 : 2,
            'products' => optional($discount->products)->pluck('product_id'),
            'min_qty_amount' => !empty($discount->minimum_amount) ? 1 : (!empty($discount->minimum_quantity) ? 2 : 0),
            'min_purchase_amount' => $discount->minimum_amount,
            'min_qty_value' => $discount->minimum_quantity,
            'start_date' => isset($discount->from_date) ? Carbon::createFromFormat('Y-m-d', $discount->from_date)->toAtomString() : Carbon::now()->toAtomString(),
            'start_time' => isset($discount->from_time) ? Carbon::createFromFormat('H:i:s', $discount->from_time)->toAtomString() : Carbon::now()->toAtomString(),
            'end_date' => isset($discount->to_date) ? Carbon::createFromFormat('Y-m-d', $discount->to_date)->toAtomString() : '',
            'end_time' => isset($discount->to_time) ? Carbon::createFromFormat('H:i:s', $discount->to_time)->toAtomString() : ''
        ];
    }
}
