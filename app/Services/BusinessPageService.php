<?php

namespace App\Services;
use App\Constants\IStatus;
use App\Models\Image;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Str;

class BusinessPageService
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function save($request)
    {
        if (empty($request->page_id)){
            $page = new Page();
        }else{
            $page = Page::find($request->page_id);
        }

        $page->business_id = Auth::user()->business_id;
        $page->name = isset($page->name) ? $page->name : $request->name;
        $page->title = isset($page->title) ? $page->title : $request->title;
        $page->slug = isset($page->slug) ? $page->slug : Str::slug($request->title);
        $page->meta_discription = $request->meta_description;
        $page->heading = $request->heading;
        $page->sub_heading = $request->sub_heading;
        $page->content = htmlentities($request->content);
        $page->is_active = isset($page->is_active) ? $page->is_active : IStatus::ACTIVE;
        $page->save();

    }
    public function delete($id)
    {
        $page = Page::find($id);
        $page->deleted_at = Carbon::now();
        $page->save();
    }

    public function uploadImage($request)
    {
        $this->imageService->saveImage($request,$request->page_id, Page::class, 'page');
        return true;
    }

}
