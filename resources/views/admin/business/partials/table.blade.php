<div class="sf-order">
    @include('flash::message')
    <div class="table-responsive scroll-bar-thin">
        <table class="table table-space table-check no-bor-input">
            <thead>
            <tr>
                <th scope="col" class="custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkAll" />
                    <label class="custom-control-label" for="checkAll"></label>
                </th>
                <th scope="col">Business ID</th>
                <th scope="col">Name</th>
                <th scope="col">Business Dashboard</th>
                <th scope="col">Contact</th>
                <th scope="col">Plan Type</th>
{{--                <th scope="col">Store Url</th>--}}
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
                /**
                 * @var $business \App\Models\Business
                 */
                ?>
            @foreach($businesses as $business)
                <tr class="">
                    <td class="custom-checkbox show-selected cursor-pointer">
                        <input
                                type="checkbox"
                                name="bulk_ids[]"
                                class="custom-control-input business-list list-check"
                                id="customCheck{{$loop->iteration+2}}"
                                value="{{$business->id}}"
                        />
                        <label
                                class="custom-control-label"
                                for="customCheck{{$loop->iteration+2}}"
                        ></label>
                    </td>
                    <td>
                        <div class="table-order-no">
                            <strong class="dark-one">
                                <a href="{{config('urls.store_url').'/'.$business->url}}" target="_blank"
                                >#{{ $business->id }}</a
                                >
                            </strong>
                            <p class="mb-0">Added: {{ $business->created_at }}</p>
                        </div>
                    </td>
                    <td>
                        <p class="mb-0 order-name"><a href="{{route('admin-business-detail',['id' => $business->id])}}">{{ $business->name }}</a></p>
                        <small class="mb-0 order-name">{{ optional($business->businessType)->title }}</small>
                    </td>
                    <td>
                        <form action="{{route('admin-business-login')}}" id="AdminToBusinessLogin{{$business->id}}" method="post">@csrf
                            {!! Form::hidden('email', $business->owner_email) !!}
                        </form>
                        <strong class="mb-0 order-store"><a href="#" onclick="AdminLoginToBusiness({{$business->id}})">Business Dashboard</a></strong></td>
                    <td>
                        <p class="mb-0 order-store">
                            {{ $business->owner_phone ?? $business->phone }}
                            @if(!empty($business->owner_mobile) && $business->owner_phone) <span style="font-size: 1.5em">|</span> @endif
                            {{ $business->owner_mobile ?? $business->mobile}}</p>
                        <p class="mb-0 order-store">{{ $business->owner_email ?? $business->email}}</p>
                    </td>
                    <td>
                        <div class="dropdown border-dropdown">
                            <button class="dropdown-toggle" type="button" id="dropProd"
                                    data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"
                            >
                                {{ $business->plan_name }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right"
                                 aria-labelledby="dropProd"
                                 style="position: absolute;
                                                 transform: translate3d(-63px,40px,0px);
                                                 top: 0px;left: 0px;
                                                 will-change: transform;"
                                 x-placement="bottom-end"
                            >
                                @foreach(\App\Helpers\CommonHelper::plans() as $key => $plan)
                                    @if($key != $business->plan_id)
                                <a class="dropdown-item" href="javascript:void(0)"
                                   data-url="{{route('update-plan')}}"
                                   data-plan="{{$key}}"
                                   data-type="put"
                                   data-toggle="modal"
                                   data-modal="modal"
                                   data-target="#confirmModal"
                                   data-title="Change plan type to {{$plan}}"
                                   data-id="{{$business->id}}"
                                >{{$plan}}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </td>
{{--                    <td>{!! $business->url !!}</td>--}}
                    <td>
                        <div class="dropdown border-dropdown">
                            <button
                                    class="dropdown-toggle"
                                    type="button"
                                    id="dropStatus"
                                    data-toggle="dropdown"
                                    aria-haspopup="false"
                                    aria-expanded="false"
                            >
                                {{ $business->business_status }}
                            </button>
                            <ul
                                    class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="dropStatus"
                                    style="position: absolute;
                                                    transform: translate3d(-63px,40px,0px);
                                                    top: 0px;left: 0px;will-change: transform;"
                                    x-placement="bottom-end"
                            >
                                @foreach(\App\Helpers\CommonHelper::businessStatus() as $key => $status)
                                    @if($business->business_status_id != $key)
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)"
                                       data-url="{{route('update_business_status')}}"
                                       data-status="{{$key}}"
                                       data-type="put"
                                       data-toggle="modal"
                                       data-modal="modal"
                                       data-target="#confirmModal"
                                       data-title="{{$status}} Business"
                                       data-id="{{$business->id}} Business"
                                    >{{$status}}</a>
                                </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </td>
                    <td>
                        <div class="table-action">
                            <a href="{{route('admin-business-detail',['id' => $business->id])}}" class="edit-order"
                            >
                                <img alt="" src="{{asset('admin_assets/images/edit.png')}}" />
                            </a>
                            <a href="#" class="print-order">
                                <img alt="" src="{{asset('admin_assets/images/delete-gray.png')}}"
                                     data-url="{{route('admin-business-delete')}}"
                                     data-status=""
                                     data-type="delete"
                                     data-toggle="modal"
                                     data-modal="modal"
                                     data-target="#confirmModal"
                                     data-title="Delete this business"
                                     data-id="{{$business->id}}"/>
                            </a>
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
