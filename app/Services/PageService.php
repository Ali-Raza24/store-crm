<?php

namespace App\Services;
use App\Constants\AppConstants;
use App\Models\Image;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PageService
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function search($request)
    {
        $pages = Page::whereNull('deleted_at');

        if ($request->business_id){
            $pages = $pages->whereBusinessId($request->business_id);
        } else {
            $pages = $pages->whereBusinessId(0);
        }
        return $pages->paginate(AppConstants::PAGINATE_SMALL);
    }

    public function save($request)
    {
        if (!empty($request->page_id)) {
            $page = Page::where('id',$request->page_id)->first();
        } else {
            $page = new Page();
        }

        if( $request->has('content[page][name]') ){
            $page->slug = str_slug($request['content']['page']['title'] ,"-");

        }

        if(!empty($request['content']['page']['name']) ){

            $page->name = $request['content']['page']['name'];
        }
        if(!empty($request['content']['page']['title'])){
            $page->title = $request['content']['page']['title'];
        }
        if( $request->has('content') ){
            $page->content = json_encode($request['content']);
        }
        if(!empty($request['content']['page']['name']) ){
            $page->heading = $request->page_heading;
        }
        $page->business_id = Auth::user()->business_id;
        $page->is_active = 1;
        $page->save();
        if ($request->has('images')) {

            $this->imageService->saveImage($request, $page->id, Page::class, "pages");
        }

    }
    public function savePrivacyTermsPages($request)
    {

        if(!empty($request->page_id)) {

            $page = Page::where('id',$request->page_id)->first();
        } else {
            $page = new Page();
        }

        if( $request->has('content[page][name]') ){
            $page->slug = str_slug($request['content']['page']['title'] ,"-");

        }

        if(!empty($request->name) ){

            $page->name = $request->name;
        }
        if(!empty($request->title)){
            $page->title = $request->title;
        }
        if( $request->has('content') ){

            $page->content = json_encode($request['content']);
        }
        if(!empty($request->page_heading) ){
            $page->heading = $request->page_heading;
        }
        if(!empty($request->meta_discription) ){
            $page->meta_discription = $request->meta_discription;
        }
        $page->business_id = Auth::user()->business_id;
        $page->is_active = 1;
        $page->save();

    }

    public function delete($id)
    {
        $page = Page::find($id);
        $page->deleted_at = Carbon::now();
        $page->save();


    }
}
