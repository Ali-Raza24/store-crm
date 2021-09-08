@extends('layouts.business.setting-layout')

@section('title','Business Dashboard')

@section('header_heading','Setting')

{{--@section('header_subheading','54,5682 Orders Found')--}}

@section('content')
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                <nav class="tabs-head mobile-hide" id="allOrders">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="Users-tab" data-toggle="tab"
                           href="#Users" role="tab" aria-controls="Users" aria-selected="true">
                            Users
                        </a>
                        <a class="nav-item nav-link" id="roleList-tab" data-toggle="tab"
                           href="#roleList" role="tab" aria-controls="roleList"
                           aria-selected="false">
                            Role List
                        </a>
                        <a class="nav-item nav-link" id="addRole-tab" data-toggle="tab"
                           href="#addRole" role="tab" aria-controls="addRole"
                           aria-selected="false">
                            Add Role
                        </a>
                    </div>
                </nav>
                <div class="dropdown tabs-dropdown desktop-hide">
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Users
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropTab">
                        <a class="nav-item nav-link active" href="javascript:void(0)"> Users </a>
                        <a class="nav-item nav-link" href="javascript:void(0)"> Role List </a>
                        <a class="nav-item nav-link" href="javascript:void(0)"> Add Role </a>
                    </div>
                </div>
                <hr class="m-0">
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade show active" id="Users" role="tabpanel"
                         aria-labelledby="Users">
                        <div class="pro-table-seting">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="font-weight-700 dark-one"> All Users </h4>
                                <a class="btn-size btn-rounded btn-primary" href="javascript:void(0)"
                                   data-toggle="modal" data-target="#addNewUser"> Add New </a>
                            </div>
                            <div class="table-responsive scroll-bar-thin">
                                <table class="table table-space table-check">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">
                                                <span class="ml-4">All</span>
                                            </label>
                                        </th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="custom-checkbox show-selected">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2"></label>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="pro-thumb">
                                                    <img alt="" src="{{asset('business_assets/images/userG.png')}}">
                                                </div>
                                                <div class="table-order-no ml-3">
                                                    <strong class="dark-one"><a href="#">John Smith</a></strong>
                                                    <p class="mb-0">johnsmith@gmail.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0 order-name">Admin</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 order-name">Store 1</p>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                                <span class="dropdown-toggle" id="dropStore1"
                                                                      role="button" data-toggle="dropdown"
                                                                      aria-haspopup="true" aria-expanded="false">
                                                                    Active
                                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="dropStore1">
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
                                                <a href="../orders/edit.blade.php" class="edit-order mr-3">
                                                    <img alt="" src="{{asset('business_assets/images/edit1.png')}}">
                                                </a>
                                                <a href="../orders/invoice.blade.php" class="print-order">
                                                    <img alt="" src="{{asset('business_assets/images/delete.png')}}">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="custom-checkbox show-selected">
                                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                                            <label class="custom-control-label" for="customCheck3"></label>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="pro-thumb">
                                                    <img alt="" src="{{asset('business_assets/images/userG.png')}}">
                                                </div>
                                                <div class="table-order-no ml-3">
                                                    <strong class="dark-one"><a href="#">John Smith</a></strong>
                                                    <p class="mb-0">johnsmith@gmail.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0 order-name">John Smith</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 order-name">Store 1</p>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                                <span class="dropdown-toggle" id="dropStore1"
                                                                      role="button" data-toggle="dropdown"
                                                                      aria-haspopup="true" aria-expanded="false">
                                                                    Active
                                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="dropStore1">
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
                                                <a href="../orders/edit.blade.php" class="edit-order mr-3">
                                                    <img alt="" src="{{asset('business_assets/images/edit1.png')}}">
                                                </a>
                                                <a href="../orders/invoice.blade.php" class="print-order">
                                                    <img alt="" src="{{asset('business_assets/images/delete.png')}}">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="custom-checkbox show-selected">
                                            <input type="checkbox" class="custom-control-input" id="customCheck4">
                                            <label class="custom-control-label" for="customCheck4"></label>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="pro-thumb">
                                                    <img alt="" src="{{asset('business_assets/images/userG.png')}}">
                                                </div>
                                                <div class="table-order-no ml-3">
                                                    <strong class="dark-one"><a href="#">John Smith</a></strong>
                                                    <p class="mb-0">johnsmith@gmail.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0 order-name">John Smith</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 order-name">Store 1</p>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                                <span class="dropdown-toggle" id="dropStore1"
                                                                      role="button" data-toggle="dropdown"
                                                                      aria-haspopup="true" aria-expanded="false">
                                                                    Active
                                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="dropStore1">
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
                                                <a href="../orders/edit.blade.php" class="edit-order mr-3">
                                                    <img alt="" src="{{asset('business_assets/images/edit1.png')}}">
                                                </a>
                                                <a href="../orders/invoice.blade.php" class="print-order">
                                                    <img alt="" src="{{asset('business_assets/images/delete.png')}}">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="custom-checkbox show-selected">
                                            <input type="checkbox" class="custom-control-input" id="customCheck5">
                                            <label class="custom-control-label" for="customCheck5"></label>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="pro-thumb">
                                                    <img alt="" src="{{asset('business_assets/images/userG.png')}}">
                                                </div>
                                                <div class="table-order-no ml-3">
                                                    <strong class="dark-one"><a href="#">John Smith</a></strong>
                                                    <p class="mb-0">johnsmith@gmail.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0 order-name">John Smith</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 order-name">Store 1</p>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                                <span class="dropdown-toggle" id="dropStore1"
                                                                      role="button" data-toggle="dropdown"
                                                                      aria-haspopup="true" aria-expanded="false">
                                                                    Active
                                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="dropStore1">
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
                                                <a href="../orders/edit.blade.php" class="edit-order mr-3">
                                                    <img alt="" src="{{asset('business_assets/images/edit1.png')}}">
                                                </a>
                                                <a href="../orders/invoice.blade.php" class="print-order">
                                                    <img alt="" src="{{asset('business_assets/images/delete.png')}}">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="dark-one m-3">Showing 5 of 30 records</p>
                                </div>
                                <div class="col-md-6">
                                    <ul class="pagination mt-3 justify-content-end">
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0)" tabindex="-1">
                                                <img alt="" src="{{asset('business_assets/images/arrow-l.png')}}">
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link active"
                                                                 href="javascript:void(0)">1</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">4</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">...</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0)">
                                                <img alt="" src="{{asset('business_assets/images/arrow-r.png')}}">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="roleList" role="tabpanel"
                         aria-labelledby="roleList">
                        <div class="pro-table-seting">
                            <h4 class="font-weight-700 dark-one"> All Roles </h4>
                            <div class="table-responsive wide-table radius-10 scroll-bar-thin mt-3">
                                <table class="table table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <h6 class="dark-one font-weight-700">Admin Roles</h6>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="wide-left">
                                                    <p class="mb-1 order-name">Role Number 1 </p>
                                                    <p class="mb-1 order-name"> Role Number 2 </p>
                                                    <p class="mb-1 order-name"> Role Number 3 </p>
                                                    <p class="mb-1 order-name"> Role Number 4 </p>
                                                    <p class="mb-1 order-name"> Role Number 5 </p>
                                                    <p class="mb-0 order-name"> Role Number 6 </p>
                                                </div>
                                                <div class="wide-right">
                                                    <h4>
                                                        <a class="table-link primary-text font-weight-600"
                                                           href="javascript:void(0)">
                                                            Edit
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6 class="dark-one font-weight-700">Manager</h6>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="wide-left">
                                                    <p class="mb-1 order-name">Role Number 1 </p>
                                                    <p class="mb-1 order-name"> Role Number 2 </p>
                                                    <p class="mb-0 order-name"> Role Number 3 </p>
                                                </div>
                                                <div class="wide-right">
                                                    <h4>
                                                        <a class="table-link primary-text font-weight-600"
                                                           href="javascript:void(0)">
                                                            Edit
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6 class="dark-one font-weight-700">Admin Roles</h6>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="wide-left">
                                                    <p class="mb-1 order-name">Role Number 1 </p>
                                                    <p class="mb-1 order-name"> Role Number 2 </p>
                                                    <p class="mb-1 order-name"> Role Number 3 </p>
                                                    <p class="mb-1 order-name"> Role Number 4 </p>
                                                    <p class="mb-1 order-name"> Role Number 5 </p>
                                                    <p class="mb-0 order-name"> Role Number 6 </p>
                                                </div>
                                                <div class="wide-right">
                                                    <h4>
                                                        <a class="table-link primary-text font-weight-600"
                                                           href="javascript:void(0)">
                                                            Edit
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6 class="dark-one font-weight-700">Admin Roles</h6>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="wide-left">
                                                    <p class="mb-1 order-name">Role Number 1 </p>
                                                    <p class="mb-1 order-name"> Role Number 2 </p>
                                                    <p class="mb-1 order-name"> Role Number 3 </p>
                                                    <p class="mb-1 order-name"> Role Number 4 </p>
                                                    <p class="mb-1 order-name"> Role Number 5 </p>
                                                    <p class="mb-0 order-name"> Role Number 6 </p>
                                                </div>
                                                <div class="wide-right">
                                                    <h4>
                                                        <a class="table-link primary-text font-weight-600"
                                                           href="javascript:void(0)">
                                                            Edit
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="dark-one m-3">Showing 5 of 30 records</p>
                                </div>
                                <div class="col-md-6">
                                    <ul class="pagination mt-3 justify-content-end">
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0)" tabindex="-1">
                                                <img alt="" src="{{asset('business_assets/images/arrow-l.png')}}">
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link active"
                                                                 href="javascript:void(0)">1</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">4</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">...</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0)">
                                                <img alt="" src="{{asset('business_assets/images/arrow-r.png')}}">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="addRole" role="tabpanel"
                         aria-labelledby="addRole">
                        <form>
                            <h4 class="font-weight-700 dark-one mb-4">Manage Role</h4>
                            <div class="row">
                                <div class="col-sm-6 form-group mb-4">
                                    <label class="font-weight-600 dark-one mb-2"> Add Role</label>
                                    <input type="text" placeholder="" class="form-control order-edit-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <h4 class="font-weight-700 dark-one mb-4">Orders Roles</h4>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role1">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role1">
                                                <span class="pl-2">Role Number 1</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role2">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role2">
                                                <span class="pl-2">Role Number 2</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role3">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role3">
                                                <span class="pl-2">Role Number 3</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role4">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role4">
                                                <span class="pl-2">Role Number 4</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role5">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role5">
                                                <span class="pl-2">Role Number 5</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role6">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role6">
                                                <span class="pl-2">Role Number 6</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <h4 class="font-weight-700 dark-one mb-4">Orders Roles</h4>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role11">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role11">
                                                <span class="pl-2">Role Number 1</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role12">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role12">
                                                <span class="pl-2">Role Number 2</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role13">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role13">
                                                <span class="pl-2">Role Number 3</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role14">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role14">
                                                <span class="pl-2">Role Number 4</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role15">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role15">
                                                <span class="pl-2">Role Number 5</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role16">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role16">
                                                <span class="pl-2">Role Number 6</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <h4 class="font-weight-700 dark-one mb-4">Orders Roles</h4>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role21">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role21">
                                                <span class="pl-2">Role Number 1</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role22">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role22">
                                                <span class="pl-2">Role Number 2</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role23">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role23">
                                                <span class="pl-2">Role Number 3</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role24">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role24">
                                                <span class="pl-2">Role Number 4</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role25">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role25">
                                                <span class="pl-2">Role Number 5</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role26">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role26">
                                                <span class="pl-2">Role Number 6</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <h4 class="font-weight-700 dark-one mb-4">Orders Roles</h4>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role31">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role31">
                                                <span class="pl-2">Role Number 1</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role32">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role32">
                                                <span class="pl-2">Role Number 2</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role33">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role33">
                                                <span class="pl-2">Role Number 3</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role34">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role34">
                                                <span class="pl-2">Role Number 4</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role35">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role35">
                                                <span class="pl-2">Role Number 5</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role36">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role36">
                                                <span class="pl-2">Role Number 6</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">

                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role441">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role441">
                                                <h4 class="font-weight-700 dark-one mb-3 pl-2">Sub Orders Roles</h4>
                                            </label>
                                        </div>
                                        <div class="pl-4">
                                            <div class="custom-checkbox lgcheck-text mb-3">
                                                <input type="checkbox" class="custom-control-input" id="role41">
                                                <label class="custom-control-label w-100 h-100 pl-4"
                                                       for="role41">
                                                    <span class="pl-2">Role Number 1</span>
                                                </label>
                                            </div>
                                            <div class="custom-checkbox lgcheck-text mb-3">
                                                <input type="checkbox" class="custom-control-input" id="role42">
                                                <label class="custom-control-label w-100 h-100 pl-4"
                                                       for="role42">
                                                    <span class="pl-2">Role Number 2</span>
                                                </label>
                                            </div>
                                            <div class="custom-checkbox lgcheck-text mb-3">
                                                <input type="checkbox" class="custom-control-input" id="role43">
                                                <label class="custom-control-label w-100 h-100 pl-4"
                                                       for="role43">
                                                    <span class="pl-2">Role Number 3</span>
                                                </label>
                                            </div>
                                            <div class="custom-checkbox lgcheck-text mb-3">
                                                <input type="checkbox" class="custom-control-input" id="role44">
                                                <label class="custom-control-label w-100 h-100 pl-4"
                                                       for="role44">
                                                    <span class="pl-2">Role Number 4</span>
                                                </label>
                                            </div>
                                            <div class="custom-checkbox lgcheck-text mb-3">
                                                <input type="checkbox" class="custom-control-input" id="role45">
                                                <label class="custom-control-label w-100 h-100 pl-4"
                                                       for="role45">
                                                    <span class="pl-2">Role Number 5</span>
                                                </label>
                                            </div>
                                            <div class="custom-checkbox lgcheck-text mb-3">
                                                <input type="checkbox" class="custom-control-input" id="role46">
                                                <label class="custom-control-label w-100 h-100 pl-4"
                                                       for="role46">
                                                    <span class="pl-2">Role Number 6</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <h4 class="font-weight-700 dark-one mb-4">Orders Roles</h4>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role51">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role51">
                                                <span class="pl-2">Role Number 1</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role52">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role52">
                                                <span class="pl-2">Role Number 2</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role53">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role53">
                                                <span class="pl-2">Role Number 3</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role54">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role54">
                                                <span class="pl-2">Role Number 4</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role55">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role55">
                                                <span class="pl-2">Role Number 5</span>
                                            </label>
                                        </div>
                                        <div class="custom-checkbox lgcheck-text mb-3">
                                            <input type="checkbox" class="custom-control-input" id="role56">
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="role56">
                                                <span class="pl-2">Role Number 6</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="form-group mb-0 text-right">
                            <hr class="mt-5 mb-3">
                            <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary mr-3">
                                Update
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="selected-item-panel">
        <div class="selected-item">
            <ul class="selected-list">
                <li>
                    <div class="item-show">
                        <span><img src="{{asset('business_assets/images/close-wgite.png')}}" alt="image"></span>
                        <p class="mobile-hide">2 Items Selected</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn">
                        <span>Delete  User</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn">
                        <span>Duplicate User</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('extras')
    <div class="modal fade customer-modal" id="addNewUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="font-weight-700 dark-one mb-2">Add New User</h3>
                    <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                        <div class="form-group">
                            <span class="add-brand">
                                <img alt="" src="{{asset('business_assets/images/customer-placeholder.png')}}">
                            </span>
                        </div>
                        <div class="form-group text-left">
                            <label class="font-weight-600 dark-one mb-2">User Name</label>
                            <input type="text" class="form-control sm-radius-control white-border-control">
                        </div>
                        <div class="form-group text-left">
                            <label class="font-weight-600 dark-one mb-2">Email</label>
                            <input type="email" class="form-control sm-radius-control white-border-control">
                        </div>
                        <div class="form-group text-left">
                            <label class="font-weight-600 dark-one mb-2">Password</label>
                            <input type="password" class="form-control sm-radius-control white-border-control">
                        </div>
                        <div class="form-group text-left">
                            <label class="font-weight-600 dark-one mb-2">Location</label>
                            <div class="form-icon">
                                <select class="form-control sm-radius-control white-border-control">
                                    <option> -- Select --</option>
                                    <option> Location</option>
                                </select>
                                <span>
                                    <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                </span>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <label class="font-weight-600 dark-one mb-2">Role</label>
                            <div class="form-icon">
                                <select class="form-control sm-radius-control white-border-control">
                                    <option> -- Select --</option>
                                    <option> Role</option>
                                </select>
                                <span>
                                    <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                </span>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1 mb-1"
                       data-dismiss="modal">
                        Cancel
                    </a>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary ml-1 mr-1"> Add </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')
@endsection
