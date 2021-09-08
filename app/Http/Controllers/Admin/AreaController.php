<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\AreaRequest;
use App\Http\Resources\AreaResource;
use App\Models\Area;
use App\Models\BusinessArea;
use App\Models\ZoneArea;
use App\Services\AreaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    private $areaService;
    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;
        parent::__construct('area');
    }
    public function index(Request $request)
    {
        if (url()->current() == route('admin-areas-list-in-active')) {
            \request()->request->add(['inactive' => true]);
            $areas = $this->areaService->search($request, true);
            return view("admin.areas.inactive", compact('areas'));
        }else{
            $areas = $areas = $this->areaService->search($request, true);
            return view("admin.areas.list", compact('areas'));
        }
    }

    public function save(AreaRequest $request)
    {

        $state_id = $request->state_id;
        $title = $request->name;
        if (empty($request->area_id)) {
            $exist = Area::where([
                'state_id' => $state_id,
                'title' => $title
            ])->first();
        } else {
            $exist = Area::where([
                'state_id' => $state_id,
                'title' => $title,
            ])->where('id', '!=', $request->area_id)->first();
        }
        $validator = Validator::make($request->all(), []);

        if ($exist) {
            return response()->json(['errors' => ['name' => [$title . ' already taken']]], 422);
        }
        $area = $this->areaService->save($request);

        if (!empty($request->area_id)){
            return response()->json(['message' => 'Area updated successfully', 'data' => $area]);
        }
        return response()->json(['message' => 'Area created successfully', 'data' => $area]);
    }

    public function delete(Request $request)
    {
        $id = $request->area_id;
        $area = Area::find($id);
        if ($area){
            $area->deleted_at = Carbon::now();
            $area->save();
            ZoneArea::whereAreaId($id)->delete();
        }

        flash('Area deleted successfully')->success();
        return redirect()->back();
    }

    public function status(Request $request)
    {
        $id = $request->area_id;
        $status = $request->status_id;
        $area = Area::find($id);

        if ($area){
            $area->is_active = $status;
            if ($status == IStatus::DISABLE){
                BusinessArea::whereAreaId($id)->delete();
                ZoneArea::whereAreaId($id)->delete();
            }
            $area->save();
        }
        flash('Area status update successfully')->success();
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->area_id;
        $areaIds = explode(',',$ids);
        foreach ($areaIds as $id){
            $area = Area::find($id);
            if ($area){
                $area->deleted_at = Carbon::now();
                $area->save();
                ZoneArea::whereAreaId($id)->delete();
            }
        }
        flash('Areas deleted successfully')->success();
        return redirect()->route('admin-areas-list');
    }

    public function bulkStatus(Request $request)
    {
        $ids = $request->area_id;
        $areaIds = explode(',',$ids);
        $status = $request->status_id;
        foreach ($areaIds as $id) {
            $area = Area::find($id);

            if ($area) {
                $area->is_active = $status;
                if ($status == IStatus::DISABLE) {
                    BusinessArea::whereAreaId($id)->delete();
                    ZoneArea::whereAreaId($id)->delete();
                }
                $area->save();
            }
        }
        flash('Areas status update successfully')->success();
        return redirect()->back();
    }

    public function edit(Request $request, $id)
    {
        $editArea = Area::find($id);
        $editArea = (new AreaResource($editArea))->toArray($request);
        $areas = $this->areaService->search($request, true);

        if ($request->session()->previousUrl() == route('admin-areas-list-in-active')){
            request()->request->add(['inactive' => true]);
            $areas = $this->areaService->search($request, true);
        }

        if ($editArea) {
            return view("admin.areas.list", compact('areas','editArea'));
        }
        return view("admin.areas.list", compact('areas'));
    }
}
