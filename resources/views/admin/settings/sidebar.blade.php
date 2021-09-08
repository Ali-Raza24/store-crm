<div class="card-repeat profile-adder pb-5 mt-4">
    <div class="profile-settings" id="image">
        {!! Form::open(['route' => 'update-logo', 'files' => true]) !!}
            <image-upload name="images[user]" :upload-btn="true"
                          @if(\App\Helpers\CommonHelper::userLogo())
                          image_placeholder="{{\App\Helpers\CommonHelper::userLogo()}}"
                          @else
                          image_placeholder="{{asset('admin_assets/images/logo-social-round.png')}}"
                          @endif
                          :round-image="true"></image-upload>
        {!! Form::close() !!}
        <a href="javascript:void(0)" class="profile-add">+</a>
    </div>
    <p class="profile-name dark-one font-weight-700 mb-0 text-center">{{Auth::user()->name}}</p>
    <p class="dark-two profile-tagline text-center mb-0">{{Auth::user()->email}}</p>
    <div class="text-center mb-3">
        <a href="{{route('admin-company-setting')}}" class="text-primary">Edit Account Info</a>
    </div>
    <ul class="setting-generals-list mobile-hide">
        <li><a href="{{route('admin-company-setting')}}"
               class="dark-one {{(request()->is('admin/settings/business*') || request()->is('admin/settings/test*') || request()->is('admin/settings/company*')) ? 'active' : ''}}">General</a></li>
        <li><a href="{{route('admin-page-setting')}}"
               class="dark-one {{request()->routeIs('admin-page-edit') ? 'active' : ''}} {{request()->routeIs('admin-page-setting') ? 'active' : ''}}">Pages</a>
        </li>
        <li><a href="{{route('admin-plans-setting')}}"
               class="dark-one {{request()->routeIs('admin-plans-setting') ? 'active' : ''}}">Plans</a></li>
        <li><a href="{{route('admin-user-list')}}"
               class="dark-one {{request()->routeIs('admin-user-list') ? 'active' : ''}}">Users Management</a></li>
        {{-- <li><a href="{{route('admin-role-list')}}" class="dark-one {{request()->routeIs('admin-role-list') ? 'active' : ''}}">Users Management</a></li> --}}
    </ul>
    <script src="{{asset('js/image.js')}}"></script>
    <div class="form-group ml-3 mr-3 mt-5 text-center">
        <div class="input-group sm-radius-control common-input">
            <input type="text" class="form-control" id="store-url" value="https://yabee.me" readonly/>
            <a href="javascript:void(0)" class="clipboard-btn primary-text font-weight-600 common-input-btn" data-clipboard-action="copy" data-clipboard-target="#store-url">Copy</a>
        </div>
        <a href="https://yabee.me" class="btn-size btn-rounded btn-gray w-75 mt-3" target="_blank">View Site</a>
    </div>
    <div class="desktop-hide">
        <div class="setting-generals-drops sm-radius-control mt-5 ml-3 mr-3">
            <p class="setting-title m-0">General</p>
            <div class="dropdown">
                <button class="dropdown-toggle" type="button" id="settingDrop" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <i></i> <i></i><i></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settingDrop">
                    <a href="{{route('admin-company-setting')}}"
                       class="dropdown-item dark-one {{request()->routeIs('admin-company-setting') ? 'active' : ''}}">General</a>
                    <a href="{{route('admin-page-setting')}}"
                       class="dropdown-item dark-one {{request()->routeIs('admin-page-setting') ? 'active' : ''}}">Pages</a>
                    <a href="{{route('admin-plans-setting')}}"
                       class="dropdown-item dark-one {{request()->routeIs('admin-plans-setting') ? 'active' : ''}}">Plans</a>
                    <a href="{{route('admin-user-list')}}"
                       class="dropdown-item dark-one {{request()->routeIs('admin-user-list') ? 'active' : ''}}">Users
                        Management</a>
                </div>
            </div>
        </div>
    </div>

</div>
