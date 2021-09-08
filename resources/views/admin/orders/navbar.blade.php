
<div class="row table-filter-wrap align-items-center justify-content-between mt-lg-5 mt-4">
    <div class="col-md-12 table-filter-wrap">
        <div class="col-filter">
            <nav class="tabs-head mobile-hide" id="allOrders">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link @if(request()->routeIs('admin-orders-list')) active @endif" href="{{route('admin-orders-list')}}">
                        All Orders
                    </a>
                    <a class="nav-item nav-link @if(request()->routeIs('admin-orders-list-un-success')) active @endif" href="{{route('admin-orders-list-un-success')}}">
                        Payment Unsuccessful
                    </a>
                </div>
            </nav>
            <div class="dropdown tabs-dropdown desktop-hide">
                <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    All Orders
                </button>
                <div class="dropdown-menu" aria-labelledby="dropTab">
                    <a class="nav-item nav-link @if(request()->routeIs('admin-orders-list')) active @endif" href="{{route('admin-orders-list')}}">All Orders</a>
                    <a class="nav-item nav-link @if(request()->routeIs('admin-orders-list-un-success')) active @endif" href="{{route('admin-orders-list-un-success')}}">Payment Unsuccessful</a>
                </div>
            </div>
        </div>
        <div class="col-filter">
            <div class="table-misc d-flex justify-content-between">
                <form id="date_filter">
                    <div class="date-picker">
                        <div class="form-group form-icon">
                            <input name="from_date" type="date" class="form-control" id="from_date">
                            <span>
                            <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                        </span>
                        </div>
                        <div class="form-group text-center">to</div>
                        <div class="form-group form-icon">
                            <input name="to_date" type="date" class="form-control" id="to_date">
                            <span>
                            <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                        </span>
                        </div>
                    </div>
                </form>
                <ul class="table-filter">
{{--                    <li data-toggle="modal" data-target="#impCsv">
                        <img alt="" src="{{asset('admin_assets/images/download.png')}}"/>
                        Import
                    </li>
                    <li>
                        <img alt="" src="{{asset('admin_assets/images/upload.png')}}"/>
                        Export
                    </li>--}}
                    <li>
                        <div class="dropdown order-list-drop">
                            <button class="dropdown-toggle" type="button" id="dropTFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img alt="" src="{{asset('admin_assets/images/filter.png')}}"/>
                                Filters
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropTFilter">
                                <form>
                                <div class="dropdown-box pb-2">
                                    <div class="form-group">
                                        <label class="dark-one font-weight-600">Cities</label>
                                        <select name="state_id[]" class='select2 form-control sm-radius-control white-border-control' id='state_select' multiple>
                                            <option value=""></option>
                                            @foreach(\App\Helpers\CommonHelper::states() as $key => $value)
                                                <option value="{{$key}}" @if(is_array(request()->get('state_id')) && in_array($key, request()->get('state_id'))) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="dark-one font-weight-600">Business</label>
                                        <select name="business_id[]" class='select2 form-control sm-radius-control white-border-control' id='business_select' multiple>
                                            <option value=""></option>
                                            @foreach($businesses as $key => $value)
                                                <option value="{{$key}}" @if(is_array(request()->get('business_id')) && in_array($key, request()->get('business_id'))) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="drop-footer grey-one mt-4">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="cancel-filter dark-two">Cancel</a>
                                    <button class="apply-filter dark-one">Apply</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
