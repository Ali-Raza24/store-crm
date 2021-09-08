<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Models\Image;
use App\Services;
use App\Models\Testimonial;
use Carbon\Carbon;
use http\Env\Request;

class TestimonialService
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function findById($id)
    {
        return Testimonial::find($id);
    }

    public function save($request)
    {
        if (empty($request->testimonial_id)) {
            $testimonial = new Testimonial();
        } else {
            $testimonial = Testimonial::find($request->testimonial_id);
            if (!empty($request->images[0])) {
                Image::where(['imageable_id' => $testimonial->id, 'imageable_type' => Testimonial::class])->delete();
            }
        }
        if($request->has('testimonial_name')){

            $testimonial->name =$request->testimonial_name;
        }
        if($request->has('testimonial_message')){
            $testimonial->message = $request->testimonial_message;
        }
        if($request->has('testimonial_status')){
            $testimonial->is_active = $request->testimonial_status;
        }
        $testimonial->save();
        if ($request->has('images')) {


            $this->imageService->saveImage($request, $testimonial->id, Testimonial::class, "testimonials", 70, 70);
        }
    }

    public function delete($id)
    {
        $testimonial = Testimonial::find($id);

        $testimonial->deleted_at = Carbon::now();
        $testimonial->save();
        $image = Image::where('imageable_id', $id)->where('imageable_type', Testimonial::class)->first();
        if($image){
            $image->deleted_at = Carbon::now();
            $image->save();
        }
    }

    public function search($request){
       return $testimonials = Testimonial::whereNull('deleted_at')->paginate(AppConstants::PAGINATE_SMALL);
    }
}
