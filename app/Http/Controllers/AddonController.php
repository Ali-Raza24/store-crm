<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Http\Requests\AddonRequests;
use App\Http\Resources\AddonResource;
use App\Models\Addon;
use App\Services\AddonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AddonController extends ApiBaseController
{
    private $addonService;

    public function __construct(AddonService $addonService)
    {
        $this->addonService = $addonService;
//        parent::__construct('addon');
        $this->middleware('permission:addon-list');
        $this->middleware('permission:addon-edit')->only(['edit','store','create']);
        $this->middleware('permission:addon-delete')->only(['destroy']);
        $this->middleware('permission:addon-status')->only(['statusUpdate']);
        $this->middleware('permission:addon-bulk-status')->only(['statusChangeMultiple']);
        $this->middleware('permission:addon-bulk-delete')->only(['destroyMultiplesRecords']);
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $addons = $this->addonService->search(array_merge($params, ['order_by_desc' => true, 'paginate' => true]));
        if (is_null($addons)) {
            return $this->sendError('Addons not found.');
        } else {
            return $this->sendSuccess('Addons retrieved successfully.', AddonResource::collection($addons), $addons);
        }
    }

    public function edit(Request $request, $addon_id)
    {

        $addon = $this->addonService->findById($addon_id);
        return $this->sendSuccess('Brand retrieved successfully.', (new AddonResource($addon)));
    }

    public function store(AddonRequests $request)
    {


        request()->request->add(['business_id' => Auth::user()->business_id]);
        $addon = $this->addonService->save($request);
        if ($request->id) {
            return $this->sendSuccess('Addon updated successfully.');
        }
        return $this->sendSuccess('Addon created successfully.');
    }

    public function statusUpdate(Request $request, $id)
    {

        if ($this->addonService->findById($id)) {
            $this->addonService->BrandStatusUpdate($id, $request->status);
            if ($request->status == 1) {
                return $this->sendSuccess('Addon Status Activated successfully.');
            } else {
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
        $this->addonService->changeStatusMultiple($request->delete_data, $request->status);
        return $this->sendSuccess('Addons status updated successfully.');
    }

    public function getAddonsList(Request $request)
    {
        $addons = $this->addonService->search($request->all());
        return $this->sendSuccess('Ok', $addons);
    }

}
