@extends('layouts.business.setting-layout')

@section('title','All Pages')

@section('header_heading', "All Pages")
@section('header_heading_mobile', "All Pages")

@section("header_subheading", "Overview")
@section("header_subheading_mobile", "Overview")

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
					{{--<div class="dropdown-menu" aria-labelledby="dropTab">
						<a class="nav-item nav-link active" href="javascript:void(0)">Add</a>
					</div>--}}
				</div>
				<hr class="m-0"/>
				<div class="tab-content mt-5" id="nav-settingContent">
                    <div class="col-12" id='flashmessage'> @include('flash::message')</div>
                    <div class="col-12 alert alert-success" id="ajaxRespPage" style='display: none;'>
                        <button type="button" class="close" data-dismiss="alert">x</button>
                    </div>
                    <div class="tab-pane fade pro-table-seting  {{request()->routeIs('business-page-setting') ? 'show active' : ''}}" id="Pages" role="tabpanel">
                    	@include('business.settings.pages.list')
                    </div>
                    <div class="tab-pane fade {{request()->routeIs('business-page-add') ? 'show active' : ''}}{{request()->routeIs('business-page-edit') ? 'show active' : ''}}" id="In-Active" role="tabpanel" aria-labelledby="settStore">
						@include('business.settings.pages.add')
                    </div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	@include('layouts.jquery')
@endsection


@section('custom_script')
	<script>
		$("#flashmessage").fadeIn('slow').delay(5000).hide("slow");
		function pageStatusChange (page_id, status_id) {
			$('.dropdown-toggle').dropdown('hide');
			if (page_id != '' && status_id != '') {
				$.ajax({
					url: '{{ route("business-Status-Update") }}',
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



	</script>
	<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
	<script>

		CKEDITOR.replace('myTextarea', {
			on: {
				pluginsLoaded: function () {
					var editor = this,
							config = editor.config
					config.height = 500
					editor.ui.addRichCombo('my-combo', {

						onClick: function (value) {
							editor.focus()
							editor.fire('saveSnapshot')

							editor.insertHtml(value)

							editor.fire('saveSnapshot')
						}
					})
				}
			}
		})


		function submitPageEditForm(){
			document.getElementById("updatepageform").submit();
		}

	</script>
@endsection

