{{--<script src="{{asset('business_assets/js/jquery-3.2.1.min.js')}}"></script>--}}
{{--<script src="{{asset('business_assets/js/bootstrap.bundle.min.js')}}"></script>--}}

<script src="{{asset_timestamp('js/notifications.js')}}"></script>
<script src="{{asset('business_assets/js/apexcharts.js')}}"></script>
<script src="{{asset('business_assets/js/jquery-countTo.js')}}"></script>
<script src="{{asset('business_assets/js/nouislider.js')}}"></script>
<script src="{{asset('plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('admin_assets/js/jquery-ui.min.js')}}"></script>

<script src="{{asset('plugins/jquery-blueimp/js/vendor/jquery.ui.widget.js')}}"></script>
<script src="{{asset('plugins/jquery-blueimp/js/load-image.all.min.js')}}"></script>
<script src="{{asset('plugins/jquery-blueimp/js/jquery.fileupload.js')}}"></script>
<script src="{{asset('plugins/jquery-blueimp/js/jquery.fileupload-ui.js')}}"></script>
<script src="{{asset('plugins/cropper/cropper.js')}}"></script>
<script src="{{asset('plugins/cropper/jquery-cropper.js')}}"></script>
<script src="{{asset_timestamp('business_assets/js/custom.js')}}"></script>

<script>
  function adminLogout(){
    $('#adminLogoutForm').submit();
  }
</script>

<script>
  window.Laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
    ]) !!};
</script>

@yield('custom_script')
