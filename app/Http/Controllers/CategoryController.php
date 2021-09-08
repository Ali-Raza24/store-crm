<?php

namespace App\Http\Controllers  ;

use App\Constants\AppConstants;
use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Http\Requests\AddCategory;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Auth;
use Illuminate\Http\Request;

class CategoryController extends ApiBaseController
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
//        parent::__construct('category');
        $this->middleware('permission:category-list');
        $this->middleware('permission:category-edit')->only(['edit','store','create']);
        $this->middleware('permission:category-delete')->only(['destroy']);
        $this->middleware('permission:category-status')->only(['statusUpdate']);
        $this->middleware('permission:category-bulk-status')->only(['statusChangeMultiple']);
        $this->middleware('permission:category-bulk-delete')->only(['destroyMultiplesCategories']);
    }

    public function index()
    {
        $categories = Category::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at')->orderBy('id', 'desc')->paginate(AppConstants::PAGINATE_SMALL);
        if (is_null($categories)) {
            return $this->sendError('Categories not found.');
        } else {
            return $this->sendSuccess('Categories retrieved successfully.', CategoryResource::collection($categories),
                $categories);
        }
    }

    public function edit(Request $request, $category_id)
    {
        $category = $this->categoryService->findById($category_id);
        return $this->sendSuccess('Category retrieved successfully.', (new CategoryResource($category)));
    }

    public function store(AddCategory $request)
    {

        $category = $this->categoryService->save($request);
        if ($request->id) {
            return $this->sendSuccess('Category updated successfully.');
        }
        return $this->sendSuccess('Category created successfully.', $category);
    }

    public function statusUpdate(Request $request, $id)
    {

        if ($this->categoryService->findById($id)) {
            $this->categoryService->categoryStatusUpdate($id, $request->status);
            if ($request->status == 1) {
                return $this->sendSuccess('Category Status Activated successfully.');
            } else {
                return $this->sendSuccess('Category Status Inactivated successfully.');
            }

        }
        return $this->sendError('Not Found');
    }

    public function destroy($category_id)
    {
        $this->categoryService->delete($category_id);
        return $this->sendSuccess('Category deleted successfully.');
    }

    public function destroyMultiplesCategories(Request $request)
    {

        $this->categoryService->deleteMultipleCategories($request->delete_data);
        return $this->sendSuccess('Categories deleted successfully.');
    }

    public function statusChangeMultiple(Request $request)
    {
        //return $request->delete_data;
        $this->categoryService->changeStatusMultiple($request->delete_data, $request->status);
        return $this->sendSuccess('Categories status updated successfully.');
    }

    public function getAllCategory(Request $request)
    {
        $search = $request->search;
        if ($search == ''){
            $brands = Category::whereBusinessId( Auth::user()->business_id)->whereNull('deleted_at')->orderBy('id', 'desc')->limit(AppConstants::PAGINATE_SMALL)->get();
        }else{
            $brands = Category::where('title','like','%'.$search.'%')->whereBusinessId( Auth::user()->business_id)->whereNull('deleted_at')->orderBy('id', 'desc')->limit(AppConstants::PAGINATE_SMALL)->get();
        }
        $response = array();
        /**
         * @var $brand Category
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
