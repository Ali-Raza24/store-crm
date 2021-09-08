<nav class="tabs-head mobile-hide" id="allOrders">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @if(plan_permission('page'))
        <a class="nav-item nav-link {{request()->routeIs('business-page-setting') ? 'active' : ''}}" id="Pages-tab"  href="{{ route('business-page-setting') }}" role="tab" aria-controls="Pages" aria-selected="true">
            Pages
        </a>
        @endif
        @if(session()->has('showMainPageTab'))
        <a class="nav-item nav-link {{request()->routeIs('business-main-page-setting') ? 'active' : ''}}" id="Pages-tab"  href="{{ route('business-main-page-setting') }}" role="tab" aria-controls="Pages" aria-selected="true">
            Main Page
        </a>
        @endif
        @if(plan_permission('announcement'))
        <a class="nav-item nav-link {{request()->routeIs('announcements*') ? 'active' : ''}}" id="Pages-tab"  href="{{ route('announcements.index') }}" role="tab" aria-controls="Pages" aria-selected="true">
            Announcements
        </a>
        @endif
        @if(!empty(request()->routeIs('business-page-edit')))
        <a class="nav-item nav-link {{request()->routeIs('business-page-add') ? 'active' : ''}}{{request()->routeIs('business-page-edit') ? 'active' : ''}} " id="In-Active-tab"  href="{{ route('business-page-add') }}" role="tab" aria-controls="In-Active" aria-selected="false">
           @if(!empty(request()->routeIs('business-page-edit'))) Edit @else Add @endif
        </a>
          @endif
    </div>
</nav>
