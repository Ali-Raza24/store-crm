<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Models\Image;
use App\Models\Category;
use Carbon\Carbon;
use App\Services\CategoryService;
use App\Http\Requests\AddCategory;
use App\Http\Resources\CategoryResource;

class CategoryController extends ApiBaseController
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        parent::__construct('category');
    }
    public function index()
    {
        $categories = Category::where('business_id', 1)->whereNull('deleted_at')->paginate(5);
        if (is_null($categories)) {
            return $this->sendError('Categories not found.');
        } else {
            return $this->sendSuccess( 'Categories retrieved successfully.', CategoryResource::collection($categories), $categories);
        }
    }
    public function edit(Request $request, $category_id)
    {
        $category = $this->categoryService->findById($category_id);
        return $this->sendSuccess('Category retrieved successfully.',(new CategoryResource($category)));
    }

    public function store(AddCategory $request)
    {
        request()->request->add(['user_id' => 1]);
        request()->request->add(['business_id' => 1]);
        $category = $this->categoryService->save($request);
        if ($request->id){
            return $this->sendSuccess( 'Category updated successfully.');
        }
        return $this->sendSuccess('Category created successfully.');
    }
    public function statusUpdate(Request $request, $id)
    {

        if ($this->categoryService->findById($id)) {
            $this->categoryService->categoryStatusUpdate($id, $request->status);
            if($request->status==1){
                return $this->sendSuccess('Category Status Activated successfully.');
            }else{
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
        $this->categoryService->changeStatusMultiple($request->delete_data,$request->status);
        return $this->sendSuccess('Categories status updated successfully.');
    }

}
