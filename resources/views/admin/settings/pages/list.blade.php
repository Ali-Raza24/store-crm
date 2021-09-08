<!--<div class="d-flex justify-content-between align-items-right" style='float: right;'>
    <a class="btn-size btn-rounded btn-primary" href="{{route('admin-page-add')}}"  data-target="#addNewTestimonials">Add</a>
</div>-->
<div class="d-flex justify-content-between align-items-center">
        <h4 class="font-weight-700 dark-one">All Pages</h4>
    </div>
    <div class="table-responsive scroll-bar-thin">
        <table class="table table-space">
            <thead>
            <tr>
                <!--<th scope="col" class="custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkAll" />
                    <label class="custom-control-label" for="checkAll"></label>
                </th>-->
                <th scope="col">Name</th>
                <th scope="col">Link</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($pages))
            @foreach($pages as $key => $page)
                <tr>
                    <!--<td class="custom-checkbox show-selected">
                        <input type="checkbox" value="{{$page->id}}" name="bulk_ids[]" class="custom-control-input list-check" id="customCheck{{$loop->iteration+2}}" />
                        <label class="custom-control-label" for="customCheck{{$loop->iteration+2}}"></label>
                    </td>-->
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="table-order-no">
                                <strong class="dark-one">
                                    {{$page->name}}
                                </strong>
                                <p class="mb-0">{{ date('M d, Y', strtotime($page->created_at)) }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="mb-0 order-name">{{$page->slug}}</p>
                    </td>
                    <td>
                        <div class="dropdown">
                                             <span class="dropdown-toggle" id="dropStore1" role="button"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span id="dropdown-text-{{ $page->id }}">
                                               @if(!empty($page))
                                                            @if($page->is_active ==1)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                                        @endif
                                                    </span>
                                                </span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropStore1">
                                <a class="dropdown-item" id=""
                                   onclick="pageStatusChange({{ $page->id ?? '' }},1)"
                                   href="javascript:void(0)">
                                    Active
                                </a>
                                <a class="dropdown-item" id=""
                                   onclick="pageStatusChange({{ $page->id ?? '' }},2)"
                                   href="javascript:void(0)">
                                    Inactive
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-action">
                            <a href="{{route("admin-page-edit",$page->id)}}"  class="edit-order mr-3">
                                <img alt="" src="{{asset('business_assets/images/edit1.png')}}"></a>
                            <!--<a href="javascript:void(0);" class="print-order"
                               data-toggle="modal"
                               data-id="{{$page->id}}"
                               data-url="{{route('admin-page-delete')}}"
                               data-modal="modal"
                               data-type="delete"
                               data-target="#confirmModal"
                               data-title="Delete">
                                <img alt="" src="{{asset('business_assets/images/delete.png')}}" />
                            </a>-->
                        </div>
                    </td>
                </tr>
            @endforeach
                @endif
            </tbody>
        </table>
    </div>
@if(!empty($pages))
    @php $paginator = $pages->toArray() @endphp
    <div class="d-flex justify-content-between">
        <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
        {!! $pages->appends(request()->getQueryString())->links() !!}
    </div>
@endif
@section('footer')
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
                       data-url="{{route('admin-page-bulk-status')}}"
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
                       data-url="{{route('admin-page-bulk-status')}}"
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
                       data-url="{{route('admin-page-bulk-delete')}}"
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
    <!-- Delete confirmation Modal -->
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="page_id" id="page_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title</span> Page?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Delete</span> this Page?</h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Delete</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                            Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('layouts.jquery')
<script>
    $("#flashAlertMsg").fadeIn('slow').delay(5000).hide("slow");
    function pageStatusChange (page_id, status_id) {
        $('.dropdown-toggle').dropdown('hide');
        if (page_id != '' && status_id != '') {
            $.ajax({
                url: '{{route('admin-Status-Update')}}',
                type: 'GET',
                dataType: 'json',
                data: { page_id: page_id, status_id: status_id },
                success: function (data) {
                    $('#dropdown-text-'+page_id).text(data.msg);
                    $("#ajaxRespPage").html(data.flashMsg);
                    $("#ajaxRespPage").fadeIn('slow').delay(5000).hide("slow");
                }
            })
        }else {alert('Error!, Page id not found.')}
    }
</script>
<script>
    let ids = [];
    $('[data-modal="modal"]').on('click', function(){

        if ($(this).data('id') === 'bulk'){

            $.each($('.list-check:checked'), function(){
                ids.push($(this).val())
            })
            $('#page_id').val(ids)
        } else {
            $('#page_id').val($(this).data('id'));
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
    })
    $(function(){
        $('.list-check').on('change', function(){
            if($('.list-check:checked').length === $('.list-check').length){
                $('#checkAll').prop('checked', true)
            }else{
                $('#checkAll').prop('checked', false)
            }
            $('#totalSelected').text($('.list-check:checked').length)
        })
    });

    function  uploadDialog() {
        $('#imgupload').trigger('click');
    }
    $(function () {
        $('#imgupload').on('change', function () {
            readURL(this, 'userPreview');
        });

    });
    //service image
    function  uploadDialogservice() {
        $('#imguploadservice').trigger('click');
    }
    $(function () {
        $('#imguploadservice').on('change', function () {
            readURL(this, 'userPreviewservice');
        });

    });
    function readURL(input, preview) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#'+preview)
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
    <script src="https://cdn.tiny.cloud/1/y2j3anbdodhunhucpjux2zfdq4vq5uo1ccdlasodaev0l6wq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>

    var demoBaseConfig = {
        selector: '#myTextarea, #pricingTextarea,#requstTextarea,#contactInfoTextarea',
        width: 1050,
        height: 500,
        resize: false,
        autosave_ask_before_unload: false,
        powerpaste_allow_local_images: true,
        plugins: [
            'a11ychecker advcode advlist anchor autolink codesample fullscreen help image imagetools tinydrive',
            ' lists link media noneditable powerpaste preview',
            ' searchreplace table template tinymcespellchecker visualblocks wordcount'
        ],
        toolbar:
            'insertfile a11ycheck undo redo | bold italic | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image tinydrive',
        spellchecker_dialog: true,
        spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
        tinydrive_demo_files_url: '/docs/demo/tiny-drive-demo/demo_files.json',
        tinydrive_token_provider: function (success, failure) {
            success({ token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo' });
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    };

    tinymce.init(demoBaseConfig);
    //Form submit
    function submitPageEditForm(){
        document.getElementById("updatepageform").submit();
    }

</script>
@endsection
