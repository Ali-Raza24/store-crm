<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\AdminPrivacyPageRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Validator;
use App\Http\Requests\AdminPagesRequest;
use App\Services\PageService;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    private $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        parent::__construct('page');
    }

    public function store(AdminPagesRequest $request){
     //dd($request);
        $this->pageService->save($request);
        if (empty($request->page_id)) {
            flash('Page Created successfully.');
        } else {
            flash('Page Updated successfully.');
        }

        return redirect()->route('admin-page-setting');
   }
   public function privacyTermsStore(AdminPrivacyPageRequest $request){

       $this->pageService->savePrivacyTermsPages($request);
       if (empty($request->page_id)) {
           flash('Page Created successfully.');
       } else {
           flash('Page Updated successfully.');
       }

       return redirect()->route('admin-page-setting');
   }
    public function edit(Request $request,$id=false){
        $pageTitle='';
        if($id){
            $page = Page::where('id',$id)->first();
        }
        if(!empty($page) && $page->slug =='privacy-policy'){
            $pageTitle='privacy policy';
            return view("admin.settings.pages.privacy-terms-index",compact('page','pageTitle'));
        }
        elseif(!empty($page) && $page->slug =='terms-conditions'){
            $pageTitle='terms & conditions';
            return view("admin.settings.pages.privacy-terms-index",compact('page','pageTitle'));
        }
        elseif(!empty($page) && $page->slug =='home-page'){
            return view("admin.settings.pages.index",['page'=>$page]);
        }
        else{
            $page = new Page();
            return view("admin.settings.pages.index", ['page'=>$page]);
        }

    }
   public function update(){

   }
    public function add(){
        $page = new Page();
        return view("admin.settings.pages.index",['page'=>$page]);
    }

   public function delete(){

   }
    public function pageStatusUpdate(Request $request)
    {
        $page_id = $request->get('page_id');
        $status_id = $request->get('status_id');
        Page::where('id', $page_id)->update(['is_active' => $status_id]);
        if ($status_id == 1) {
            $resArr = array(
                'msg' => "Active",
            'flashMsg' =>'Page Status Activated successfully.'
            );

        }else {
            $resArr = array(
                'msg' => "InActive",
                'flashMsg' =>'Page Status Inactivated successfully.'
            );

        }

        return response()->json($resArr);
    }
    public function destroy(Request $request){
        $this->pageService->delete($request->page_id);
        flash('Page Deleted successfully.');
        return redirect()->back()->with('messsage','deleted successfully');
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->page_id;
        $pageIds = explode(',',$ids);
        foreach ($pageIds as $id){
            $page = Page::find($id);
            if ($page){
                $page->deleted_at = Carbon::now();
                $page->save();

            }
        }
        flash('Pages deleted successfully')->success();
        return redirect()->back();
    }
    public function bulkStatus(Request $request)
    {
        $ids = $request->page_id;
        $pageIds = explode(',',$ids);
        $status = $request->status_id;
        foreach ($pageIds as $id) {
            $page = Page::find($id);

            if ($page) {
                $page->is_active = $status;
                $page->save();
            }
        }
        flash('Pages Status Updated successfully')->success();
        return redirect()->back();
    }
}
