<?php

use App\Http\Controllers\AddonController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use Stripe\Product;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/
Route::group(['middleware' => ['auth','auth.business', 'user.subscribed', 'store.redirect']], function (){
    Route::post('/categories/add/', [CategoryController::class, 'store'])->name('category.create');
    Route::get('/categories/edit/{id}/', 'App\Http\Controllers\CategoryController@edit')->name('category.edit');
    Route::post('/category/update', 'App\Http\Controllers\CategoryController@updatecategory')->name('update.cat');
    Route::get('/categories', 'App\Http\Controllers\CategoryController@index')->name('categories.view');
    Route::delete('/categories/delete/{id}', 'App\Http\Controllers\CategoryController@destroy')->name('category.delete');
    Route::post('/categories/status-change/{id}', 'App\Http\Controllers\CategoryController@statusUpdate')->name('categories.statusupdate');
    Route::post('/categories/deletebrandsmultiple/', 'App\Http\Controllers\CategoryController@destroyMultiplesCategories')->name('categories.delete');
    Route::post('/categories/statuschangecategoriesmultiple', 'App\Http\Controllers\CategoryController@statusChangeMultiple')->name('brandsmulti.delete');
//Brand Api Routes
    Route::post('/brands/add/', ['App\Http\Controllers\BrandController', 'store'])->name('brand.create');
    Route::get('/brands/edit/{id}/', 'App\Http\Controllers\BrandController@edit')->name('brand.get');
    Route::post('/brands/update', 'App\Http\Controllers\BrandController@update')->name('update.brand');
    Route::post('/brands/status-change/{id}', 'App\Http\Controllers\BrandController@statusUpdate')->name('brans.view');
    Route::get('/brands', [BrandController::class, 'index'])->name('brans.view');
    Route::delete('/brands/delete/{id}', 'App\Http\Controllers\BrandController@destroy')->name('brand.delete');
    Route::post('/brands/deletebrandsmultiple/', 'App\Http\Controllers\BrandController@destroyMultiplesBrands')->name('brands.delete');
    Route::post('/brands/statuschangebrandsmultiple/', 'App\Http\Controllers\BrandController@statusChangeMultiple')->name('brandsmulti.delete');
//Addon Api Routes
    Route::post('/addons/add/', ['App\Http\Controllers\AddonController', 'store'])->name('addon.create');
    Route::get('/addons/edit/{id}/', 'App\Http\Controllers\AddonController@edit')->name('addon.get');
    Route::post('/addons/update', 'App\Http\Controllers\AddonController@update')->name('update.addon');
    Route::post('/addons/status-change/{id}', 'App\Http\Controllers\AddonController@statusUpdate')->name('addons.view');
    Route::get('/addons', 'App\Http\Controllers\AddonController@index')->name('addons.view');
    Route::delete('/addons/delete/{id}', 'App\Http\Controllers\AddonController@destroy')->name('addons.delete');
    Route::post('/addons/deleteaddonmultiple/', 'App\Http\Controllers\AddonController@destroyMultiplesRecords')->name('addons.delete');
    Route::post('/addons/statuschangeaddonsmultiple', 'App\Http\Controllers\AddonController@statusChangeMultiple')->name('addonsmulti.delete');

    Route::get('/areas/',[AreaController::class, 'index']);
    Route::get('/business-areas/',[AreaController::class, 'businessAreas']);
    Route::get('/stores',[StoreController::class, 'index']);
    Route::get('/stores-list',[AreaController::class, 'list']);
    Route::post('/business/save/areas',[AreaController::class, 'saveBusinessAreas']);
    Route::post('/stores/save/zones',[AreaController::class, 'saveZones']);
    Route::get('/stores/zones',[AreaController::class, 'zones']);
    Route::get('/business/areas/active',[AreaController::class, 'activeBusinessArea']);
    Route::post('/zone/areas/save',[AreaController::class, 'zoneAreasSave']);

    Route::get('/zone/areas/active',[AreaController::class, 'getActiveZoneAreas']);
    Route::post('/update/delivery',[AreaController::class, 'updateDelivery']);
    Route::get('/get-delivery-companies', [UtilsController::class, 'deliveryCompanies'])->name('delivery-companies');
    Route::get('/get_delivery_type', [BusinessController::class, 'getDeliveryType'])->name('business-delivery-type');
    Route::get('/get_delivery_store', [BusinessController::class, 'getDeliveryStore'])->name('business-delivery-store');
    Route::get('/change-store/{name?}/{toSetting?}', [StoreController::class, 'changeStore'])->name('change-store');
    Route::post('/delete-area/{id}',[AreaController::class, 'deleteArea'])->name('delete-area');
    Route::post('/delete-zone/{id}',[AreaController::class, 'deleteZone'])->name('delete-zone');
    Route::get('/areas/edit/{id}',[AreaController::class, 'edit'])->name('edit-area');
    Route::get('/zone/edit/{id}',[AreaController::class, 'editZone'])->name('edit-zone');

    Route::put('store-status',[StoreController::class, 'status'])->name('store-status');
    Route::get('/get_variant_options/{id}', [UtilsController::class, 'getVariantOptions'])->name('get-variant-option');

    Route::prefix('store-admin')->group(function (){
        Route::get('settings/general',
            [GeneralSettingsController::class, 'store'])->name('general-setting-store');
        Route::put('settings/general',
            [GeneralSettingsController::class, 'store'])->name('general-setting-store-update')->middleware('permission:store-info');
        Route::post('settings/general',
            [GeneralSettingsController::class, 'store'])->name('general-setting-store-update')->middleware('permission:store-info');
        Route::get('settings/general/account',
            [GeneralSettingsController::class, 'account'])->name('general-setting-account')->middleware('permission:account-info');
        Route::put('settings/general/account',
            [GeneralSettingsController::class, 'account'])->name('general-setting-account-update')->middleware('permission:account-info');
        Route::get('settings/general/password',
            [GeneralSettingsController::class, 'password'])->name('general-setting-password')->middleware('permission:account-info');
        Route::put('settings/general/password',
            [GeneralSettingsController::class, 'password'])->name('general-setting-password-update')->middleware('permission:account-info');
        Route::get('settings/general/order',
            [GeneralSettingsController::class, 'order'])->name('general-setting-order')->middleware('permission:order-setting');
        Route::put('settings/general/order',
            [GeneralSettingsController::class, 'order'])->name('general-setting-order-update')->middleware('permission:order-setting');
        Route::get('settings/general/payment',
            [GeneralSettingsController::class, 'payment'])->name('general-setting-payment')->middleware('permission:payment-setting');
        Route::put('settings/general/payment',
            [GeneralSettingsController::class, 'payment'])->name('general-setting-payment-update')->middleware('permission:payment-setting');
        /*Route::get('settings/general/notification',
            [GeneralSettingsController::class, 'notification'])->name('general-setting-notification');*/
        Route::put('settings/general/notification',
            [GeneralSettingsController::class, 'notification'])->name('general-setting-notification-update')->middleware('permission:notification-setting');
        Route::get('settings/general/checkout',
            [GeneralSettingsController::class, 'checkout'])->name('general-setting-checkout')->middleware('permission:checkout-setting');
        Route::put('settings/general/checkout',
            [GeneralSettingsController::class, 'checkout'])->name('general-setting-checkout-update')->middleware('permission:checkout-setting');

        Route::get('settings/general/fb-pixel',
            [GeneralSettingsController::class, 'fbPixel'])->name('general-setting-fb-pixel');
        Route::put('settings/general/fb-pixel',
            [GeneralSettingsController::class, 'fbPixel'])->name('general-setting-fb-pixel-update');

        // Route::resource("users", \App\Http\Controllers\UserController::class);
        Route::get("/user", [UserController::class, 'user'])->name("user-list");
        Route::get("/user/add", [UserController::class, 'add'])->name("user-add");
        Route::delete("/user/delete/{id}", [UserController::class, 'destroy'])->name("user-delete");
        Route::post("/user", [UserController::class, 'store'])->name("user-store");
        Route::get("/user/{id}/edit", [UserController::class, 'edit'])->name("user-edit");
        Route::PUT("/user/status", [UserController::class, 'userStatusUpdate'])->name("user-status");
        Route::PUT("/user/{id}", [UserController::class, 'update'])->name("user-update");

        // Route::resource('roles', RoleController::class);
        Route::get("/roles", [RoleController::class, 'index'])->name("role-list");
        Route::get("/roles/add", [RoleController::class, 'add'])->name("role-add");
        Route::get("/roles/{id}/edit", [RoleController::class, 'edit'])->name("role-edit");
        Route::post("/roles", [RoleController::class, 'store'])->name("role-store");
        Route::PUT("/roles/{id}", [RoleController::class, 'update'])->name("role-update");


        Route::put('products/status/bulk', [ProductController::class, 'bulkStatus'])->name('product-bulk-status');
        Route::put('products/status', [ProductController::class, 'status'])->name('product-status');
        Route::delete('products/delete', [ProductController::class, 'destroy'])->name('product-delete');

        Route::delete('products/delete/bulk', [ProductController::class, 'bulkDelete'])->name('product-bulk-delete');

        Route::post('products', [ProductController::class, 'store'])->name('product-store');

        Route::get('product-export', [ProductController::class, 'export'])->name('product-export');
        Route::post('product-import', [ProductController::class, 'import'])->name('product-import');

        Route::post('products/images', [ProductController::class, 'uploadImage'])->name('product-image-upload');
        Route::post('products/images/validate', [ProductController::class, 'validateImage'])->name('product-image-validate');
        Route::delete('products/images', [ProductController::class, 'deleteImage'])->name('product-image-delete');

        Route::get('get_addons', [AddonController::class, 'getAddonsList'])->name('get-addons-list');

        Route::get('get_product_addons', [UtilsController::class,'getAddons'])->name('get-addons');

        Route::get('get_product_variants', [UtilsController::class,'getVariants'])->name('get-variants');
        Route::post('variant/images', [ProductController::class, 'uploadVariantImages'])->name('variant-image-upload');

        //Pages
        Route::get("/pages", [GeneralSettingsController::class, 'page'])->name("business-page-setting");
        Route::get("/page/{id}/edit", [PageController::class, 'edit'])->name("business-page-edit");
        Route::get("/page/add", [PageController::class, 'add'])->name("business-page-add");
        Route::delete('/page/delete',[PageController::class, 'destroy'])->name('business-page-delete');
        Route::delete('/pages/bulk/delete',[PageController::class, 'bulkDelete'])->name('business-page-bulk-delete');
        Route::post("/page/save", [PageController::class, 'store'])->name("business-page-store");
        Route::get('/pages/statuschange', [PageController::class, 'pageStatusUpdate'])->name('business-Status-Update');
        Route::put('/pages/bulk/status',[PageController::class, 'bulkStatus'])->name('business-page-bulk-status');
        Route::match(['get', 'post', 'put'],'page/main', [PageController::class, 'mainPage'])->name('business-main-page-setting');

        Route::resource('announcements', AnnouncementController::class)->except(['destroy','update']);
        Route::put('announcements/status', [AnnouncementController::class, 'statusUpdate'])->name('announcements.status');
        Route::delete('announcements/delete', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

        Route::post('/get-product-categories', [ProductController::class, 'categories'])->name('get-product-categories');

        Route::post('/order-comment/{id}',[OrderController::class, 'comment'])->name('order-comment');

        Route::post('update-product-variant',[ProductController::class, 'updateVariant'])->name('update-product-variant');
        Route::delete('delete-product-variant',[ProductController::class, 'deleteVariant'])->name('delete-product-variant');

        Route::post('/generate-code', [DiscountController::class, 'generateCode'])->name('generate-code');

        Route::post('/customer', [CustomerController::class, 'store'])->name('customer-store');
        Route::delete('/customer/delete/', [CustomerController::class, 'destroy'])->name('customers-delete');
        Route::delete('/customer/delete/bulk', [CustomerController::class, 'destroyBulk'])->name('customers-bulk-delete');

        Route::put('/customer/status/', [CustomerController::class, 'status'])->name('customers-status');
        Route::put('/customer/status/bulk', [CustomerController::class, 'statusBulk'])->name('customers-bulk-status');

        Route::get('order-export', [OrderController::class, 'export'])->name('order-export');

        Route::post('generate-invoice', [OrderController::class, 'generateInvoice'])->name('generate-invoice');

        Route::post('/get-store/{name}', [StoreController::class, 'getStore'])->name('get-store');
    });

    Route::get('get-all-brands', [BrandController::class, 'getAllBrands'])->name('get-all-brands');
    Route::get('get-all-categories', [CategoryController::class, 'getAllCategory'])->name('get-all-categories');

    Route::post('/save-store-locations', [StoreController::class, 'saveLocation'])->name('save-store-locations');
    Route::get('/get-store/{id}', [StoreController::class, 'getStoreById'])->name('get-store');

    Route::post('update-cropped-image', [UtilsController::class, 'updateCroppedImage'])->name('update-cropped-image');
});

Route::middleware('auth')->group(function (){
    Route::get('/search', [UtilsController::class, 'search']);
    Route::get('/notifications', [UtilsController::class, 'notifications'])->name('notifications');
    Route::put('/notification/read/{id}', [UtilsController::class, 'notificationRead'])->name('notification-read');
    Route::delete('/notification/delete/{id}', [UtilsController::class, 'notificationDelete'])->name('notification-read');
});

Route::group(['middleware' => ['auth', 'auth.business']], function (){

    Route::get('/upgrade-subscription', [SubscriptionController::class, 'upgrade'])->name('upgrade-subscription');
    Route::post('/upgrade-subscription', [SubscriptionController::class, 'upgrade'])->name('upgrade-subscription-post');
    Route::get('/downgrade-subscription', [SubscriptionController::class, 'downgrade'])->name('downgrade-subscription');
    Route::post('/downgrade-subscription', [SubscriptionController::class, 'downgrade'])->name('downgrade-subscription-post');

    Route::get('/subscribe', [PaymentController::class, 'payment'])->name('payment-form');
    Route::post('/subscribe', [PaymentController::class, 'charge'])->name('subscribe.post');
    Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment-success');
    Route::get('/payment-cancel', [PaymentController::class, 'cancel'])->name('payment-cancel');
    Route::get('/pro', function (){
        \Stripe\Stripe::setApiKey(config('cashier.secret'));

    });
});
