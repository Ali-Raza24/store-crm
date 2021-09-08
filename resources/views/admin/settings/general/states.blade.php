<div class="tab-pane fade pro-table-seting" id="settNotificat" role="tabpanel" aria-labelledby="settNotificat">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="font-weight-700 dark-one">All Emirates</h4>
        <a class="btn-size btn-rounded btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#addNewEmirates">
            All Emirates
        </a>
    </div>
    <div class="table-responsive scroll-bar-thin">
        <table class="table table-space table-check">
            <thead>
            <tr>
                <th scope="col" class="custom-checkbox pl-0 pr-0">
                    <input type="checkbox" class="custom-control-input" id="customCheck6-1"/>
                    <label class="custom-control-label" for="customCheck6-1">
                    </label>
                </th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0; $i<6; $i++)
                <tr>
                    <td class="custom-checkbox show-selected pl-0 pr-0">
                        <input type="checkbox" class="custom-control-input" id="customCheck6-{{$i+2}}"/>
                        <label class="custom-control-label" for="customCheck6-{{$i+2}}"></label>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="table-order-no ml-3">
                                <strong class="dark-one">
                                    <a href="#">John Smith</a>
                                </strong>
                                <p class="mb-0">Dec 02, 2020</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropStore1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Active
                                            </span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropStore1">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    active
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    Unactive
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-action">
                            <a href="#" class="edit-order mr-3">
                                <img alt="" src="{{asset('admin_assets/images/edit1.png')}}"/>
                            </a>
                            <a href="#" class="print-order">
                                <img alt="" src="{{asset('admin_assets/images/delete.png')}}"/>
                            </a>
                        </div>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-6"><p class="dark-one m-3">Showing 5 of 30 records</p></div>
        <div class="col-md-6">
            @include('extras.pagination')
        </div>
    </div>
</div>
