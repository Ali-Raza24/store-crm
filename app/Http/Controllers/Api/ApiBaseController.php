<?php

namespace App\Http\Controllers\Api;


use Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class ApiBaseController extends Controller
{

    public function __construct($permissionController = null)
    {
        parent::__construct($permissionController);
    }

    public function sendError($message = '', $data = [], $error = '', $status = 200): JsonResponse
    {
        return response()->json([
            'status' => false,
            'data' => $data,
            'message' => $message,
            'error' => $error
        ],$status);
    }

    public function sendSuccess($message = '', $data = [], $paginate = []): JsonResponse
    {
        if (is_object($paginate)) {
            if (!empty($paginate->total())) {
                $paginate = $paginate->toArray();
                unset($paginate['data']);
            }
        }
        return response()->json([
            'status' => true,
            'data' => $data,
            'pagination' => $paginate,
            'message' => $message
        ]);
    }
}
