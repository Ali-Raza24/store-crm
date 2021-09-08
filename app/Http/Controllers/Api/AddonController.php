<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Models\Image;
use App\Models\Addon;
use Validator;
use App\Services\AddonService;
use App\Http\Requests\AddonRequests;
use App\Http\Resources\AddonResource;

class AddonController extends ApiBaseController
{
    private $addonService;

    public function __construct(AddonService $addonService)
    {
        $this->addonService = $addonService;
        parent::__construct('addon');
    }
    public function index()
    {
        $Addons = Addon::where('business_id', 1)->whereNull('deleted_at')->paginate(5);
        if (is_null($Addons)) {
            return $this->sendError('Addons not found.');
        } else {
            return $this->sendSuccess( 'Addons retrieved successfully.', AddonResource::collection($Addons), $Addons);
        }
    }

    public function edit(Request $request, $addon_id)
    {

        $addon = $this->addonService->findById($addon_id);
        return $this->sendSuccess('Brand retrieved successfully.',(new AddonResource($addon)));
    }

    public function store(AddonRequests $request)
    {
        request()->request->add(['user_id' => 1]);
        request()->request->add(['business_id' => 1]);
        $addon = $this->addonService->save($request);
        if ($request->id){
            return $this->sendSuccess( 'Addon updated successfully.');
        }
        return $this->sendSuccess('Addon created successfully.');
    }

    public function statusUpdate(Request $request, $id)
    {

        if ($this->addonService->findById($id)) {
            $this->addonService->BrandStatusUpdate($id, $request->status);
            if($request->status==1){
                return $this->sendSuccess('Addon Status Activated successfully.');
            }else{
                return $this->sendSuccess('Addon Status Inactivated successfully.');
            }

        }
        return $this->sendError('Not Found');
    }

    public function destroy($addon_id)
    {
        $addon = $this->addonService->delete($addon_id);
        return $this->sendSuccess('Addon deleted successfully.');
    }

    public function destroyMultiplesRecords(Request $request)
    {

        $this->addonService->deleteMultiple($request->delete_data);
        return $this->sendSuccess('Addons deleted successfully.');
    }
    public function statusChangeMultiple(Request $request)
    {
        //return $request->delete_data;
        $this->addonService->changeStatusMultiple($request->delete_data,$request->status);
        return $this->sendSuccess('Addons status updated successfully.');
    }

}
