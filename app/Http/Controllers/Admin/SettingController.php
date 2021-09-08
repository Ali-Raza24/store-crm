<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInformationRequest;
use App\Models\Image;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserDetail;
use App\Services\ImageService;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    private $pageService;
    private $imageService;

    public function __construct(PageService $pageService, ImageService $imageService)
    {
        $this->pageService = $pageService;
        $this->imageService = $imageService;
        parent::__construct();
        $this->middleware('permission:update-company-info')->only(['company', 'AdminCompanyInfoSave']);
    }

    public function company(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $setting = json_decode(\setting('admin.social'));

        return view("admin.settings.general.company", compact('user', 'setting'));
    }

    public function AdminCompanyInfoSave(CompanyInformationRequest $request)
    {
        if ($request->name) {
            $user = User::find(Auth::user()->id);
            if ($user) {
                $user->name = $request->name;
                $user->save();
            }

            if ($request->details) {
                $detailsData = $request->details;
                $userDetail = UserDetail::where(['user_id' => Auth::user()->id])->first();
                if (!$userDetail) {
                    $userDetail = new UserDetail();
                }
                $userDetail->user_id = Auth::user()->id;
                $userDetail->mobile = $detailsData['mobile'];
                $userDetail->phone = $detailsData['phone'];
                $userDetail->about = $detailsData['about'];
                $userDetail->address = $detailsData['address'];
                $userDetail->country_id = $detailsData['country_id'];
                $userDetail->state_id = $detailsData['state_id'];
                $userDetail->save();
            }

            if ($request->social){
                $setting = Setting::where(['key' => 'admin.social', 'business_id' => 0])->first();
                if ($setting){
                    $setting->delete();
                }

                $setting = new Setting();
                $setting->business_id = 0;
                $setting->key = 'admin.social';
                $setting->value = json_encode($request->social);
                $setting->save();
            }

            flash('Company information updated successfully')->success();
        }
        return redirect()->route('admin-company-setting');
    }

    public function pages(Request $request)
    {
        $pages = $this->pageService->search($request);
        return view("admin.settings.pages.index", ['pages' => $pages]);
    }

    public function plans(Request $request)
    {
        return view("admin.settings.plans");
    }

    public function updateLogo(Request $request)
    {
        $image = Image::where(['imageable_id' => Auth::user()->id, 'imageable_type' => User::class, 'key' => 'user'])->first();
        if ($image){
            $image->delete();
        }
        $file = $request->file('images');
        $this->imageService->saveImageObj($file['user'],'user',Auth::user()->id, User::class,'users',100,100);
        flash('Logo update successfully')->success();
        return redirect()->back();
    }

    public function aramex(Request $request){
        $setting = \setting('aramex');
        $aramex = json_decode($setting);

        if ($request->getMethod() == Request::METHOD_POST){
            $request->validate([
                'email' => 'required',
                'password' => 'required',
                'account_number' => 'required',
                'account_pin' => 'required',
                'account_entity' => 'required',
                'account_country_code' => 'required',
                ''
            ]);
            $setting = Setting::where(['key' => 'aramex', 'business_id' => 0])->first();
            if ($setting){
                $setting->delete();
            }

            $setting = new Setting();
            $setting->business_id = 0;
            $setting->key = 'aramex';
            $setting->value = json_encode($request->except('_token'));
            $setting->save();

            flash('Setting update successfully')->success();
            return redirect()->back();
        }
        return view('admin.settings.general.aramex', compact('aramex'));
    }

    public function payment(Request $request)
    {
        $setting = \setting('admin.payment');
        $payment = json_decode($setting);

        if ($request->getMethod() == Request::METHOD_POST){
            $request->validate([
                'stripe_key' => 'required',
                'stripe_secret' => 'required',
            ]);
            $setting = Setting::where(['key' => 'admin.payment', 'business_id' => 0])->first();
            if ($setting){
                $setting->delete();
            }

            $setting = new Setting();
            $setting->business_id = 0;
            $setting->key = 'admin.payment';
            $setting->value = json_encode($request->except('_token'));
            $setting->save();

            flash('Payment setting update successfully')->success();
            return redirect()->back();
        }
        return view('admin.settings.general.payment', compact('payment'));
    }
}
