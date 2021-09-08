<nav class="tabs-head mobile-hide" id="allOrders">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link {{request()->routeIs('admin-page-setting') ? 'active' : ''}} " id="Pages-tab"  href="{{ route('admin-page-setting') }}" role="tab" aria-controls="Pages" aria-selected="true">
            Pages
        </a>
        @if(!empty(request()->routeIs('admin-page-edit')))
        <a class="nav-item nav-link {{request()->routeIs('admin-page-add') ? 'active' : ''}}{{request()->routeIs('admin-page-edit') ? 'active' : ''}} " id="In-Active-tab"  href="{{ route('admin-page-add') }}" role="tab" aria-controls="In-Active" aria-selected="false">
           @if(!empty(request()->routeIs('admin-page-edit'))) Edit @else Add @endif
        </a>
          @endif
    </div>
</nav>
