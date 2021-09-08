<?php

namespace App\Services;
use App\Models\Category;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function findById($id)
    {
        return Category::find($id);
    }
    public function save($request)
    {
        if (empty($request->id)) {
            $category = new Category();
        } else {
            $category = Category::find($request->id);
            if (!empty($request->images[0])) {
                Image::where(['imageable_id' => $category->id, 'imageable_type' => Category::class])->delete();
            }
        }

        $category->title = $request->title;
        $category->slug = \Str::slug($request->title);
        $category->business_id = Auth::user()->business_id;

        $category->is_active = $request->is_active;
        $category->save();

        if ($request->has('images')) {
            $this->imageService->save($request, $category->id, Category::class, "categories");
        }
        return $category;
    }
    public function update($request)
    {
        $category = Category::where('id',$request->post('category_id'))->first();
        $category->title = $request->post('title');
        $category->business_id = Auth::user()->business_id;
        $category->is_active = $request->post('is_active');
        $category->update();
        if($request->has('images')){
            $this->imageService->update($request, $request->post('category_id'), Category::class);
        }
    }
    public function delete($category_id){
        $category = Category::find($category_id);
        $category->deleted_at = Carbon::now();
        $category->save();
        $image = Image::where('imageable_id', $category_id)->where('imageable_type', Category::class)->first();

        if ($image) {
            $image->delete();
        }

    }
    public function deleteMultipleCategories($delete_Ids)
    {
        $category_idsDel[] = $delete_Ids;
        //return $delete_Ids;
        foreach ($delete_Ids as $id) {
            $category = Category::find($id);
            $category->deleted_at = Carbon::now();
            $category->save();

            $image = Image::where('imageable_id', $id)->where('imageable_type', Category::class)->first();
            if ($image) {
                $image->delete();
            }
        }

    }

    public function categoryStatusUpdate($id, $statusid)
    {
        $category = $this->findById($id);
        $category->is_active = $statusid;
        $category->save();
    }
    public function changeStatusMultiple($brand_ids,$status)
    {
        foreach ($brand_ids as $id) {
            $brand = Category::find($id);
            $brand->is_active = $status;
            $brand->save();
        }
    }
}
