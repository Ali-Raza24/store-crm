@extends('layouts.business.setting-layout')

@section('title','Main Page')

@section('header_heading', "Main Page")

@section("header_subheading", "Overview")

@section('stylesheet')
    <link rel="stylesheet" href="{{asset('plugins/kartik-fileupload/css/fileinput.min.css')}}" />
@endsection
@section('content')

    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('business.settings.pages.navbar')
                <div class="dropdown tabs-dropdown desktop-hide">
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Pages
                    </button>
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Main Page
                    </button>
                    {{--<div class="dropdown-menu" aria-labelledby="dropTab">
                        <a class="nav-item nav-link active" href="javascript:void(0)">Add</a>
                    </div>--}}
                </div>
                <hr class="m-0" />
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="col-12" id='flashmessage'> @include('flash::message')</div>
                    <form action="">
                        <div class="row">
                            <div class="col-sm-6 form-group mb-3" id="web_banner">
                                <label class="font-weight-600 dark-one mb-2">Web banner (Dimension: 1115 X 240)</label>
                                <input type="file" name='images[web_banner]' />
                            </div>
                            <div class="col-sm-6 form-group mb-3" id="mobile_banner">
                                <label class="font-weight-600 dark-one mb-2">Mobile banner (Dimension: 400 X 260)</label>
                                <input type="file" name='images[mobile_banner]' />
                            </div>
                        </div>
                    </form>

                    <hr class="mt-5 mb-5"/>

                    <form method='post' id='updatepageform' enctype='multipart/form-data'
                          action='{{route('business-main-page-setting')}}'>
                        @csrf
                        {!! method_field('put') !!}
                        {!! Form::hidden('page_id', optional($page)->id) !!}
                        <div class="row">
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Heading</label>
                                <input type="text" name='heading' value='{{optional($page)->heading ?? ''}}' class="form-control order-edit-control @error('heading') danger-border @enderror"/>
                                @error('heading')
                                <div class="input-info danger-bg">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Sub Heading</label>
                                <input type="text" name='sub_heading' value='{{optional($page)->sub_heading ?? ''}}' class="form-control order-edit-control @error('sub_heading') danger-border @enderror"/>
                                @error('sub_heading')
                                <div class="input-info danger-bg">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label class="font-weight-600 dark-one">Description</label>
                                <input type="text" name='content' value='{{optional($page)->content ?? ''}}' class="form-control order-edit-control @error('content') danger-border @enderror"/>
                                @error('content')
                                <div class="input-info danger-bg">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr class="mt-5 mb-3"/>
                        <div class="form-group text-right">
                            <button class="btn-size btn-primary btn-rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')
@endsection

@section('custom_script')
    <script src="{{asset('plugins/kartik-fileupload/js/fileinput.min.js')}}"></script>
    <script src="{{asset('plugins/kartik-fileupload/themes/fas/theme.min.js')}}"></script>

    <script>
      $(function() {
          @if($page->web_banner)
            var webBanner = '{{$page->web_banner}}';
            var webBannerInfo = webBanner.split('/');
            webBannerInfo = webBannerInfo[webBannerInfo.length - 1];
            webBannerInfo = webBannerInfo.split('.');
          @endif
          @if($page->mobile_banner)
            var mobileBanner = '{{$page->mobile_banner}}';
            var mobileBannerInfo = mobileBanner.split('/');
            mobileBannerInfo = mobileBannerInfo[mobileBannerInfo.length - 1];
            mobileBannerInfo = mobileBannerInfo.split('.');
          @endif
          $('[name="images[web_banner]"]').fileinput({
            theme: 'fas',
            uploadUrl: "{{route('business-main-page-setting')}}",
            uploadExtraData: { _token: "{{csrf_token()}}", 'page_id': {{$page->id}}, 'web_banner_image': true },
            msgAjaxError:'Please upload image size of 1115 X 237',
            allowedFileExtensions: ['png', 'jpg'],
              @if($page->web_banner)
                initialPreview: ["<img src="+webBanner+" class='w-100' alt=''/>"],
                // initialPreviewAsData: true,
                initialPreviewConfig: [
                  { caption: webBannerInfo, filename: webBannerInfo, width: '120px', key: 2 }
                ],
                overwriteInitial: true,
              @endif
              showRemove: false,
            browseOnZoneClick: true,
            dropZoneTitle: 'Drop or Click to Upload Web Banner',
            dropZoneClickTitle: ''
          }).on("filebatchselected", function(event, files) {
            $('[name="images[web_banner]"]').fileinput("upload");
          }).on('fileselect', function() {
            $('#web_banner .file-preview-success').remove();
          })

        $('[name="images[mobile_banner]"]').fileinput({
          theme: 'fas',
          allowedFileExtensions: ['png', 'jpg'],
          uploadUrl: "{{route('business-main-page-setting')}}",
          uploadExtraData: { _token: "{{csrf_token()}}", 'page_id': {{$page->id}}, 'mobile_banner_image': true },
            @if($page->mobile_banner)
            initialPreview: ["<img src="+mobileBanner+" class='w-100' alt='img' />"],
              // initialPreviewAsData: true,
              initialPreviewConfig: [
                { caption: mobileBannerInfo, filename: mobileBannerInfo, width: '120px', key: 2 }
              ],
            @endif
          showRemove: false,
          browseOnZoneClick: true,
          dropZoneTitle: 'Drop or Click to Mobile Banner',
          dropZoneClickTitle: ''
        });
      }).on("filebatchselected", function(event, files) {
        $('[name="images[mobile_banner]"]').fileinput("upload");
      }).on('fileselect', function() {
        $('#mobile_banner .file-preview-success').remove();
      });
    </script>
@endsection
