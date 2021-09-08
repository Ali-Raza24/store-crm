<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Setting;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SettingController extends Controller
{
    private $RoleService;

    public function __construct(RoleService $roleService)
    {
        $this->RoleService = $roleService;
        $this->middleware('permission:store-info')->only('general');
    }

    public function general(Request $request)
    {
        $store = session()->get('store-data');
        $business = Business::find(Auth::user()->business_id);
        return view("business.settings.general", compact('store', 'business'));
    }

    public function product(Request $request)
    {
        return view("business.settings.product");
    }

    public function users()
    {
        return view("business.settings.user");
    }

    public function shipping()
    {
        return view("business.settings.shipping");
    }

    public function userRolesAdd()
    {
        return view("business.settings.user");
    }
}
