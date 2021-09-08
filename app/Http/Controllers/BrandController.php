<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Http\Requests\AddBrand;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends ApiBaseController
{
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
//        parent::__construct('brand');
        $this->middleware('permission:brand-list');
        $this->middleware('permission:brand-edit')->only(['edit','store','create']);
        $this->middleware('permission:brand-delete')->only(['destroy']);
        $this->middleware('permission:brand-status')->only(['statusUpdate']);
        $this->middleware('permission:brand-bulk-status')->only(['statusChangeMultiple']);
        $this->middleware('permission:brand-bulk-delete')->only(['destroyMultiplesBrands']);
    }

    public function index()
    {
        $brands = Brand::whereBusinessId( Auth::user()->business_id)->whereNull('deleted_at')->orderBy('id', 'desc')->paginate(AppConstants::PAGINATE_SMALL);
        if (is_null($brands)) {
            return $this->sendError('Brands not found.');
        } else {
            return $this->sendSuccess('Brands retrieved successfully.', BrandResource::collection($brands), $brands);
        }
    }

    public function edit(Request $request, $brand_id)
    {

        $brand = $this->brandService->findById($brand_id);
        return $this->sendSuccess('Brand retrieved successfully.', (new BrandResource($brand)));
    }

    public function store(AddBrand $request)
    {

        $brand = $this->brandService->save($request);
        if ($request->id) {
            return $this->sendSuccess('Brand updated successfully.');
        }
        return $this->sendSuccess('Brand created successfully.', $brand);
    }

    public function statusUpdate(Request $request, $id)
    {

        if ($this->brandService->findById($id)) {
            $this->brandService->BrandStatusUpdate($id, $request->status);
            if ($request->status == 1) {
                return $this->sendSuccess('Brand Status Activated successfully.');
            } else {
                return $this->sendSuccess('Brand Status Inactivated successfully.');
            }

        }
        return $this->sendError('Not Found');
    }

    public function destroy($brand_id)
    {
        $brand = $this->brandService->delete($brand_id);
        return $this->sendSuccess('Brand deleted successfully.');
    }

    public function destroyMultiplesBrands(Request $request)
    {

        $this->brandService->deleteMultiple($request->delete_data);
        return $this->sendSuccess('Brands deleted successfully.');
    }

    public function statusChangeMultiple(Request $request)
    {
        //return $request->delete_data;
        $this->brandService->changeStatusMultiple($request->delete_data, $request->status);
        return $this->sendSuccess('Brands status updated successfully.');
    }

    public function getAllBrands(Request $request)
    {
        $search = $request->search;
        if ($search == ''){
            $brands = Brand::whereBusinessId( Auth::user()->business_id)->whereNull('deleted_at')->orderBy('id', 'desc')->limit(AppConstants::PAGINATE_SMALL)->get();
        }else{
            $brands = Brand::where('title','like','%'.$search.'%')->whereBusinessId( Auth::user()->business_id)->whereNull('deleted_at')->orderBy('id', 'desc')->limit(AppConstants::PAGINATE_SMALL)->get();
        }
        $response = array();
        /**
         * @var $brand Brand
         */
        foreach($brands as $brand){
            $response[] = array(
                "id" => $brand->id,
                "text"=> $brand->title
            );
        }
        echo json_encode($response);
    }
}
