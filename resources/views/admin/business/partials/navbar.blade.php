<div class="col-filter">
    <nav class="tabs-head mobile-hide" id="allOrders">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a
                    class="nav-item nav-link @if(request()->routeIs('admin-business-list')) active @endif"
                    id="all-business-tab"
                    href="{{route('admin-business-list', request()->getQueryString())}}"
                    role="tab"
                    aria-controls="All-Business"
                    aria-selected="true"
            >
                All Business
            </a>
            <a
                    class="nav-item nav-link @if(request()->routeIs('admin-business-list-new')) active @endif"
                    id="new-business-tab"
                    href="{{route('admin-business-list-new', request()->getQueryString())}}"
                    role="tab"
                    aria-controls="New"
                    aria-selected="false"
            >
                New
            </a>
            <a
                    class="nav-item nav-link @if(request()->routeIs('admin-business-list-active')) active @endif"
                    id="active-business-tab"
                    href="{{route('admin-business-list-active', request()->getQueryString())}}"
                    role="tab"
                    aria-controls="Actived"
                    aria-selected="false"
            >
                Actived
            </a>
            <a
                    class="nav-item nav-link @if(request()->routeIs('admin-business-list-suspended')) active @endif"
                    id="suspended-business-tab"
                    href="{{route('admin-business-list-suspended', request()->getQueryString())}}"
                    role="tab"
                    aria-controls="Suspended"
                    aria-selected="false"
            >
                Suspended
            </a>
            <a
                    class="nav-item nav-link @if(request()->routeIs('admin-business-list-upcoming')) active @endif"
                    id="upcoming-payment-tab"
                    href="{{route('admin-business-list-upcoming', request()->getQueryString())}}"
                    role="tab"
                    aria-controls="Upcoming-Payment"
                    aria-selected="false"
            >
                Upcoming Payment
            </a>
        </div>
    </nav>
    <div class="dropdown tabs-dropdown desktop-hide">
        <a
                class="dropdown-toggle"
                type="button"
                id="dropTab"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                href="{{route('admin-business-list')}}"
        >
            All Business
        </a>
        <div class="dropdown-menu" aria-labelledby="dropTab">
            <a class="nav-item nav-link @if(request()->routeIs('admin-business-list')) active @endif" href="{{route('admin-business-list-new', request()->getQueryString())}}">New</a>
            <a class="nav-item nav-link @if(request()->routeIs('admin-business-list-new')) active @endif" href="{{route('admin-business-list-active', request()->getQueryString())}}">Active</a>
            <a class="nav-item nav-link @if(request()->routeIs('admin-business-list-suspended')) active @endif" href="{{route('admin-business-list-suspended', request()->getQueryString())}}">Suspended</a>
            <a class="nav-item nav-link @if(request()->routeIs('admin-business-list-upcoming')) active @endif" href="{{route('admin-business-list-upcoming', request()->getQueryString())}}">Upcoming Payment</a>
        </div>
    </div>
</div>
<div class="col-filter">
    <div class="table-misc d-flex justify-content-between">
        <ul class="table-filter">
            {{--<li data-toggle="modal" data-target="#impCsv">
                <img alt="" src="{{asset('admin_assets/images/download.png')}}"
                />Import
            </li>
            <li>
                <img alt="" src="{{asset('admin_assets/images/upload.png')}}" />Export
            </li>--}}
            <li>
                <form>
                <div class="dropdown order-list-drop">
                    <button
                            class="dropdown-toggle"
                            type="button"
                            id="dropTFilter"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                    >
                        <img alt="" src="{{asset('admin_assets/images/filter.png')}}" />Filters
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropTFilter">
                        <div class="dropdown-box">
                            <div class="form-group">
                                <label class="dark-one font-weight-600">City</label>
                                {!! Form::select('state[]', \App\Helpers\CommonHelper::states(), request()->get('state'), ['class' =>'js-select2 order-edit-control form-control', 'multiple']) !!}
                            </div>
                            <div class="form-group">
                                <label class="dark-one font-weight-600">Plan Type</label>
                                {!! Form::select('plan[]', \App\Helpers\CommonHelper::plans(),request()->get('plan'), ['class' =>'js-select2 order-edit-control form-control', 'multiple']) !!}
                            </div>
                            <div class="form-group">
                                <div class="dropdown-box mb-3">
                                    <p class="dark-one font-weight-600">
                                        Business Registration
                                    </p>
                                    @php
                                    use Carbon\Carbon;
                                    if (empty(request()->get('from_date'))) {
                                        $startDate = Carbon::now()->format('m/d/Y');
                                    } else {
                                        $startDate = Carbon::createFromFormat('Y-m-d', request()->get('from_date'))->format('m/d/Y');
                                    }
                                    if (empty(request()->get('to_date'))){
                                        $toDate = Carbon::now()->format('Y/m/d');
                                    } else {
                                        $toDate = Carbon::createFromFormat('Y-m-d', request()->get('to_date'))->format('m/d/Y');
                                    }
                                    @endphp
                                    <div class="date-picker">
                                        <div class="form-group form-icon">
                                            <input name="from_date" type="date" class="form-control" value="{{$startDate}}" />
                                            <span><img alt="" src="{{asset('admin_assets/images/calle.png')}}" /></span>
                                        </div>
                                        <div class="form-group text-center">to</div>
                                        <div class="form-group form-icon">
                                            <input name="to_date" type="date" class="form-control" value="{{$toDate}}" />
                                            <span>
                                                <img alt="" src="{{asset('admin_assets/images/calle.png')}}" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="drop-footer grey-one d-flex justify-content-between">
                            <button class="apply-filter dark-one">Apply</button>
                            <button class="cancel-filter dark-two" type="button" data-toggle="dropdown">Cancel</button>
                            <a href="{{url()->current()}}" class="apply-filter dark-one">Clear</a>
                        </div>
                    </div>
                </div>
                </form>
            </li>
            <li>
                <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary add-area-btn mobile-hide">Add Businesses</a>
            </li>
        </ul>
    </div>
</div>
