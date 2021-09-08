<div class="sf-order">
    <div class="table-responsive scroll-bar-thin">
        <table class="table table-space table-check">
            <thead>
            <tr>
                <th scope="col" class="custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkAll" />
                    <label class="custom-control-label" for="checkAll"></label>
                </th>
                <th scope="col">Customer ID</th>
                <th scope="col">
                    Name
                    <img src="{{asset('admin_assets/images/sort.png')}}" alt="image"/>
                </th>
                <th scope="col">Contact</th>
                <th scope="col">
                    Subscribed
                    <img src="{{asset('admin_assets/images/sort.png')}}" alt="image"/>
                </th>
                <th scope="col">Business Name</th>
                <th scope="col">Total Amount</th>
            </tr>
            </thead>
            <tbody>

            @foreach($allCustomers as $key => $customer)
                <tr>
                    <td class="custom-checkbox show-selected">
                        <input type="checkbox" value="{{$customer->id}}" name="bulk_ids[]" class="custom-control-input list-check" id="customCheck{{$loop->iteration+2}}" />
                        <label class="custom-control-label" for="customCheck{{$loop->iteration+2}}"></label>
                    </td>
                    <td>
                        <div class="table-order-no">
                            <strong class="dark-one">
                                <a href="#">{{$customer->code ?? ''}}</a>
                            </strong>
                            <p class="mb-0">
                                {{$customer->date_created ?? ''}}
                            </p>
                        </div>
                    </td>
                    <td>
                        <p class="mb-0 order-name">
                            {{$customer->owner_name ?? ''}}

                        </p>
                    </td>
                    <td>
                        <p class="mb-0 order-store"> {{ $customer->owner_phone }} </p>
                        <p class="mb-0 order-store"> {{ $customer->owner_email }} </p>
                    </td>
                    <td class="text-center" style="width: 50px">
                        <span>
                            @if($customer->is_subscribed)
                                <img alt="" src="{{asset('admin_assets/images/checkt.png')}}"/>
                            @else
                                <img alt="" src="{{asset('admin_assets/images/close-black.png')}}"/>
                            @endif
                        </span>
                    </td>
                    <td>
                        <p class="mb-0 order-total">
                            {{$customer->name ?? ''}}
                        </p>
                    </td>
                    <td>
                        <p class="mb-0 order-total">$0</p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @php $paginator = $allCustomers->toArray() @endphp
    <div class="d-flex justify-content-between">
        <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
        {!! $allCustomers->appends(request()->getQueryString())->links() !!}
    </div>
</div>
