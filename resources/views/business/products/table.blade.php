<div class="sf-order">
    <div class="table-responsive scroll-bar-thin">
        <table class="table table-space table-check">
            <thead>
            <tr>
                @if(plan_has_permission(['product-bulk-status', 'product-bulk-delete']))
                <th scope="col" class="custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkAll">
                    <label class="custom-control-label" for="checkAll"></label>
                </th>
                @endif
                <th scope="col">Product Title</th>
                <th scope="col" style="white-space: break-spaces">Product Availability Stores</th>
                <th scope="col">Category <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                <th scope="col">Brand <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                <th scope="col">Cost Price <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                <th scope="col">Retail Price <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                <th scope="col">Disc Price <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                <th scope="col">Status <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <?php
                $status = \App\Helpers\CommonHelper::getStatus($product->is_active);
                ?>
                <tr>
                    @if(plan_has_permission(['product-bulk-status', 'product-bulk-delete']))
                    <td class="custom-checkbox show-selected">
                        <input type="checkbox" class="custom-control-input list-check" value="{{$product->id}}"
                               id="customCheck{{$loop->iteration+2}}">
                        <label class="custom-control-label" for="customCheck{{$loop->iteration+2}}"></label>
                    </td>
                    @endif
                    <td onclick="window.location.href= '{{route('products-edit',$product->id)}}'"
                        class="cursor-pointer">
                        <div class="table-order-no" style="white-space: break-spaces"><strong class="dark-one">{{$product->title}}</strong><p class="mb-0">Added: {{$product->created_at}}</p></div>
                    </td>
                    <td style="white-space: break-spaces"><p class="mb-0 order-store">{{join(', ',$product->product_stores)}}</p></td>
                    <td style="white-space: break-spaces"><p class="mb-0 order-name">{{join(', ',$product->product_category)}}</p></td>
                    <td><p class="mb-0 order-store">{{optional($product->brand)->title}}</p></td>
                    <td><p class="mb-0 order-total">{{$product->cost_price}}</p></td>
                    <td><p class="mb-0 order-store"> {{$product->retail_price}}</p></td>
                    <td><span>@if(empty($product->discounted_price)) 0.00 @else {{$product->discounted_price}} @endif </span></td>
                    <td>
                        <div class="dropdown">
                            <span class="dropdown-toggle" id="dropTable1" role="button" data-toggle="dropdown"
                                  aria-haspopup="true" aria-expanded="false">
                                {!! $status !!}
                            </span>
                            @if(plan_has_permission(['product-status']))
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropTable1">
                                @if($status == 'InActive')
                                    <a class="dropdown-item"
                                       href="javascript:void(0)"
                                       data-toggle="modal"
                                       data-modal="modal"
                                       data-target="#confirmModal"
                                       data-title="Activate"
                                       data-url="{{route('product-status')}}"
                                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                                       data-type="put"
                                       data-id="{{$product->id}}"
                                    >
                                        Active
                                    </a>
                                @else
                                    <a class="dropdown-item"
                                       href="javascript:void(0)"
                                       data-url="{{route('product-status')}}"
                                       data-status="{{\App\Constants\IStatus::DISABLE}}"
                                       data-type="put"
                                       data-toggle="modal"
                                       data-modal="modal"
                                       data-target="#confirmModal"
                                       data-title="InActivate"
                                       data-id="{{$product->id}}"
                                    >
                                        Inactive
                                    </a>
                                @endif
                            </div>
                                @endif
                        </div>
                    </td>
                    <td>
                        <div class="table-action">
                            @if(plan_has_permission(['product-edit']))
                            <a href="{{route("products-edit",$product->id)}}"  class="edit-order mr-3">
                                <img alt="" src="{{asset('business_assets/images/edit1.png')}}"></a>
                            @endif
                            @if(plan_has_permission(['product-delete']))
                            <a href="javascript:void(0);" class="print-order"
                               data-toggle="modal"
                               data-id="{{$product->id}}"
                               data-url="{{route('product-delete')}}"
                               data-modal="modal"
                               data-type="delete"
                               data-target="#confirmModal"
                               data-title="Delete this product"
                            >
                                <img alt="" src="{{asset('business_assets/images/delete.png')}}" />
                            </a>
                                @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @php $paginator = $products->toArray() @endphp
    <div class="d-flex justify-content-between">
        <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
        {!! $products->appends(request()->getQueryString())->links() !!}
    </div>
</div>
