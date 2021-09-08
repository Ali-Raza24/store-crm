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
                       data-url="{{route('admin-area-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Activate this area"
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
                       data-title="InActive this area"
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
                       data-title="Delete this area"
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
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title area?</span></h2>
                        <h4 class="dark-two mb-3" data-title="sub-heading">Are you sure to <span data-modal-title="title" class="text-lowercase">Delete this area</span>?</h4>
                        <h4 class="dark-two mb-3 d-none" data-title="warning">Are you sure to <span data-modal-title="title" class="text-lowercase">Delete this area</span>?</h4>
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
                @if(!empty($editArea))
                edit_area="{{json_encode($editArea)}}"
                @endif
        ></add-area>
    </div>

    <div class="body-overlay"></div>
@endsection

@section('scripts')
    <script src="{{asset_timestamp('js/admin/areas.js')}}"></script>
    <script src="{{asset('admin_assets/js/select2.min.js')}}"></script>
    <script>
        @if(!empty($editArea))
        $('body').toggleClass('add-area');
        $('body').toggleClass('add-customer');
        @endif
        let ids = [];
        $('[data-modal="modal"]').on('click', function(){
          if ($(this).data('id') === 'bulk'){
            $.each($('.list-check:checked'), function(){
              ids.push($(this).val())
            })
            $('#area_id').val(ids)
          } else {
            $('#area_id').val($(this).data('id'));
          }
          $('#status_id').val($(this).data('status'));

          let $warning = $('[data-title="warning"]');
          let $subHeading = $('[data-title="sub-heading"]');
          if ($(this).data('used') > 0 && $(this).data('type') === 'put'){
            if (!$subHeading.hasClass('d-none')){
              $subHeading.addClass('d-none')
            }
            $warning.text('This area is associated with City. Are you sure you want to deactivate it?')
            $('[data-modal-title="title"]').text($(this).data('title'))
            if ($warning.hasClass('d-none')){
              $warning.removeClass('d-none')
            }
          }
          if ($(this).data('used') > 0 && $(this).data('type') === 'delete'){
            if (!$subHeading.hasClass('d-none')){
              $subHeading.addClass('d-none')
            }
            $warning.text('This area is associated with City. Are you sure you want to delete it?')
            $('[data-modal-title="title"]').text($(this).data('title'))
            if ($warning.hasClass('d-none')){
              $warning.removeClass('d-none')
            }
          }
          if (!$(this).data('used')){
            if (!$warning.hasClass('d-none')){
              $warning.addClass('d-none')
            }
            $('[data-modal-title="title"]').text($(this).data('title'))
            if ($subHeading.hasClass('d-none')){
              $subHeading.removeClass('d-none')
            }
          }
          $('#confirmForm').attr('action',$(this).data('url'))
          $('#method').val($(this).data('type'))
          $
        });

        $('#checkAll').on('change',function(){
          if ($(this).is(':checked')){
            $('.list-check').prop('checked', true)
          }else{
            $('.list-check').prop('checked', false)
          }
          $('#totalSelected').text($('.list-check:checked').length)
          if ($('.list-check:checked').length > 1) {
            $('#selectCountText').text('Items')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title', $titleArr[0] + ' these areas')
            })
          }else{
            $('#selectCountText').text('Item')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' this area')
            })
          }
        })
        $(function(){
          $('.list-check').on('change', function(){
            if($('.list-check:checked').length === $('.list-check').length){
              $('#checkAll').prop('checked', true)
            }else{
              $('#checkAll').prop('checked', false)
            }
            $('#totalSelected').text($('.list-check:checked').length)

            if ($('.list-check:checked').length > 1){
              $('#selectCountText').text('Items')

              $('[data-id="bulk"]').each(function() {
                let $title = $(this).data('title');
                let $titleArr = $title.split(' ');
                $(this).data('title',$titleArr[0] + ' these areas')
              })
            }else{
              $('#selectCountText').text('Item')

              $('[data-id="bulk"]').each(function() {
                let $title = $(this).data('title');
                let $titleArr = $title.split(' ');
                $(this).data('title',$titleArr[0] + ' this area')
              })
            }
          })
        })
    </script>
@endsection
