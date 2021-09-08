@extends('layouts.admin.app')
@section('css')
    <style>
        .pac-container {
            top: 340px !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide mt-4">
                <h2 class="dark-one font-weight-700">
                    Manage Areas
                </h2>
                <h4 class="tagline dark-one font-weight-400">
                    Overview
                </h4>
            </div>
        </div>
    </div>
    <div class="mt-3">
        @include('flash::message')
    </div>
    @include('admin.areas.navbar')
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="AreaInActive" role="tabpanel" aria-labelledby="Allarea-tab">
            @include('admin.areas.table')
        </div>
    </div>
@endsection
@include('admin.areas.extra')
{{--@section('footer')
    <div class="selected-item-panel">
        <div class="selected-item">
            <ul class="selected-list">
                <li>
                    <div class="item-show">
                        <span>
                            <img src="{{asset('admin_assets/images/close-wgite.png')}}" alt="image" />
                        </span>
                        <p class="mobile-hide"><span id="totalSelected">0</span> Items Selected</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn note-option"
                       data-url="{{route('admin-area-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Active"
                       data-id="bulk"
                    >
                        <span>Active</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn import-option"
                       data-url="{{route('admin-area-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::DISABLE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="InActivate"
                       data-id="bulk"
                    >
                        <span>InActive</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn export-option"
                       data-toggle="modal"
                       data-url="{{route('admin-area-bulk-delete')}}"
                       data-modal="modal"
                       data-type="delete"
                       data-target="#confirmModal"
                       data-title="Delete"
                       data-id="bulk"
                    >
                        <span>Delete</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('extras')
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                    <input type="hidden" name="area_id" id="area_id">
                    <input type="hidden" name="status_id" id="status_id">
                    <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title</span> area?</h2>
                    <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Delete</span> this area?</h4>
                    <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Delete</span></button>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                        Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade customer-modal" id="impCsv" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="font-weight-700 dark-one mb-2">
                        Import Customers from CSV file
                    </h3>
                    <div class="form-group mt-4 mb-4 w-75 ml-auto mr-auto">
                        <div class="form-icon">
                            <input type="url" placeholder="C/:"
                                   class="form-control sm-radius-control white-border-control" />
                            <span>
                                <img alt="" src="{{asset('admin_assets/images/folder.png')}}" />
                            </span>
                        </div>
                    </div>
                    <h4 class="dark-two mb-3">Download a sample file CSV file
                        <span class="dark-one font-weight-600">Click Here</span>
                    </h4>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary ml-1 mr-1">
                        Upload
                    </a>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="areas">
        <add-area
                states_url="{{api_url('states-list')}}"
                save_area_url="{{api_url('save_area_url')}}"
                get_areas="{{api_url('get_areas')}}"

        ></add-area>
    </div>

    <div class="body-overlay"></div>
@endsection

@section('scripts')
    <script src="{{asset_timestamp('js/admin/areas.js')}}"></script>
    <script>
      let ids = [];
      $('[data-modal="modal"]').on('click', function(){
        if ($(this).data('id') === 'bulk'){
          $.each($('.areas-list-check:checked'), function(){
            ids.push($(this).val())
          })
          $('#area_id').val(ids)
        } else {
          $('#area_id').val($(this).data('id'));
        }
        $('#status_id').val($(this).data('status'));
        $('[data-modal-title="title"]').text($(this).data('title'))
        $('#confirmForm').attr('action',$(this).data('url'))
        $('#method').val($(this).data('type'))
        $
      });

      $('#checkAll').on('change',function(){
        if ($(this).is(':checked')){
          $('.areas-list-check').prop('checked', true)
        }else{
          $('.areas-list-check').prop('checked', false)
        }
        $('#totalSelected').text($('.areas-list-check:checked').length)
      })
      $(function(){
        $('.areas-list-check').on('change', function(){
          if($('.areas-list-check:checked').length === $('.areas-list-check').length){
            $('#checkAll').prop('checked', true)
          }else{
            $('#checkAll').prop('checked', false)
          }
          $('#totalSelected').text($('.areas-list-check:checked').length)
        })
      })
    </script>
@endsection--}}
