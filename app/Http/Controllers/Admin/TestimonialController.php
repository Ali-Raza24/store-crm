<?php

namespace App\Http\Controllers\Admin;

use App\Constants\IStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use App\Services\TestimonialService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestimonialController extends Controller
{
    private $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
        parent::__construct('testimonial');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        $testimonials = $this->testimonialService->search($request);
        return view("admin.settings.general.testimonials", ['testimonials' => $testimonials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(TestimonialRequest $request)
    {

        $this->testimonialService->save($request);
        if (empty($request->testimonial_id)) {
            flash('Testimonial created  successfully.')->success();
        } else {
            flash('Testimonial Updated successfully.')->success();
        }

        return redirect()->route('admin-testimonials-tab');
    }

    public function testimonialStatusUpdate(Request $request)
    {
        $id = $request->testimonial_id;
        $status = $request->status_id;
        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $testimonial->is_active = $status;
            $testimonial->save();
        }

        if ($status == IStatus::ACTIVE){
            flash('Testimonial status activated successfully.')->success();
        }else{
            flash('Testimonial status inactivated successfully.')->success();
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Testimonial $testimonial
     * @return Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Testimonial $testimonial
     * @return Application|Factory|View|Response
     */
    public function edit(Request $request)
    {

        $testimonialData = Testimonial::with('image')->where('id', $request->id)->first();

        $showTestimonialEdittab = "showTestimonialEdittab";

        $testimonials = $this->testimonialService->search($request);

        return view("admin.settings.general.testimonials",
            [
                'testimonials' => $testimonials,
                'showTestimonialEdittab' => $showTestimonialEdittab,
                'testimonialData' => $testimonialData
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Testimonial $testimonial
     * @return Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Testimonial $testimonial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Testimonial $testimonial)
    {

        $this->testimonialService->delete($request->testimonial_id);
        flash('Testimonial deleted successfully')->success();
        return redirect()->back()->with('messsage', 'deleted successfully');
    }

    public function bulkStatus(Request $request)
    {
        $ids = $request->testimonial_id;
        $testimonialsIds = explode(',', $ids);
        $status = $request->status_id;
        foreach ($testimonialsIds as $id) {
            $testimonial = Testimonial::find($id);

            if ($testimonial) {
                $testimonial->is_active = $status;
                $testimonial->save();
            }
        }
        if ($status == IStatus::ACTIVE){
            flash('Testimonial status activated successfully.')->success();
        }else{
            flash('Testimonial status inactivated successfully.')->success();
        }
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->testimonial_id;
        $testimonialsIds = explode(',', $ids);
        foreach ($testimonialsIds as $id) {
            $testimonial = Testimonial::find($id);
            if ($testimonial) {
                $testimonial->deleted_at = Carbon::now();
                $testimonial->save();

            }
        }
        flash('Testimonials deleted successfully')->success();
        return redirect()->route('admin-testimonials-tab');
    }
}
