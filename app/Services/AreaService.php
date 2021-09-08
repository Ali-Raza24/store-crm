<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Models\Area;

class AreaService
{

    public function findById($id)
    {
        return Area::find($id);
    }

    public function save($request)
    {
        if ($request->id) {
            $area = $this->findById($request->id);
        } else {
            $area = new Area();
        }

        $area->title = $request->name;
        $area->state_id = $request->state_id;
        $area->delivery_company_id = isset($request->delivery_company_id) ? $request->delivery_company_id : 0;
        $area->lat = $request->lat;
        $area->lng = $request->lng;
        $area->address = $request->address;
        $area->save();
        return $area;
    }

    public function search($request = null, $paginate = false)
    {
        $areas = new Area();
        $areas = $areas->whereNull('deleted_at');
        if (!empty($request->active)) {
            $areas = $areas->whereIsActive(IStatus::ACTIVE);
        }
        if (!empty($request->inactive)){
            $areas = $areas->whereIsActive(IStatus::DISABLE);
        }

        if ($request->state){
            $areas = $areas->whereIn('state_id', $request->state);
        }

        if ($paginate){
            return $areas->paginate(AppConstants::PAGINATE_LARGE);
        }
        return $areas->get();
    }
}
