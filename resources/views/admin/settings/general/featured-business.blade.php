@extends('layouts.admin.app')

@section('title', 'Featured Business')
@section('heading', 'Featured Business')

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
                <hr class="m-0"/>
                <div class="tab-content mt-5" id="nav-settingContent">

                    <div class="tab-pane fade pro-table-seting {{request()->routeIs('admin-businesses-tab') ? 'show active' : ''}}" id="settPayment" role="tabpanel" aria-labelledby="settPayment">
                        <div class="col-12"> @include('flash::message')</div>
                        <?php if(!empty($businessesSearchData)){print_r($businessesSearchData);} ?>
                        <div class="col-12 alert alert-success" id="ajaxResp" style='display: none;'>
                            <button type="button" class="close" data-dismiss="alert">x</button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="font-weight-700 dark-one">
                                All Featured
                            </h4>
                            <form class="header-search">
                                <div class="form-group form-icon" id='searchform'>
                                    <input name='search_business_name' type="text" placeholder="Search your keyword..." class="form-control" value="{{request('search_business_name')}}"/>
                                    <span>
                                        <img alt="" src="{{asset('admin_assets/images/search.png')}}" onclick='submit();'/>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive scroll-bar-thin">
                            <table class="table table-space table-check">
                                <thead>
                                <tr>
                                    <th scope="col" class="custom-checkbox pl-0 pr-0">
{{--                                        <input type="checkbox" class="custom-control-input" id="checkAll"/>--}}
{{--                                        <label class="custom-control-label" for="checkAll">--}}
{{--                                        </label>--}}
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Featured</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($businesses as $key => $business)
                                    <tr>

                                        <td class="custom-checkbox show-selected pl-0 pr-0">
{{--                                            <input type="checkbox" value="{{$business->id}}" name="bulk_ids[]" class="custom-control-input list-check" id="customCheck{{$loop->iteration+2}}" />--}}
{{--                                            <label class="custom-control-label" for="customCheck{{$loop->iteration+2}}"></label>--}}

                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="table-order-no ml-3">
                                                    <strong class="dark-one">
                                                        <a href="#">{{$business->name}}</a>
                                                    </strong>
                                                    <p class="mb-0">{{$business->created_at}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col">
                                            <div class="custom-checkbox">
                                                <input onchange="testimonialStatusChange({{ $business->id }})" type="checkbox" value='{{$business->name}}' class="custom-control-input featureCheckbox" id="{{$key+1}}" @if(!empty($business) && $business->is_featured==1) checked @endif/>
                                                <label class="custom-control-label" for="{{$key+1}}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @php $paginator = $businesses->toArray() @endphp
                        <div class="d-flex justify-content-between">
                            <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
                            {!! $businesses->appends(request()->getQueryString())->links() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('layouts.jquery')
    <script>
        function testimonialStatusChange(business_id) {
            if (business_id != '') {
                $.ajax({
                    url: '{{ route("admin-businesses-bulk-status") }}',
                    type: 'GET',
                    dataType: 'json',
                    data: { business_id: business_id},
                    success: function (data) {
                        console.log(data);
                        $("#ajaxResp").html(data);
                        $("#ajaxResp").fadeIn('slow').delay(5000).hide("slow");
                    }
                })
            }else {alert('Error!, Business id not found.')}
        }
        document.getElementById("searchform").submit();
    </script>
@endsection
