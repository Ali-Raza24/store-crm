@extends('layouts.business.app')

@section('title','Add Order')

@section('content')
    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide text-center mt-4">
                <h2 class="dark-one font-weight-700 text-center">Order #100785794</h2>
                <ul class="pro-progress">
                    <li class="active">
                        <span>Placed</span>
                    </li>
                    <li>
                        <span>Paid</span>
                    </li>
                    <li>
                        <span>Processed</span>
                    </li>
                    <li>
                        <span>Delivered</span>
                    </li>
                    <li>
                        <span>Received</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="location-update pt-4">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-6 col-sm-6 order-md-1 order-sm-1 order-lg-0 mobile-hide">
                <div class="location">
                    <img src="{{asset('business_assets/images/location.png')}}" alt="">
                    <p>Al Jazzat - Sharjah - UAE</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="location-status mb-3 mb-lg-0">
                    <a href="invoice.blade.php"><img src="{{asset('business_assets/images/printer-white.png')}}" alt=""></a>
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropProcess" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Order Processing
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropProcess">
                            <a class="dropdown-item" href="javascript:void(0)">Unpaid</a>
                            <a class="dropdown-item" href="javascript:void(0)">Paid</a>
                            <a class="dropdown-item" href="javascript:void(0)">Pending</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="dropdown-toggle toggle-warning" type="button" id="dropUnpaid"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Order Unpaid
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropUnpaid">
                            <a class="dropdown-item" href="javascript:void(0)">Unpaid</a>
                            <a class="dropdown-item" href="javascript:void(0)">Paid</a>
                            <a class="dropdown-item" href="javascript:void(0)">Pending</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 order-md-1 order-sm-1 order-lg-0 desktop-hide">
                <div class="location">
                    <img src="{{asset('business_assets/images/location.png')}}" alt="">
                    <p>Al Jazzat - Sharjah - UAE</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 order-md-2 order-sm-2 order-lg-2">
                <div class="order-update text-right">
                    <a href="{{route('orders-detail',['id' => 1])}}" class="btn-primary btn-rounded">Order Update</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-md-8 col-sm-12">
            <div class="sf-order">
                <div class="table-responsive scroll-bar-thin">
                    <table class="table table-space first-tran v-middle order-table">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Product</th>
                            <th scope="col">Category</th>
                            <th scope="col">QTY</th>
                            <th scope="col">Discount %</th>
                            <th scope="col">Price</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="pro-img">
                                    <img src="{{asset('business_assets/images/pro-small.png')}}" alt="image">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropProd"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Chessy Club Sandwick
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropProd">
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropFfood"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Fast Food
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropFfood">
                                        <a class="dropdown-item" href="javascript:void(0)">Fast Food</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Fast Food</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Fast Food</a>
                                    </div>
                                </div>
                            </td>
                            <td class="border-dropdown">
                                <input type="text" value="2" class="form-control">
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropOper"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        0.00%
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropOper">
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 order-total">$42.20</p>
                            </td>

                            <td>
                                <a href="javascript:void(0)"><img src="{{asset('business_assets/images/delete.png')}}" alt="image"></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="pro-img">
                                    <img src="{{asset('business_assets/images/pro-small2.png')}}" alt="image">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropProd1"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Chessy Club Sandwick
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropProd1">
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropFfood1"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Fast Food
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropFfood1">
                                        <a class="dropdown-item" href="javascript:void(0)">Fast Food</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Fast Food</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Fast Food</a>
                                    </div>
                                </div>
                            </td>
                            <td class="border-dropdown">
                                <input type="text" value="2" class="form-control">
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropOper1"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        0.00%
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropOper1">
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 order-total">$42.20</p>
                            </td>

                            <td>
                                <a href="javascript:void(0)"><img src="{{asset('business_assets/images/delete.png')}}" alt="image"></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="pro-img">
                                    <img src="{{asset('business_assets/images/pro-small3.png')}}" alt="image">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropProd2"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Chessy Club Sandwick
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropProd2">
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropFfood2"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Fast Food
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropFfood2">
                                        <a class="dropdown-item" href="javascript:void(0)">Fast Food</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Fast Food</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Fast Food</a>
                                    </div>
                                </div>
                            </td>
                            <td class="border-dropdown">
                                <input type="text" value="2" class="form-control">
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropOper2"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        0.00%
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropOper2">
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 order-total">$42.20</p>
                            </td>

                            <td>
                                <a href="javascript:void(0)"><img src="{{asset('business_assets/images/delete.png')}}" alt="image"></a>
                            </td>
                        </tr>
                        <tr class="addnew">
                            <td>
                                <div class="pro-img">
                                    <img src="{{asset('business_assets/images/pro-small3.png')}}" alt="image">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropProd2"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Select item
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropProd2">
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropProd"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Fast Food
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropProd">
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
                                    </div>
                                </div>
                            </td>
                            <td class="border-dropdown">
                                <input type="text" value="2" class="form-control">
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropProd"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        0.00%
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropProd">
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                        <a class="dropdown-item" href="javascript:void(0)">0.00%</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 order-total">$42.20</p>
                            </td>

                            <td>
                                <a href="javascript:void(0)"><img src="{{asset('business_assets/images/delete.png')}}" alt="image"></a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">
                                <a href="{{route('orders-add', ['id' => 1])}}" class="btn-size btn-rounded btn-dark">Add New Item</a>
                            </td>
                            <td>
                                Total:
                            </td>
                            <td colspan="2">
                                <h4 class="font-weight-700 danger-text">$99.67</h4>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-sm-12">
            <div class="right-side">
                <form>
                    <div class="form-group mb-2">
                        <input type="text" placeholder="John Smith" class="order-edit-control form-control">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" placeholder="johnsmith@gmail.com " class="order-edit-control form-control">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" placeholder="+01 5892 54862" class="order-edit-control form-control">
                    </div>
                    <div class="form-group mb-2">
                        <textarea placeholder="P.O. Box 9966 Al Qouz Dubai, UA" class="order-edit-control form-control"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <h4 class="font-weight-600 mb-2 mt-4">Customer Note</h4>
                        <textarea placeholder="Lorem ipsum dolor sint ut labore et dolore magna aliqua. " class="order-edit-control form-control"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <h4 class="font-weight-600 mb-2 mt-4">Shipping</h4>
                        <input type="text" placeholder="John Smith" class="order-edit-control form-control">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" placeholder="johnsmith@gmail.com " class="order-edit-control form-control">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" placeholder="+01 5892 54862" class="order-edit-control form-control">
                    </div>
                    <div class="form-group mb-2">
                        <textarea placeholder="P.O. Box 9966 Al Qouz Dubai, UA" class="order-edit-control form-control"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <h4 class="font-weight-600 mb-2 mt-4">Billing Address</h4>
                        <input type="text" placeholder="John Smith" class="order-edit-control form-control">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" placeholder="johnsmith@gmail.com " class="order-edit-control form-control">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" placeholder="+01 5892 54862" class="order-edit-control form-control">
                    </div>
                    <div class="form-group mb-2">
                        <textarea placeholder="P.O. Box 9966 Al Qouz Dubai, UA" class="order-edit-control form-control"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <div class="selected-item-panel">
        <div class="selected-item">
            <div class="row align-items-center">
                <div class="col-md-3 col-sm-12">
                    <div class="item-show">
                        <span><img src="{{asset('business_assets/images/close-wgite.png')}}" alt="image"></span>
                        <p>2 Items Selected</p>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="item-btn">
                        <a href="javascript:void(0)"><img src="{{asset('business_assets/images/writing-white.png')}}" alt="image"> Note</a>
                        <a href="javascript:void(0)">Multi Fulfill</a>
                        <a href="javascript:void(0)">Capture Payment</a>
                        <a href="javascript:void(0)"><img src="{{asset('business_assets/images/printer-white.png')}}" alt="image"> Print Options</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @include('layouts.jquery')
@endsection
