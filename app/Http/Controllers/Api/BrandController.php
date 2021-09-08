<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Models\Brand;
use App\Services\BrandService;
use App\Http\Requests\AddBrand;
use App\Http\Resources\BrandResource;

class BrandController extends ApiBaseController
{
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
        parent::__construct('brand');
    }

    public function index()
    {
        $brands = Brand::where('business_id', 1)->whereNull('deleted_at')->paginate(5);
        if (is_null($brands)) {
            return $this->sendError('Brands not found.');
        } else {
            return $this->sendSuccess( 'Brands retrieved successfully.', BrandResource::collection($brands), $brands);
        }
    }

    public function edit(Request $request, $brand_id)
    {

        $brand = $this->brandService->findById($brand_id);
        return $this->sendSuccess('Brand retrieved successfully.',(new BrandResource($brand)));
    }

    public function store(AddBrand $request)
    {
        request()->request->add(['user_id' => 1]);
        request()->request->add(['business_id' => 1]);
        $brand = $this->brandService->save($request);
        if ($request->id){
            return $this->sendSuccess( 'Brand updated successfully.');
        }
        return $this->sendSuccess('Brand created successfully.');
    }

    public function statusUpdate(Request $request, $id)
    {

        if ($this->brandService->findById($id)) {
            $this->brandService->BrandStatusUpdate($id, $request->status);
            if($request->status==1){
                return $this->sendSuccess('Brand Status Activated successfully.');
            }else{
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
        $this->brandService->changeStatusMultiple($request->delete_data,$request->status);
        return $this->sendSuccess('Brands status updated successfully.');
    }


}
