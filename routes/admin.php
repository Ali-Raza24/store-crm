<?php

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UtilsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth','auth.admin']], function () {
    Route::get("/", [HomeController::class, 'index'])->name("admin-home");

    Route::get("/dashboard", [HomeController::class, 'index'])->name("admin-dashboard");

    Route::get("/areas", [AreaController::class, 'index'])->name("admin-areas-list");
    Route::get("/areas/in-active", [AreaController::class, 'index'])->name("admin-areas-list-in-active");

    Route::get("/reports", [ReportController::class, 'index'])->name("admin-reports");

    Route::group(["prefix" => "customers"], function () {
        Route::get("/", [CustomerController::class, 'index'])->name("admin-customers-list");
        Route::get("/active", [CustomerController::class, 'index'])->name("admin-customers-active-list");
        Route::get("/suspended", [CustomerController::class, 'index'])->name("admin-customers-suspended-list");
        Route::put('/customer/bulk/status',[CustomerController::class, 'bulkStatus'])->name('admin-customers-bulk-status');
    });

    Route::group(["prefix" => "orders"], function () {
        Route::get("/", [OrderController::class, 'index'])->name("admin-orders-list");
        Route::get("/detail/{id}", [OrderController::class, 'detail'])->name("admin-orders-detail");
        Route::get("/un-success", [OrderController::class, 'index'])->name("admin-orders-list-un-success");
    });

    Route::group(["prefix" => "business"], function () {
        Route::get("/", [BusinessController::class, 'index'])->name("admin-business-list");
        Route::put("/update", [BusinessController::class, 'update'])->name("admin-business-update");
        Route::get("/edit/{id}/staff", [BusinessController::class, 'edit'])->name("admin-business-staff");
        Route::get("/edit/{id}/transactions", [BusinessController::class, 'edit'])->name("admin-business-transactions");
        Route::get("/detail/{id}/staff", [BusinessController::class, 'detail'])->name("admin-business-detail-staff");
        Route::get("/detail/{id}/transactions", [BusinessController::class, 'detail'])->name("admin-business-detail-transactions");
        Route::get("/new", [BusinessController::class, 'index'])->name("admin-business-list-new");
        Route::get("/active", [BusinessController::class, 'index'])->name("admin-business-list-active");
        Route::get("/suspended", [BusinessController::class, 'index'])->name("admin-business-list-suspended");
        Route::get("/upcoming-payment", [BusinessController::class, 'index'])->name("admin-business-list-upcoming");
        Route::post('/add', [BusinessController::class, 'save'])->name('admin-business-add');
        Route::get("/edit/{id?}", [BusinessController::class, 'edit'])->name("admin-business-edit");
        Route::get("/detail/{id?}", [BusinessController::class, 'detail'])->name("admin-business-detail");
        Route::delete("/delete/{id?}", [BusinessController::class, 'destroy'])->name("admin-business-delete");
        Route::match(['post', 'delete'], "/bulk-delete", [BusinessController::class, 'bulkDelete'])->name("admin-business-bulk-delete");
        Route::match(['post', 'put'], "/status", [BusinessController::class, 'status'])->name("admin-business-status");
        Route::match(['post', 'put'], 'suspend-user', [UserController::class, 'suspend'])->name('suspend-user');
    });

    Route::group(["prefix" => "settings"], function () {

        Route::post('/update-logo', [SettingController::class, 'updateLogo'])->name('update-logo');
        //settings
        Route::post("/company-information-save", [SettingController::class, 'AdminCompanyInfoSave'])->name("admin-company-page-store");
        //Pages
        Route::get("/pages", [SettingController::class, 'pages'])->name("admin-page-setting");
        Route::get("/company", [SettingController::class, 'company'])->name("admin-company-setting");
        Route::get('/payment', [SettingController::class, 'payment'])->name('admin-payment-setting');
        Route::post('/payment', [SettingController::class, 'payment'])->name('admin-payment-setting-save');
//        Route::get("/", [SettingController::class, 'company'])->name("admin-company-setting");

        Route::get("/page/{id}/edit", [PageController::class, 'edit'])->name("admin-page-edit");
        Route::get("/page/add", [PageController::class, 'add'])->name("admin-page-add"); //add/edit home page
        Route::get("/page/privacy-terms-add", [PageController::class, 'addPrivacyPolicy'])->name("admin-privacy-page-add"); //add/edit privacy plicy and terms conditions page
        Route::post("/page/privacy-terms-save", [PageController::class, 'privacyTermsStore'])->name("admin-privacy-page-store"); // save privacy policy and terms conditions pages
        Route::delete('/page/delete',[PageController::class, 'destroy'])->name('admin-page-delete');
        Route::delete('/pages/bulk/delete',[PageController::class, 'bulkDelete'])->name('admin-page-bulk-delete');
        Route::post("/page/save", [PageController::class, 'store'])->name("admin-page-store");
        Route::get('/pages/statuschange', [PageController::class, 'pageStatusUpdate'])->name('admin-Status-Update');
        Route::put('/pages/bulk/status',[PageController::class, 'bulkStatus'])->name('admin-page-bulk-status');

        //Testimonials
        Route::get('/testimonials/', [TestimonialController::class, 'index'])->name('admin-testimonials-tab');
        Route::post('/testimonial/add', [TestimonialController::class, 'save'])->name('admin-testimonials-add');
        Route::delete('/testimonials/delete',[TestimonialController::class, 'destroy'])->name('admin-testimonial-delete');
        Route::put('/testimonials/statuschange', [TestimonialController::class, 'testimonialStatusUpdate'])->name('testimonial-Status-Update');
        Route::get("/testimonial/{id}/edit", [TestimonialController::class, 'edit'])->name("admin-testimonial-edit");
        Route::put('/testimonials/bulk/status',[TestimonialController::class, 'bulkStatus'])->name('admin-testimonial-bulk-status');
        Route::delete('/testimonials/bulk/delete',[TestimonialController::class, 'bulkDelete'])->name('admin-testimonial-bulk-delete');
        //Featured Businesses tab
        Route::get('/businesses-tab/', [BusinessController::class, 'featuredBusinessesIndex'])->name('admin-businesses-tab');
        Route::get('/businesses/bulk/status',[BusinessController::class, 'BusinessesStatusUpdate'])->name('admin-businesses-bulk-status');



        // Route::resource("users", \App\Http\Controllers\Admin\UserController::class);
        Route::get("/user", [UserController::class, 'user'])->name("admin-user-list");
        Route::get("/user/add", [UserController::class, 'add'])->name("admin-user-add");
        Route::delete("/user/delete/{id}", [UserController::class, 'destroy'])->name("admin-user-delete");
        Route::post("/user", [UserController::class, 'store'])->name("admin-user-store");
        Route::get("/user/{id}/edit", [UserController::class, 'edit'])->name("admin-user-edit");
        Route::PUT("/user/{id}", [UserController::class, 'update'])->name("admin-user-update");


        // Route::resource('roles', RoleController::class);
        Route::get("/roles", [RoleController::class, 'index'])->name("admin-role-list");
        Route::get("/roles/add", [RoleController::class, 'add'])->name("admin-role-add");
        Route::get("/roles/{id}/edit", [RoleController::class, 'edit'])->name("admin-role-edit");
        Route::post("/roles", [RoleController::class, 'store'])->name("admin-role-store");
        Route::PUT("/roles/{id}", [RoleController::class, 'update'])->name("admin-role-update");

        Route::get("/plans", [SettingController::class, 'plans'])->name("admin-plans-setting")->permission('plan-list');
        //Change Users Status


        Route::get("/plans", [PlanController::class, 'index'])->name("admin-plans-setting");
        Route::get("/plan/add", [PlanController::class, 'create'])->name("admin-plans-add");
        Route::delete("/plan/delete", [PlanController::class, 'destroy'])->name("admin-plans-delete");
        Route::post("/plan/save", [PlanController::class, 'store'])->name("admin-plans-store");
        Route::get("/plan/{id}/edit", [PlanController::class, 'edit'])->name("admin-plans-edit");
        Route::PUT("/plan/{id}", [PlanController::class, 'update'])->name("admin-plans-update");
        Route::post('/plan/statuschange', [PlanController::class, 'planStatusUpdate'])->name('plan-Status-Update');

    });
});

Route::group(['middleware' => 'auth'], function (){
    Route::post('/areas/save',[AreaController::class, 'save']);
    Route::get('/areas/edit/{id}',[AreaController::class, 'edit'])->name('admin-area-edit');
    Route::delete('/areas/delete',[AreaController::class, 'delete'])->name('admin-area-delete');
    Route::delete('/areas/bulk/delete',[AreaController::class, 'bulkDelete'])->name('admin-area-bulk-delete');
    Route::put('/areas/status',[AreaController::class, 'status'])->name('admin-area-status');
    Route::put('/areas/bulk/status',[AreaController::class, 'bulkStatus'])->name('admin-area-bulk-status');
    Route::get('business-types', [UtilsController::class, 'getBusinessTypes'])->name('business-types');
    Route::get('industries', [UtilsController::class, 'industries'])->name('industries');
    Route::get('countries', [UtilsController::class, 'countries'])->name('countries');
    Route::get('states', [UtilsController::class, 'states'])->name('states');
    Route::get('states-list', [UtilsController::class, 'statesList'])->name('states-list');
    Route::match(['post','put'], 'update-plan',[BusinessController::class, 'updatePlan'])->name('update-plan');
    Route::put('update-plan',[BusinessController::class, 'updatePlan'])->name('update-plan');
    Route::match(['post','put'],'update_business_status',[BusinessController::class, 'updateStatus'])->name('update_business_status');
    Route::get('/users/statuschange', 'App\Http\Controllers\Admin\UserController@userStatusUpdate')->name('userStatusUpdate');
    Route::get('/get_business_status_list', [BusinessController::class, 'getBusinessStatus'])->name('get-business-status');

    Route::get('plan-values/{val?}', [PlanController::class, 'planOptionValue'])->name('plan-option-value');
    Route::get('plan-value-text/{val?}', [PlanController::class, 'planOptionText'])->name('plan-option-text');

    Route::post('admin-business-login', [LoginController::class, 'adminBusinessLogin'])->name('admin-business-login');
    Route::post('admin-business-logout', [LoginController::class, 'adminBusinessLogout'])->name('admin-business-logout');
    Route::match(['get', 'post'],'aramex-integrate', [SettingController::class, 'aramex'])->name('aramex-integrate');

});
