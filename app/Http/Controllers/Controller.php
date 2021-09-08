<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct($permissionController = null)
    {
        if ($permissionController) {

            $this->middleware('permission:' . $permissionController . '-list');
            $this->middleware('permission:' . $permissionController . '-create')->only(['create', 'store', 'add']);
            $this->middleware('permission:' . $permissionController . '-edit')->only(['edit', 'update']);
            $this->middleware('permission:' . $permissionController . '-delete')->only(['destroy']);
            $this->middleware('permission:' . $permissionController . '-view')->only(['show','detail']);
        }
    }
}
