<?php

namespace App\Http\Controllers\Api;

use App\Constants\IStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends ApiBaseController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $categories = Category::with(['products' => function($q) use ($request){
            $q->whereNull('deleted_at');
            $q->whereHas('stores', function ($q2) use ($request){
               $q2->whereStoreId($request->store_id);
            });
        }])->activeBusiness()->get();
        return $this->sendSuccess('OK', CategoryResource::collection($categories));
    }
}
