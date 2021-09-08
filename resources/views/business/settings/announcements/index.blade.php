@extends('layouts.business.setting-layout')

@section('title','Announcements')

@section('header_heading', "Announcements")

@section("header_subheading", "Overview")

@section('content')
    <style>
        .alert-info {
            color: #155724 !important;
            background-color: #d4edda !important;
            border-color: #c3e6cb !important;
        }
    </style>
    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide mt-4">
                <h2 class="dark-one font-weight-700">Settings</h2>
                <h4 class="tagline dark-one font-weight-400">Quick Overview</h4>
            </div>
        </div>
    </div>
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('business.settings.pages.navbar')
                <div class="dropdown tabs-dropdown desktop-hide">
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pages
                    </button>
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Main Page
                    </button>
                    @if(plan_permission('announcement'))
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Announcements
                    </button>
                        @endif
                </div>
                <hr class="m-0"/>
                <div class="tab-content @if(plan_has_permission(['announcement-create', 'announcement-edit'])) mt-5 @endif" id="nav-settingContent">

                    <div class="tab-pane show active" role="tabpanel">
                        <div class="col-12" id='flashmessage'> @include('flash::message')</div>
                        @if(plan_has_permission(['announcement-create', 'announcement-edit']))
                        <form action="{{route('announcements.store')}}" method="post">
                            @csrf
                            @if(optional($model)->id)
                                {!! Form::hidden('announcement_id', optional($model)->id) !!}
                            @endif
                            <div class="form-group">
                                <label for="">Announcement</label>
                                <textarea name="announcement" class="form-control order-edit-control @if($errors->has('announcement')) danger-border @endif">{{optional($model)->announcement}}</textarea>
                                @error('announcement')
                                    <div class="input-info danger-bg">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-0 text-right">
                                <hr class="mt-5 mb-3"/>
                                @if(plan_has_permission(['announcement-create', 'announcement-edit']))
                                <button class="btn-size btn-rounded btn-primary mr-3">
                                    @if(optional($model)->id)
                                        Update
                                    @else
                                        Add
                                    @endif

                                </button>
                                    @endif
                            </div>
                        </form>
                        @endif
                        <div class="col-12 p-4">
                            <hr class="mt-5 mb-3"/>
                            <h4 class="dark-one font-weight-700">All Announcements</h4>
                            <div class="table-responsive scroll-bar-thin">
                                <table class="table table-space table-check table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="pl-4">ID</th>
                                        <th scope="col">Announcements</th>
                                        <th scope="col">Status</th>
                                        @if(plan_has_permission(['announcement-delete', 'announcement-edit']))
                                        <th scope="col">Actions</th>
                                            @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($announcements  as $key=> $announcement)

                                        <tr>
                                            <td>
                                                {!! $announcement->id !!}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="table-order-no ml-3">
                                                        <strong class="dark-one"><a href="#">{{ $announcement->announcement}}</a></strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropStore1" role="button"
                                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span id="dropdown-text-{{ $announcement->id }}">
                                                        @if($announcement->is_active == \App\Constants\IStatus::ACTIVE)
                                                            Active
                                                        @else
                                                            Inactive
                                                        @endif
                                                    </span>
                                                </span>
                                                    @if(plan_has_permission(['announcement-status']))
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropStore1">
                                                        @if($announcement->is_active == \App\Constants\IStatus::DISABLE)
                                                        <a class="dropdown-item" id=""
                                                           href="javascript:void(0)"
                                                           data-url="{{route('announcements.status')}}"
                                                           data-status="{{\App\Constants\IStatus::ACTIVE}}"
                                                           data-type="put"
                                                           data-toggle="modal"
                                                           data-modal="modal"
                                                           data-target="#confirmModal"
                                                           data-title="Active Announcement"
                                                           data-id="{{$announcement->id}}"
                                                        >
                                                            Active
                                                        </a>
                                                        @else
                                                        <a class="dropdown-item" id=""
                                                           href="javascript:void(0)"
                                                           data-url="{{route('announcements.status')}}"
                                                           data-status="{{\App\Constants\IStatus::DISABLE}}"
                                                           data-type="put"
                                                           data-toggle="modal"
                                                           data-modal="modal"
                                                           data-target="#confirmModal"
                                                           data-title="Inactive Announcement"
                                                           data-id="{{$announcement->id}}"
                                                        >
                                                            Inactive
                                                        </a>
                                                            @endif
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-action">
                                                    @if(plan_has_permission(['announcement-edit']))
                                                    <a href="{{ route('announcements.edit', ['announcement' => $announcement->id])}}"
                                                       class="edit-order mr-3">
                                                        <img alt=""
                                                             src="{{asset('admin_assets/images/edit1.png')}}"/>
                                                    </a>
                                                    @endif
                                                        @if(plan_has_permission(['announcement-delete']))
                                                    <a class="print-order"
                                                       data-url="{{route('announcements.destroy')}}"
                                                       data-type="delete"
                                                       data-toggle="modal"
                                                       data-modal="modal"
                                                       data-target="#confirmModal"
                                                       data-title="Delete Announcement"
                                                       data-id="{{$announcement->id}}"
                                                    >
                                                        <img alt="" src="{{asset('admin_assets/images/delete.png')}}"/>
                                                    </a>
                                                            @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="announcement_id" id="announcement_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title Announcement</span>?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update this Announcement?</span></h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Ok</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')

    <script>
      $('[data-modal="modal"]').on('click', function() {

        $('#announcement_id').val($(this).data('id'));
        $('#status_id').val($(this).data('status'));
        $('[data-modal-title="title"]').text($(this).data('title'));
        $('#confirmForm').attr('action', $(this).data('url'));
        $('#method').val($(this).data('type'));
        $;
      });
    </script>
@endsection

