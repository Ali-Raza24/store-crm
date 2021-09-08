<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:report-basic');
        $this->middleware('permission:report-advanced');
    }

    public function index(Request $request)
    {
        return view("business.reports.analytics");
    }
}
