@section('css')
<style>
#showProdDropdown .select2{width: 100% !important;}
.custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before{
    color: #fff;
    background-color: transparent;
    border-color: #b3d7ff
}
</style>
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
                @if(plan_has_permission(['discount-bulk-status']))
                <li>
                    <a href="javascript:void(0)" class="item-btn note-option"
                       data-url="{{route('discount-bulk-status')}}"
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
                       data-url="{{route('discount-bulk-status')}}"
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
                @endif
                @if(plan_has_permission(['discount-bulk-delete']))
                <li>
                    <a href="javascript:void(0)" class="item-btn export-option"
                       data-toggle="modal"
                       data-url="{{route('discount-bulk-delete')}}"
                       data-modal="modal"
                       data-type="delete"
                       data-target="#confirmModal"
                       data-title="Delete"
                       data-id="bulk"
                    >
                        <span>Delete</span>
                    </a>
                </li>
                    @endif
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
                        <input type="hidden" name="discount_id" id="discount_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title Discount</span>?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Delete this Discount</span>?</h4>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                            Cancel </a>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Delete</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="discounts">
        <add-discount
                save_discount_url="{{route('discount-store')}}"
                products="{{json_encode($products)}}"
                generate_code_url="{{route('generate-code')}}"
                current-date="{{\Carbon\Carbon::now()->toAtomString()}}"
                @if(!empty($isEdit))
                is-edit="true"
                existing-discount="{{json_encode($discountData)}}"
                @endif
        ></add-discount>
    </div>

    <div class="body-overlay"></div>
@endsection


@section('scripts')
    <script src="{{asset_timestamp('js/discount.js')}}"></script>

    <script>
        @if(!empty($isEdit))
        $('body').toggleClass('add-discount');
        @endif
        let ids = [];
        $('[data-modal="modal"]').on('click', function(){
            if ($(this).data('id') === 'bulk'){
                $.each($('.list-check:checked'), function(){
                    ids.push($(this).val())
                })
                $('#discount_id').val(ids)
            } else {
                $('#discount_id').val($(this).data('id'));
            }
            $('#status_id').val($(this).data('status'));
            $('[data-modal-title="title"]').text($(this).data('title'))
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

          if ($('.list-check:checked').length > 1){
            $('#selectCountText').text('Items')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' these discounts')
            })

          }else{
            $('#selectCountText').text('Item')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' this discount')
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
                  $(this).data('title',$titleArr[0] + ' these discounts')
                })

              }else{
                $('#selectCountText').text('Item')

                $('[data-id="bulk"]').each(function() {
                  let $title = $(this).data('title');
                  let $titleArr = $title.split(' ');
                  $(this).data('title',$titleArr[0] + ' this discount')
                })
              }
            })
        })
    </script>
@endsection
