<?php

namespace App\Http\Controllers;

use App\Constants\IStatus;
use App\Models\BusinessAnnouncements;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{

    public function __construct($permissionController = 'announcement')
    {
        parent::__construct($permissionController);
    }

    public function index(Request $request)
    {
        $announcements = BusinessAnnouncements::whereNull('deleted_at')->whereBusinessId(Auth::user()->business_id)->get();
        $model = new \stdClass();
        if (session()->has('announcement')){
            $model = BusinessAnnouncements::find(session()->get('announcement'));
        }
        return view('business.settings.announcements.index', compact('announcements', 'model'));
    }

    public function create(Request $request)
    {
        return view('business.settings.announcements.form');
    }

    public function store(Request $request)
    {
        $request->validate(['announcement' => 'required']);
        $announcements = BusinessAnnouncements::whereNull('deleted_at')->whereBusinessId(Auth::user()->business_id)->count('id');

        if ($announcements > 9){
            flash('Maximum 10 Announcements allowed')->error();
            return redirect()->route('announcements.index');
        }

        if (empty($request->announcement_id)){
            $announcement = new BusinessAnnouncements();
        }else{
            $announcement = BusinessAnnouncements::find($request->announcement_id);
        }
        $announcement->business_id = Auth::user()->business_id;
        $announcement->announcement = $request->announcement;
        $announcement->is_active = IStatus::ACTIVE;
        $announcement->save();
        if (session()->has('announcement')){
            session()->remove('announcement');
        }
        return redirect()->route('announcements.index');
    }

    public function edit($id)
    {
        session()->put('announcement', $id);
        return redirect()->route('announcements.index');
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request)
    {
        $announcement = BusinessAnnouncements::find($request->announcement_id);
        if ($announcement){
            $announcement->deleted_at = Carbon::now();
            $announcement->save();
            flash('Announcement deleted successfully')->success();
        }
        return redirect()->route('announcements.index');
    }

    public function statusUpdate(Request $request)
    {
        $announcement = BusinessAnnouncements::find($request->announcement_id);
        if ($announcement){
            $announcement->is_active = $request->status_id;
            $announcement->save();
            flash('Announcement status updated successfully')->success();
        }
        return redirect()->route('announcements.index');
    }
}
