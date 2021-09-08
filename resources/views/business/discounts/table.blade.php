<div class="sf-order">
    <div class="table-responsive scroll-bar-thin">
        <table class="table table-space table-check">
            <thead>
            <tr>
                @if(plan_has_permission(['discount-bulk-status', 'discount-bulk-delete']))
                <th scope="col" class="custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkAll" />
                    <label class="custom-control-label" for="checkAll"></label>
                </th>
                @endif
                <th scope="col">Discount Code</th>
                <th scope="col">Title</th>
                <th scope="col">Used</th>
                <th scope="col">Max Usage</th>
                <th scope="col">Value Used</th>
                <th scope="col">Validity <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                    @if(plan_has_permission(['discount-status']))
                <th scope="col">Status <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                    @endif
                    @if(plan_has_permission(['discount-edit', 'discount-delete']))
                <th scope="col"></th>
                        @endif
            </tr>
            </thead>
            <tbody>
            @if(!empty($discounts))
                @foreach($discounts  as $key=> $discount)
                    <tr>
                        @if(plan_has_permission(['discount-bulk-status', 'discount-bulk-delete']))
                        <td class="custom-checkbox show-selected">
                            <input type="checkbox" value="{{$discount->id}}" name="bulk_ids[]" class="custom-control-input list-check" id="customCheck{{$loop->iteration+2}}" />
                            <label class="custom-control-label" for="customCheck{{$loop->iteration+2}}"></label>
                        </td>
                        @endif
                        <td>
                            <div class="table-order-no">
                                <strong class="dark-one">
                                    <a href="#" class="">{{ $discount->code }}</a></strong>
                                <p class="mb-0">{{$discount->discount_value}} {{($discount->discount_type_id == 1) ? '%' : 'Flat'}} off
                                {{($discount->all_products == 1) ? 'All Products' : substr($discount->discount_products, 0, 20).'...'}}
                                </p>
                            </div>
                        </td>
                        <td>
                            <p class="mb-0">{{$discount->title}}</p>
                        </td>
                        <td>
                            <p class="mb-0 order-name"> 0 </p>
                        </td>
                        <td>
                            <p class="mb-0 order-name">{{$discount->maximum_usage}}</p>
                        </td>
                        <td><p class="mb-0 order-store">AED {{ $discount->sum_discount_used }}</p></td>
                        <td><p class="mb-0 order-store">{{ $discount->discount_duration }}</p></td>
                            @if(plan_has_permission(['discount-status']))
                        <td>
                            <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropStore1" role="button"
                                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span id="dropdown-text-{{ $discount->id }}">
                                            @if(!empty($discount))
                                                    @if($discount->is_active == \App\Constants\IStatus::ACTIVE)
                                                        Active
                                                    @else
                                                        Inactive
                                                    @endif
                                                @endif
                                            </span>
                                        </span>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropStore1">

                                    @if($discount->is_active == \App\Constants\IStatus::DISABLE)
                                        <a class="dropdown-item"
                                           href="javascript:void(0)"
                                           data-toggle="modal"
                                           data-modal="modal"
                                           data-target="#confirmModal"
                                           data-title="Activate this discount"
                                           data-url="{{route('discount-status')}}"
                                           data-status="{{\App\Constants\IStatus::ACTIVE}}"
                                           data-type="put"
                                           data-id="{{$discount->id}}"
                                        >
                                            Active
                                        </a>
                                    @else
                                        <a class="dropdown-item"
                                           href="javascript:void(0)"
                                           data-url="{{route('discount-status')}}"
                                           data-status="{{\App\Constants\IStatus::DISABLE}}"
                                           data-type="put"
                                           data-toggle="modal"
                                           data-modal="modal"
                                           data-target="#confirmModal"
                                           data-title="InActive this discount"
                                           data-id="{{$discount->id}}"
                                        >
                                            Inactive
                                        </a>
                                    @endif
                                </div>



                            </div>
                        </td>
                            @endif
                            @if(plan_has_permission(['discount-edit', 'discount-delete']))
                        <td>
                            <div class="table-action">
                                @if(plan_has_permission(['discount-edit']))
                                <a href="{{route("discount-edit",$discount->id)}}"  class="edit-order mr-3">
                                    <img alt="" src="{{asset('business_assets/images/edit1.png')}}"></a>
                                @endif
                                    @if(plan_has_permission(['discount-delete']))
                                <a href="javascript:void(0);" class="print-order"
                                   data-toggle="modal"
                                   data-id="{{$discount->id}}"
                                   data-url="{{route('discount-delete')}}"
                                   data-modal="modal"
                                   data-type="delete"
                                   data-target="#confirmModal"
                                   data-title="Delete this discount">
                                    <img alt="" src="{{asset('business_assets/images/delete.png')}}" />
                                </a>
                                        @endif
                            </div>
                        </td>
                                @endif
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        @if(empty($discounts[0]['id']))  <p>No records found</p>@endif
    </div>
    @php $paginator = $discounts->toArray() @endphp
    <div class="d-flex justify-content-between">
        <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
        {!! $discounts->appends(request()->getQueryString())->links() !!}
    </div>
</div>
