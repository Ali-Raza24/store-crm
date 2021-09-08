
<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\BusinessRegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StoreController;
use App\Models\Store;
use ExtremeSa\Aramex\Aramex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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

Route::get('/401', function () {
    return \view('errors.401');
});
Route::get('/403', function () {
    return \view('errors.403');
});
Route::get('/404', function () {
    return \view('errors.404');
});
Route::get('/419', function () {
    return \view('errors.419');
});
Route::get('/429', function () {
    return \view('errors.429');
});
Route::get('/500', function () {
    return \view('errors.500');
});
Route::get('/503', function () {
    return \view('errors.503');
});

Auth::routes();
Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);

Route::get("/email/verify/{id}/{hash}", [VerificationController::class, "verify"])->name("verification.verify");

Route::post("/resent-verification-link", [VerificationController::class, "resend"])->name("verification.resend");
Route::get("/reset-success", [ResetPasswordController::class, "resetSuccess"])->name("reset-success");

Auth::routes(['verify' => true]);
Route::post('/register', [BusinessRegisterController::class, 'save']);

Route::get('verified',[VerificationController::class, 'verifiedSuccess'])->name('verified-success');

Route::group(['middleware' =>  ['auth', 'auth.business', 'user.subscribed']], function (){
    Route::get("/store-create", [StoreController::class, "create"])->name("store-create");
    Route::post("/store-create", [StoreController::class, "store"])->name("store-save");

    Route::get("/store-select", [StoreController::class, "index"])->name("store-select");
});

Route::group(["prefix" => "/store-admin", 'middleware' => ['auth', 'auth.business', 'user.subscribed', 'store.redirect']], function () {
    Route::get("/", [HomeController::class, "index"])->name("business-dashboard");
    Route::get("/dashboard", [HomeController::class, "index"])->name("business-dashboard");


    //Discounts
    //Route::get("/areas", [DiscountController::class, 'index'])->name("admin-areas-list");
    Route::get("/discount/active", [DiscountController::class, 'index'])->name("discount-list-active");
    Route::get("/discount/expires", [DiscountController::class, 'index'])->name("discount-list-expire");
    Route::get("/discount", [DiscountController::class, "index"])->name("discount-list");
    // Route::get("/discount/add", [DiscountController::class, 'add'])->name("discount-add");
    Route::delete("/discount/delete/", [DiscountController::class, 'destroy'])->name("discount-delete");
    Route::post("/discount", [DiscountController::class, 'store'])->name("discount-store");
    Route::get("/discount/statusChange", [DiscountController::class, 'statusChange'])->name("discount-statuschange");
    Route::get("/discount/codeCheck", [DiscountController::class, 'discountCodeCheck'])->name("discount-discountcodecheck");
    Route::PUT("/discount/bulk-status", [DiscountController::class, 'bulkStatus'])->name("discount-bulk-status");
    Route::put('/discount/status',[DiscountController::class, 'statusUpdate'])->name('discount-status');
    Route::get("/discount/{id}/edit", [DiscountController::class, 'edit'])->name("discount-edit");
    Route::PUT("/discount/{id}", [DiscountController::class, 'update'])->name("discount-update");
    Route::delete('/discounts/bulk/delete',[DiscountController::class, 'bulkDelete'])->name('discount-bulk-delete');



    Route::get("/analytics", [AnalyticsController::class, "index"])->name("analytics");

    /*Route::get("/store", function () {
        return view("business.stores.select");
    })->name("stores-select");

    Route::get("/store/add", function () {
        return view("business.stores.add");
    })->name("stores-add");*/

    Route::group(["prefix" => "customers"], function () {
        Route::get("/", [CustomerController::class, "index"])->name("customers-list");
        Route::get("/detail/{id}", [CustomerController::class, "detail"])->name("customers-detail");
        Route::get("/edit/{id}", [CustomerController::class, "edit"])->name("customers-edit");
    });

    Route::group(["prefix" => "orders"], function () {

        Route::get("/", [OrderController::class, "index"])->name("orders-list");
        Route::get("/unpaid", [OrderController::class, "index"])->name("orders-list-unpaid");
        Route::get("/delivery-out", [OrderController::class, "index"])->name("orders-list-delivery-out");
        Route::get("/unfulfilled", [OrderController::class, "index"])->name("orders-list-unfulfilled");

        Route::put('/status/{type}',[OrderController::class, 'status'])->name('order-status');
        Route::put('/bulk/status/{type}',[OrderController::class, 'bulkStatus'])->name('order-bulk-status');

        /*Route::get("/change-order-product", [OrderController::class, "changeOrderProduct"])->name("change-order-product");
        Route::PUT("/order/bulk-payment-status", [OrderController::class, 'bulkOrderPaymentStatus'])->name("order-bulk-Payment-status");
        Route::PUT("/order/bulk-status", [OrderController::class, 'bulkOrderStatus'])->name("order-bulk-status");

        Route::get("/change-status-orders", [OrderController::class, "updateOrderStatus"])->name("change-status-orders");
        Route::get("/change-fulfillment-status-orders", [OrderController::class, "updateOrderFulfillmentStatus"])->name("change-fulfillment-status-orders");*/
        Route::get("/add", [OrderController::class, "add"])->name("orders-add");
        Route::get("/detail/{id}", [OrderController::class, "detail"])->name("orders-detail");
        Route::get("/edit/{id}", [OrderController::class, "edit"])->name("orders-edit");
        Route::post("/update/{id}", [OrderController::class, "update"])->name("orders-update");
        Route::get("/cancel/{id}", [OrderController::class, "cancel"])->name("orders-cancel")->middleware('permission:order-cancel');
        Route::get("/refund/{id}", [OrderController::class, "refund"])->name("orders-refund")->middleware('permission:order-refund');
        Route::get("/invoice/{id}", [OrderController::class, "invoice"])->name("orders-invoice");
    });

    Route::group(["prefix" => "products"], function () {
        Route::get("/", [ProductController::class, "index"])->name("products-list");
        Route::get("/create", [ProductController::class, "create"])->name("products-create");
        Route::get("/discounted", [ProductController::class, "index"])->name("products-list-discounted");
        Route::get("/inactive", [ProductController::class, "index"])->name("products-list-inactive");
        Route::get("/edit/{id}", [ProductController::class, "edit"])->name("products-edit");
    });

    Route::group(["prefix" => "settings"], function () {
//        Route::get("/general", [SettingController::class, "general"])->name("general-setting");
        Route::get("/product", [SettingController::class, "product"])->name("product-setting");
        Route::get("/user", [SettingController::class, "users"])->name("user-setting");
        Route::get("/user-role", [SettingController::class, "add"])->name("rolesadd-add");
        Route::get("/shipping", [SettingController::class, "shipping"])->name("shipping-delivery-setting")->permission('shipping-general|shipping-areas|zone');
    });

    Route::post('shipment-create/{id}', [OrderController::class, 'createShipment'])->name('aramex-shipment-create');
    Route::post('label-print/{id}', [OrderController::class, 'labelPrint'])->name('aramex-label-print');
    Route::post('pickup-create/{id}', [OrderController::class, 'createPickup'])->name('aramex-pickup-create');
    Route::post('shipment-track/{id}', [OrderController::class, 'trackShipment'])->name('aramex-shipment-track');
});


Route::get('get-states', function (){
    dd(Aramex::fetchStates()->setCountryCode('AE')->run()->getStates());
});
