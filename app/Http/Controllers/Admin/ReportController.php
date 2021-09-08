<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:report-basic');
        $this->middleware('permission:report-advanced');
    }

    public function index(Request $request){
        return view("admin.reports.reports");
    }
}
