<div class="sf-order">
    <div class="table-responsive scroll-bar-thin">
        <table class="table table-space table-check">
            <thead>
            <tr>
                <th scope="col" class="custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkAll" />
                    <label class="custom-control-label" for="checkAll"></label>
                </th>
                <th scope="col">Location Name</th>
                <th scope="col">Geo Location</th>
                <th scope="col">City</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($areas as $area)
                <?php
                    $status = \App\Helpers\CommonHelper::getStatus($area->is_active);
                ?>
                <tr>
                    <td class="custom-checkbox show-selected">
                        <input type="checkbox" value="{{$area->id}}" name="bulk_ids[]" class="custom-control-input list-check" id="customCheck{{$loop->iteration+2}}" />
                        <label class="custom-control-label" for="customCheck{{$loop->iteration+2}}"></label>
                    </td>
                    <td>
                        <div class="table-order-no">
                            <strong class="dark-one">
                                <a href="#">{{$area->title}}</a>
                            </strong>
                        </div>
                    </td>
                    <td>
                        <p class="mb-0 order-name">
                            {!! $area->address !!}
                        </p>
                    </td>
                    <td>
                        <p class="mb-0 order-name">
                            {!! $area->state->name !!}
                        </p>
                    </td>
                    <td>
                        <div class="dropdown">
                                    <span class="dropdown-toggle" id="dropTable1" role="button" data-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false">
                                        {!! $status !!}
                                    </span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropTable1">
                                @if($status == 'InActive')
                                    <a class="dropdown-item"
                                       href="javascript:void(0)"
                                       data-toggle="modal"
                                       data-modal="modal"
                                       data-target="#confirmModal"
                                       data-title="Activate Area"
                                       data-url="{{route('admin-area-status')}}"
                                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                                       data-type="put"
                                       data-id="{{$area->id}}"
                                    >
                                        Active
                                    </a>
                                @else
                                    <a class="dropdown-item"
                                       href="javascript:void(0)"
                                       data-url="{{route('admin-area-status')}}"
                                       data-status="{{\App\Constants\IStatus::DISABLE}}"
                                       data-type="put"
                                       data-toggle="modal"
                                       data-modal="modal"
                                       data-target="#confirmModal"
                                       data-title="InActivate Area"
                                       data-used="{{$area->business->count()}}"
                                       data-id="{{$area->id}}"
                                    >
                                        Inactive
                                    </a>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-action">
                            <a href="{{route('admin-area-edit',$area->id)}}" class="edit-order edit-area-btn" title="Edit area">
                                <img alt="" src="{{asset('admin_assets/images/edit.png')}}" />
                            </a>
                            <a href="javascript:void(0);" class="print-order" title="Delete area"
                               data-toggle="modal"
                               data-id="{{$area->id}}"
                               data-url="{{route('admin-area-delete')}}"
                               data-modal="modal"
                               data-type="delete"
                               data-target="#confirmModal"
                               data-used="{{$area->business->count()}}"
                               data-title="Delete Area">
                                <img alt="" src="{{asset('admin_assets/images/delete-gray.png')}}" />
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @php $paginator = $areas->toArray() @endphp
    <div class="d-flex justify-content-between">
        <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
        {!! $areas->appends(request()->getQueryString())->links() !!}
    </div>

</div>
