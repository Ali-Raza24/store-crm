<?php

namespace App\Services;

use App\Models\Image;
use App\Services;
use App\Models\Brand;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class BrandService
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function findById($id)
    {
        return Brand::find($id);
    }

    public function save($request)
    {
        if (empty($request->id)) {
            $brand = new brand();
        } else {
            $brand = Brand::find($request->id);
            if (!empty($request->images[0])) {
                Image::where(['imageable_id' => $brand->id, 'imageable_type' => Brand::class])->delete();
            }
        }

        $brand->title = $request->title;
        $brand->business_id = Auth::user()->business_id;
        $brand->is_active = $request->is_active;
        $brand->save();

        if ($request->has('images')) {
            $this->imageService->save($request, $brand->id, Brand::class, "brands");
        }

        return $brand;
    }

    public function update($request)
    {
        $category = Brand::where('id', $request->post('brand_id'))->first();
        $category->title = $request->post('title');
        $category->business_id = Auth::user()->business_id;
        $category->is_active = $request->post('is_active');
        $category->update();
        if ($request->has('images')) {
            $this->imageService->update($request, $request->post('brand_id'), Brand::class);
        }
    }

    public function delete($id)
    {
        $brand = Brand::find($id);
        $brand->deleted_at = Carbon::now();
        $brand->save();
        $image = Image::where('imageable_id', $id)->where('imageable_type', Brand::class)->first();
        if ($image) {
            $image->delete();
        }

    }

    public function deleteMultiple($brand_ids)
    {

        foreach ($brand_ids as $id) {
            $brand = Brand::find($id);
            $brand->deleted_at = Carbon::now();
            $brand->save();
            $image = Image::where('imageable_id', $id)->where('imageable_type', Brand::class)->first();
            if ($image){
                $image->delete();
            }
        }

    }

    public function BrandStatusUpdate($id, $statusid)
    {
        $brand = $this->findById($id);
        $brand->is_active = $statusid;
        $brand->save();
    }
    public function changeStatusMultiple($brand_ids,$status)
    {
        foreach ($brand_ids as $id) {
            $brand = Brand::find($id);
            $brand->is_active = $status;
            $brand->save();
        }
    }
}
