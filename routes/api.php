<?php

use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




/*Route::get('/product', function () {
    return response()->json([
        'categories' => [
            [
                'id' => 1,
                'title' => 'cate1',
                'products' => [
                    [

                    ]
                ]
            ],
            [
                'id' => 1,
                'title' => 'cate1',
                'products' => [
                    [
                        'id' => 1,
                        'title' => 'Product',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, eum id itaque natus perspiciatis qui!',
                        'brand' => [
                            'id' => 1,
                            'name' => 'brand',
                        ],
                        'is_available' => false,
                        'cost_price' => 20.00,
                        'retail_price' => 30.00,
                        'discounted_price' => 5.00,
                        'has_addons_or_variants' => 1,
                        'addons' => [
                            [
                                'id' => 1,
                                'name' => 'addon1',
                                'price' => 50.00,
                            ],
                            [
                                'id' => 2,
                                'name' => 'addon2',
                                'price' => 60.00,
                            ],
                            [
                                'id' => 3,
                                'name' => 'addon3',
                                'price' => 50.00,
                            ]
                        ],
                        'variants' => [
                            [
                                'id' => 1,
                                'name' => 'red / small',
                                'cost_price' => 20.00,
                                'retail_price' => 30.00,
                                'discounted_price' => 5.00,
                                'options' => [
                                    0 => 1,
                                    1 => 6,
                                    2 => 11
                                ]
                            ],
                            [
                                'id' => 2,
                                'name' => 'color',
                                'cost_price' => 20.00,
                                'retail_price' => 30.00,
                                'discounted_price' => 5.00,
                                'options' => [
                                    0 => 3
                                ]
                            ],
                            [
                                'id' => 3,
                                'name' => 'color',
                                'option' => 'red',
                                'cost_price' => 20.00,
                                'retail_price' => 30.00,
                                'discounted_price' => 5.00,
                                'options' => [
                                    0 => 4,
                                    1 => 7
                                ]
                            ]
                        ],
                        'product_variants' => [
                            'color' => [
                                1 => 'red',
                                2 => 'green',
                                3 => 'blue',
                                4 => 'yellow',
                                5 => 'black'
                            ],
                            'size' => [
                                6 => 'sm',
                                7 => 'md',
                                8 => 'lg',
                                9 => 'xl',
                                10 => 'xxl'
                            ],
                            'stuff' => [
                                11 => 'cotton',
                                12 => 'polyester'
                            ]
                        ],
                        'images' => [
                            'https://images.unsplash.com/photo-1562135291-7728cc647783?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1900&q=80',
                            'https://images.unsplash.com/photo-1562135291-7728cc647783?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1900&q=80',
                            'https://images.unsplash.com/photo-1562135291-7728cc647783?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1900&q=80',
                            'https://images.unsplash.com/photo-1562135291-7728cc647783?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1900&q=80',
                            'https://images.unsplash.com/photo-1562135291-7728cc647783?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1900&q=80',
                            'https://images.unsplash.com/photo-1562135291-7728cc647783?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1900&q=80',
                        ]
                    ]
                ]
            ]
        ]
    ]);
});*/
