<div class="row table-filter-wrap align-items-center justify-content-between mt-lg-4 mt-3">
    <div class="col-md-12 table-filter-wrap">
        <div class="col-filter">
            <nav class="tabs-head mobile-hide" id="allArea">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link @if(request()->routeIs('admin-areas-list'))active @endif" id="Allarea-tab" href="{{route('admin-areas-list', request()->getQueryString())}}"
                       role="tab" aria-selected="true">All Areas</a>
                    <a class="nav-item nav-link @if(request()->routeIs('admin-areas-list-in-active'))active @endif" id="AreaInactive-tab" href="{{route('admin-areas-list-in-active', request()->getQueryString())}}"
                       role="tab" aria-selected="true">Inactive</a>
                </div>
            </nav>
            <div class="dropdown tabs-dropdown desktop-hide">
                <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">All Areas
                </button>
                <div class="dropdown-menu" aria-labelledby="dropTab">
                    <a class="nav-item nav-link active" href="{{route('admin-areas-list', request()->getQueryString())}}">All Areas</a>
                    <a class="nav-item nav-link" href="{{route('admin-areas-list-in-active', request()->getQueryString())}}">Inactive</a>
                </div>
            </div>
        </div>
        <div class="col-filter">
            <div class="table-misc d-flex justify-content-between">
                <ul class="table-filter">
                    <li>
                        <form>
                        <div class="dropdown order-list-drop">
                            <button class="dropdown-toggle" type="button" id="dropTFilter" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <img alt="" src="{{asset('admin_assets/images/filter.png')}}" />
                                Filters
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropTFilter">
                                <div class="dropdown-box">
                                    <div class="form-group">
                                        <label class="dark-one font-weight-600">Cities</label>
                                        {!! Form::select('state[]', \App\Helpers\CommonHelper::states(), request()->get('state'), ['class' =>'js-select2 order-edit-control form-control', 'multiple']) !!}
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
                        <a href="javascript:void(0)"
                           class="btn-size btn-rounded btn-primary add-area-btn mobile-hide">
                            Add Area
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<hr class="m-0" />
<h3 class="border-heading dark-one font-weight-700 mt-lg-5 mt-4 desktop-hide">Manage Areas
    <a class="btn-primary btn-rounded btn-order add-area-btn desktop-hide" href="javascript:void(0)">Add Area</a>
</h3>
