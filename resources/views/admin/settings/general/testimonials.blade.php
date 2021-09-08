@extends('layouts.admin.app')

@section('title', 'Testimonials')
@section('heading', 'Testimonials')

@section('content')
    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide mt-4">
                <h2 class="dark-one font-weight-700">Settings</h2>
                <h4 class="tagline dark-one font-weight-400">Quick Overview</h4>
            </div>
        </div>
    </div>

    <div class="row setting-wrapp">
        <div class="col-lg-4">
            @include('admin.settings.sidebar')
        </div>
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('admin.settings.general.navbar')
                <hr class="m-0" />
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="col-12 -align-center"> @include('flash::message')</div>
                    <div class="col-12 alert alert-success" id="ajaxResp_status" style='display: none;'>
                        <button type="button" class="close" data-dismiss="alert">x</button>
                    </div>
                    <div class="tab-pane fade show active pro-table-seting" id="settAccount" role="tabpanel"
                         aria-labelledby="settAccount">

                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="font-weight-700 dark-one">All Testimonials</h4>
                            <a class="btn-size btn-rounded btn-primary" href="javascript:void(0)" data-toggle="modal"
                               data-target="#addNewTestimonials">Add Testimonial</a>
                        </div>
                        <div class="table-responsive scroll-bar-thin">
                            <table class="table table-space table-check first-tran v-middle order-table">
                                <thead>
                                <tr>
                                    <th scope="col" class="custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkAll" />
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </th>

                                    <th scope="col">Name</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(!empty($testimonials))
                                    @foreach($testimonials as $testimonial)
                                        <tr>
                                            <td class="custom-checkbox show-selected">
                                                <input type="checkbox" value="{{$testimonial->id}}" name="ids[]"
                                                       class="custom-control-input list-check"
                                                       id="customCheck{{$loop->iteration+2}}" />
                                                <label class="custom-control-label"
                                                       for="customCheck{{$loop->iteration+2}}"></label>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="pro-thumb">

                                                        <img alt="" style=''
                                                             src="@if(!empty($testimonial->image->url)){{ $testimonial->image->url }}@else{{asset('img/camera_icon.png')}}@endif"
                                                        <img alt="" src="{{asset('img/camera_icon.png')}}" />

                                                    </div>
                                                    <div class="table-order-no ml-3">
                                                        <strong class="dark-one">
                                                            <a href="#"
                                                               style="white-space: pre-wrap ">{{$testimonial->name}}</a>
                                                        </strong>
                                                        <p class="mb-0">{{$testimonial->created_at}}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 order-name" style="white-space: pre-wrap">{{ \Illuminate\Support\Str::limit($testimonial->message, $limit = 150, $end = '...') }}</p>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                             <span class="dropdown-toggle" id="dropStore1" role="button"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span id="dropdown-text-{{ $testimonial->id }}">
                                               @if(!empty($testimonial))
                                                            @if($testimonial->is_active == \App\Constants\IStatus::ACTIVE)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                                        @endif
                                                    </span>


                                                </span>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropStore1">
                                                        @if($testimonial->is_active != \App\Constants\IStatus::ACTIVE)
                                                        <a class="dropdown-item" href="javascript:void(0)"
                                                           data-url="{{route('testimonial-Status-Update')}}"
                                                           data-status="{{\App\Constants\IStatus::ACTIVE}}"
                                                           data-type="put"
                                                           data-toggle="modal"
                                                           data-modal="modal"
                                                           data-target="#confirmModal"
                                                           data-title="Active this testimonial"
                                                           data-id="{{$testimonial->id}}"
                                                        >
                                                            Active
                                                        </a>
                                                        @else
                                                        <a class="dropdown-item" id="" href="javascript:void(0)"
                                                           data-url="{{route('testimonial-Status-Update')}}"
                                                           data-status="{{\App\Constants\IStatus::DISABLE}}"
                                                           data-type="put"
                                                           data-toggle="modal"
                                                           data-modal="modal"
                                                           data-target="#confirmModal"
                                                           data-title="Inactive this testimonial"
                                                           data-id="{{$testimonial->id}}"
                                                        >
                                                            Inactive
                                                        </a>
                                                            @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-action">
                                                    <a href="{{route("admin-testimonial-edit",$testimonial->id)}}"
                                                       class="edit-order mr-3">
                                                        <img alt="" src="{{asset('business_assets/images/edit1.png')}}"></a>
                                                    <a href="javascript:void(0);" class="print-order"
                                                       data-toggle="modal"
                                                       data-id="{{$testimonial->id}}"
                                                       data-url="{{route('admin-testimonial-delete')}}"
                                                       data-modal="modal"
                                                       data-type="delete"
                                                       data-target="#confirmModal"
                                                       data-title="Delete this testimonial">
                                                        <img alt=""
                                                             src="{{asset('business_assets/images/delete.png')}}" />
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        @php $paginator = $testimonials->toArray() @endphp
                        <div class="d-flex justify-content-between">
                            <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}}
                                of {{ $paginator['total'] }} records</p>
                            {!! $testimonials->appends(request()->getQueryString())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <div class="selected-item-panel">
        <div class="selected-item">
            <ul class="selected-list">
                <li>
                    <div class="item-show">
                        <span>
                            <img src="{{asset('admin_assets/images/close-wgite.png')}}" alt="image" />
                        </span>
                        <p class="mobile-hide"><span id="totalSelected">0</span> <span class="bg-transparent" id="selectCountText">Item</span> Selected</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn note-option"
                       data-url="{{route('admin-testimonial-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Active this testimonial"
                       data-id="bulk"
                    >
                        <span>Active</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn import-option"
                       data-url="{{route('admin-testimonial-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::DISABLE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Inactive this testimonial"
                       data-id="bulk"
                    >
                        <span>InActive</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn export-option"
                       data-toggle="modal"
                       data-url="{{route('admin-testimonial-bulk-delete')}}"
                       data-modal="modal"
                       data-type="delete"
                       data-target="#confirmModal"
                       data-title="Delete this testimonial"
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
    <!-- Delete confirmation Modal -->
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="testimonial_id" id="testimonial_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title Testimonial? </span></h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Delete
                            this Testimonial </span>?</h4>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1"
                           data-dismiss="modal">
                            Cancel </a>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span
                                    data-modal-title="title">Delete</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New/Edit Testimonial -->
    <div class="modal fade customer-modal" id="addNewTestimonials" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="font-weight-700 dark-one mb-2">
                        @if(!empty($showTestimonialEdittab)) Manage Testimonial @else Add Testimonial @endif
                    </h3>
                    <div class="col-12"> @include('flash::message')</div>

                    <form class="right-side-from" id='add-testimonial-form'
                          action="{{ route('admin-testimonials-add') }}" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                            <div class="form-group">
                                @if(!empty($testimonialData->image->url))
                                    <span class="add-add-testimonial-claceholder">

                                <img style="max-width: 504px; max-height:147px" alt="" id="userPreview"
                                     src="@if(!empty($testimonialData->image->url)){{ $testimonialData->image->url }}@else{{asset('admin_assets/images/customer-placeholder.png')}}@endif"
                                     onclick="uploadDialog()" />
                                 <input type="file" name='images[]' accept="image/x-png,image/gif,image/jpeg"
                                        style='display: none;' class="@error('images.0') danger-border @enderror" id="imgupload"/>
                            </span>
                                    @error('images.0')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                @else
                                    <span class="add-brand">
                                <img alt="" style="max-width: 504px; max-height:147px" id="userPreview"
                                     src="{{asset('admin_assets/images/customer-placeholder.png')}}"
                                     onclick="uploadDialog()" />
                                 <input type="file" name='images[]' accept="image/x-png,image/gif,image/jpeg"
                                        style='display: none;' class="" id="imgupload" @error('image') danger-border @enderror"/>
                            </span>
                                    @error('image')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Name</label>
                                <input type="text" name='testimonial_name'
                                       value='@if(!empty($testimonialData->name)){{ $testimonialData->name }}@else{{ old('testimonial_name') }}@endif'
                                       class="form-control sm-radius-control white-border-control @error('testimonial_name') danger-border @enderror" />
                                @error('testimonial_name')
                                <div class="input-info danger-bg">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Message</label>
                                <textarea name='testimonial_message'
                                          class="form-control sm-radius-control white-border-control @error('testimonial_message') danger-border @enderror">@if(!empty($testimonialData->message)){{ $testimonialData->message }}@else{{ old('testimonial_message') }}@endif</textarea>
                                @error('testimonial_message')
                                <div class="input-info danger-bg">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Status</label>

                                <div class="form-icon">
                                    <select name='testimonial_status'
                                            class="order-edit-control form-control @error('testimonial_status') danger-border @enderror">

                                        <option value=''>--Select--</option>

                                        <option value='1'
                                                @if(!empty($testimonialData->is_active) && $testimonialData->is_active==1) selected @endif>
                                            Active
                                        </option>
                                        <option value='2'
                                                @if(!empty($testimonialData->is_active) && $testimonialData->is_active==2) selected @endif>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('testimonial_status')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                    <span><img src="{{asset('business_assets/images/angledown.png')}}"
                                               alt="image"></span>
                                </div>
                            </div>
                        </div>
                        @if(empty($testimonialData->id))
                        <a href="javascript:void(0)"
                           class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                            Cancel
                        </a>
                        @else
                            <a href="{{route('admin-testimonials-tab')}}"
                               class="btn-size btn-rounded btn-gray ml-1 mr-1">
                                Cancel
                            </a>
                        @endif
                        <input type="hidden" name='testimonial_id'
                               value='@if(!empty($testimonialData->id)){{ $testimonialData->id }}@endif'>
                        <button
                                class="btn-size btn-rounded btn-primary ml-1 mr-1">@if(!empty($showTestimonialEdittab))
                                Update @else Add  @endif</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @include('layouts.jquery')
    <script>

      //show Discount Edit view
      @if(!empty($showTestimonialEdittab) || $errors->any())
      $('.customer-modal').modal('toggle');
        @endif

    </script>
    <script>
      let ids = [];
      $('[data-modal="modal"]').on('click', function() {
        if ($(this).data('id') === 'bulk') {
          $.each($('.list-check:checked'), function() {
            ids.push($(this).val());
          });
          $('#testimonial_id').val(ids);
        } else {
          $('#testimonial_id').val($(this).data('id'));
        }
        $('#status_id').val($(this).data('status'));
        $('[data-modal-title="title"]').text($(this).data('title'));
        $('#confirmForm').attr('action', $(this).data('url'));
        $('#method').val($(this).data('type'));
        $;
      });

      $('#checkAll').on('change', function() {
        if ($(this).is(':checked')) {
          $('.list-check').prop('checked', true);
        } else {
          $('.list-check').prop('checked', false);
        }
        $('#totalSelected').text($('.list-check:checked').length);

        if ($('.list-check:checked').length > 1){
          $('#selectCountText').text('Items')

          $('[data-id="bulk"]').each(function() {
            let $title = $(this).data('title');
            let $titleArr = $title.split(' ');
            $(this).data('title',$titleArr[0] + ' these testimonials')
          })

        }else{
          $('#selectCountText').text('Item')

          $('[data-id="bulk"]').each(function() {
            let $title = $(this).data('title');
            let $titleArr = $title.split(' ');
            $(this).data('title',$titleArr[0] + ' this testimonial')
          })
        }

      });
      $(function() {
        $('.list-check').on('change', function() {
          if ($('.list-check:checked').length === $('.list-check').length) {
            $('#checkAll').prop('checked', true);
          } else {
            $('#checkAll').prop('checked', false);
          }
          $('#totalSelected').text($('.list-check:checked').length);

          if ($('.list-check:checked').length > 1){
            $('#selectCountText').text('Items')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' these testimonials')
            })

          }else{
            $('#selectCountText').text('Item')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' this testimonial')
            })
          }
        });
      });

      function uploadDialog () {
        $('#imgupload').trigger('click');
      }

      $(function() {
        $('#imgupload').on('change', function() {
          readURL(this, 'userPreview');
        });

      });

      function readURL (input, preview) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
            $('#' + preview)
              .attr('src', e.target.result);
          };
          reader.readAsDataURL(input.files[0]);
        }
      }
    </script>
@endsection
