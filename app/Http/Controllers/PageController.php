<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\PageRequest;
use App\Models\Image;
use App\Models\Page;
use App\Services\BusinessPageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    private $businessPageService;

    public function __construct(BusinessPageService $businessPageService)
    {
        $this->businessPageService = $businessPageService;
        parent::__construct('page');
    }

    public function add()
    {
        $page = new Page();
        return view("business.settings.pages.add", ['page' => $page]);
    }

    public function store(PageRequest $request)
    {
        //return  $request->page_id;
        if (!empty($request->page_id)) {

            $page = Page::where('id', $request->page_id)->first();
        } else {
            $page = new Page();
        }
        if ($request->has('page_slug')) {
            $page->slug = str_slug($request->page_slug, "-");
        }

        if ($request->has('page_name')) {
            $page->name = $request->page_name;
        }
        if ($request->has('page_title')) {
            $page->title = $request->page_title;
        }
        if ($request->has('meta_description')) {
            $page->meta_discription = $request->meta_description;
        }
        if ($request->has('page_content')) {
            $page->content = $request->page_content;
        }
        if ($request->has('page_heading')) {
            $page->heading = $request->page_heading;
        }
        $page->business_id = Auth::user()->business_id;
        $page->is_active = 1;
        $page->save();
        //$page = $this->pageService->save($request);
        flash('Page Updated successfully.');
        //return 'your in';
        return redirect()->route('business-page-setting');
    }

    public function edit(Request $request, $id = false)
    {
        $page = Page::where('id', $id)->first();

        if ($page->slug == 'main-page') {
            return redirect()->route('business-main-page-setting');
        }
        return view("business.settings.pages.index", ['page' => $page]);
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function pageStatusUpdate(Request $request)
    {
        $page_id = $request->get('page_id');
        $status_id = $request->get('status_id');
        Page::where('id', $page_id)->update(['is_active' => $status_id]);

        if ($status_id == 1) {
            $resArr = array(
                'msg' => "Active",
                'flashMsg' => 'Page Status Activated successfully.'
            );

        } else {
            $resArr = array(
                'msg' => "InActive",
                'flashMsg' => 'Page Status Inactivated successfully.'
            );
        }

        return response()->json($resArr);
    }

    public function destroy(Request $request)
    {

        $this->businessPageService->delete($request->page_id);
        flash('Page Deleted successfully.');
        return redirect()->back()->with('messsage', 'deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->page_id;
        $pageIds = explode(',', $ids);
        foreach ($pageIds as $id) {
            $page = Page::find($id);
            if ($page) {
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
        $pageIds = explode(',', $ids);
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

    public function mainPage(Request $request)
    {
        session()->put('showMainPageTab', true);
        $rule = [];
        if ($request->getMethod() == Request::METHOD_POST) {
            if (!empty($request->mobile_banner)) {
                $rule = ['images.mobile_banner' => ['required', Rule::dimensions()->height('260')->width('400')]];
            }
            if (!empty($request->web_banner)) {
                $rule = ['images.web_banner' => ['required', Rule::dimensions()->height('240')->width('1115')]];
            }

            $validator = \Validator::make($request->all(), $rule, [
                'images.web_banner.required' => 'Web Banner Image is required',
                'images.web_banner.dimensions' => 'Please upload image of resolution 1115 X 240',
                'images.mobile_banner.required' => 'Mobile Banner Image is required',
                'images.mobile_banner.dimensions' => 'Please upload image of resolution 400 X 260',
            ]);
            $messages = $validator->getMessageBag()->toArray();
            if (\Arr::has($messages, 'images.web_banner')) {
                return response()->json(['error' => \Arr::first($messages['images.web_banner'])], 422);
            }
            if (\Arr::has($messages, 'images.mobile_banner')) {
                return response()->json(['error' => \Arr::first($messages['images.mobile_banner'])], 422);
            }

            if (!empty($request->images['web_banner']) && !\Arr::has($messages, 'images.web_banner')) {
                Image::where([
                    'imageable_type' => Page::class,
                    'imageable_id' => $request->page_id,
                    'key' => 'web_banner'
                ])->delete();
            }

            if (!empty($request->images['mobile_banner']) && !\Arr::has($messages, 'images.mobile_banner')) {
                Image::where([
                    'imageable_type' => Page::class,
                    'imageable_id' => $request->page_id,
                    'key' => 'mobile_banner'
                ])->delete();
            }

            $this->businessPageService->uploadImage($request);

            $page = Page::whereBusinessId(Auth::user()->business_id)->whereSlug('main-page')->first();
            return response()->json(['message' => "Images Uploaded", 'data' => $page]);
        }

        if ($request->getMethod() == Request::METHOD_PUT) {
            $this->businessPageService->save($request);
            flash('Page information updated successfully')->success();
            return redirect()->back();
        }

        $page = Page::where('slug', '=', 'main-page')->whereBusinessId(Auth::user()->business_id)->first();
        return view('business.settings.pages.main', compact('page'));
    }
}
