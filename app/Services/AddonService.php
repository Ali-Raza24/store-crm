<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Models\Image;
use App\Services;
use App\Models\Addon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use function Sodium\add;

class AddonService
{
    private $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function findById($id)
    {
        return Addon::find($id);
    }

    public function save($request)
    {
        if (empty($request->id)) {
            $addon = new Addon();
        } else {
            $addon = Addon::find($request->id);
            if (!empty($request->images[0])) {
                Image::where(['imageable_id' => $addon->id, 'imageable_type' => Addon::class])->delete();
            }
        }

        $addon->title = $request->title;
        $addon->price = $request->price;
        $addon->business_id = Auth::user()->business_id;
//        if ($request->user_id) {
//            $addon->user_id = $request->user_id;
//        }
        $addon->is_active = $request->is_active;
        $addon->save();

        if ($request->has('images')) {
            $this->imageService->save($request, $addon->id, Addon::class, "addons");
        }
    }

    public function update($request)
    {
        $addon = Addon::where('id', $request->post('addon_id'))->first();
        $addon->title = $request->post('title');
        $addon->price = $request->post('price');
        $addon->business_id = Auth::user()->business_id;
        //$addon->user_id = $request->post('user_id');
        $addon->is_active = $request->post('is_active');
        $addon->update();
        if ($request->has('images')) {
            $this->imageService->update($request, $request->post('addon_id'), Addon::class);
        }
    }

    public function delete($id)
    {
        $addon = Addon::find($id);
        $addon->deleted_at = Carbon::now();
        $addon->save();
        $image = Image::where('imageable_id', $id)->where('imageable_type', Addon::class)->first();
        if ($image){
            $image->delete();
        }

    }

    public function deleteMultiple($addon_ids)
    {

        foreach ($addon_ids as $id) {
            $addon = Addon::find($id);
            $addon->deleted_at = Carbon::now();
            $addon->save();
            $image = Image::where('imageable_id', $id)->where('imageable_type', Addon::class)->first();
            if ($image){
                $image->delete();
            }
        }

    }

    public function BrandStatusUpdate($id, $statusid)
    {
        $addon = $this->findById($id);
        $addon->is_active = $statusid;
        $addon->save();
    }
    public function changeStatusMultiple($brand_ids,$status)
    {
        foreach ($brand_ids as $id) {
            $brand = Addon::find($id);
            $brand->is_active = $status;
            $brand->save();
        }
    }

    public function search($params = [])
    {
        $addon = Addon::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at');

        if (isset($params['addonIds'])) {
            $addon = $addon->whereIn('id',explode(',', $params['addonIds']));
        }

        if (isset($params['order_by_desc'])) {
            $addon = $addon->orderBy('id', 'DESC');
        }

        if (isset($params['paginate'])) {
            return $addon->paginate(AppConstants::PAGINATE_SMALL);
        }
        return $addon->get();
    }
}
