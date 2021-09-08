<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Category Api Routes
Route::post('/categories/add/', 'App\Http\Controllers\Api\CategoryController@store')->name('api.category.create');
Route::get('/categories/edit/{id}/', 'App\Http\Controllers\Api\CategoryController@edit')->name('api.category.edit');
Route::post('/category/update', 'App\Http\Controllers\Api\CategoryController@updatecategory')->name('api.update.cat');
Route::get('/categories', 'App\Http\Controllers\Api\CategoryController@index')->name('api.categories.view');
Route::delete('/categories/delete/{id}', 'App\Http\Controllers\Api\CategoryController@destroy')->name('api.category.delete');
Route::post('/categories/status-change/{id}', 'App\Http\Controllers\Api\CategoryController@statusUpdate')->name('api.categories.statusupdate');
Route::post('/categories/deletebrandsmultiple/', 'App\Http\Controllers\Api\CategoryController@destroyMultiplesCategories')->name('api.categories.delete');
Route::post('/categories/statuschangecategoriesmultiple', 'App\Http\Controllers\Api\CategoryController@statusChangeMultiple')->name('api.brandsmulti.delete');
//Brand Api Routes
Route::post('/brands/add/', ['App\Http\Controllers\Api\BrandController', 'store'])->name('api.brand.create');
Route::get('/brands/edit/{id}/', 'App\Http\Controllers\Api\BrandController@edit')->name('api.brand.get');
Route::post('/brands/update', 'App\Http\Controllers\Api\BrandController@update')->name('api.update.brand');
Route::post('/brands/status-change/{id}', 'App\Http\Controllers\Api\BrandController@statusUpdate')->name('api.brans.view');
Route::get('/brands', 'App\Http\Controllers\Api\BrandController@index')->name('api.brans.view');
Route::delete('/brands/delete/{id}', 'App\Http\Controllers\Api\BrandController@destroy')->name('api.brand.delete');
Route::post('/brands/deletebrandsmultiple/', 'App\Http\Controllers\Api\BrandController@destroyMultiplesBrands')->name('api.brands.delete');
Route::post('/brands/statuschangebrandsmultiple/', 'App\Http\Controllers\Api\BrandController@statusChangeMultiple')->name('api.brandsmulti.delete');
//Addon Api Routes
Route::post('/addons/add/', ['App\Http\Controllers\Api\AddonController', 'store'])->name('api.addon.create');
Route::get('/addons/edit/{id}/', 'App\Http\Controllers\Api\AddonController@edit')->name('api.addon.get');
Route::post('/addons/update', 'App\Http\Controllers\Api\AddonController@update')->name('api.update.addon');
Route::post('/addons/status-change/{id}', 'App\Http\Controllers\Api\AddonController@statusUpdate')->name('api.addons.view');
Route::get('/addons', 'App\Http\Controllers\Api\AddonController@index')->name('api.addons.view');
Route::delete('/addons/delete/{id}', 'App\Http\Controllers\Api\AddonController@destroy')->name('api.addons.delete');
Route::post('/addons/deleteaddonmultiple/', 'App\Http\Controllers\Api\AddonController@destroyMultiplesRecords')->name('api.addons.delete');
Route::post('/addons/statuschangeaddonsmultiple', 'App\Http\Controllers\Api\AddonController@statusChangeMultiple')->name('api.addonsmulti.delete');
