@extends('layouts.admin.app')

@section('title', 'Pages')
@section('heading', 'Pages')

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
		<div class="col-lg-4">
			@include('admin.settings.sidebar')
		</div>
		<div class="col-lg-8">
			<div class="card-repeat setting-general pb-3 mt-4">
				@include('admin.settings.pages.navbar')
				<div class="dropdown tabs-dropdown desktop-hide">
					<button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Pages
					</button>
					<div class="dropdown-menu" aria-labelledby="dropTab">
						<a class="nav-item nav-link active" href="javascript:void(0)">Add</a>
					</div>
				</div>
				<hr class="m-0"/>
				<div class="tab-content mt-5" id="nav-settingContent">
                    <div class="col-12" id='flashAlertMsg'> @include('flash::message')</div>
                    <div class="col-12 alert alert-success" id="ajaxRespPage" style='display: none;'>
                        <button type="button" class="close" data-dismiss="alert">x</button>
                    </div>
                    <div class="tab-pane fade pro-table-seting {{request()->routeIs('admin-page-setting') ? 'show active' : ''}}" id="Pages" role="tabpanel">
                    @include('admin.settings.pages.list')
                    </div>
                    <div class="tab-pane fade {{request()->routeIs('admin-page-add') ? 'show active' : ''}}{{request()->routeIs('admin-page-edit') ? 'show active' : ''}}" id="In-Active" role="tabpanel" aria-labelledby="settStore">
					@include('admin.settings.pages.add')
                    </div>
				</div>
			</div>
		</div>
	</div>

@endsection

