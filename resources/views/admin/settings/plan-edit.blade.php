@extends('layouts.admin.app')

@section('title', 'Plans')
@section('heading', 'Plans')

@section('css')
    <style>
        .plans_options_list th{
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
    </style>
@endsection

@section('content')
    <div class='row' xmlns='http://www.w3.org/1999/html'>
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
                <nav class="tabs-head mobile-hide" id="allOrders">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="Free-plan-tab" data-toggle="tab" href="#Free-plan"
                           role="tab" aria-controls="Free-plan" aria-selected="true">
                            Edit
                        </a>
                    </div>
                </nav>
                <div class="dropdown tabs-dropdown desktop-hide">
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Free
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropTab">
                        <a class="nav-item nav-link" href="javascript:void(0)">Basic</a>
                        <a class="nav-item nav-link" href="javascript:void(0)">Advanced</a>
                    </div>
                </div>
                <hr class="m-0" />
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade pro-table-seting show active" id="Free-plan" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="font-weight-700 dark-one mb-4">
                                Edit Plan
                            </h4>
                        </div>
                        <form method='post' action='{{route('admin-plans-store')}}' id='plan-form'>
                            <form action="{{ route('admin-plans-update', [!empty($plan) ? $plan->id : ""]) }}"
                                  method="post" id='plan-form'>
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="row">
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Title</label>
                                        <input name='plan_title'
                                               value="{{!empty(old('plan_title')) ? old('plan_title') : $plan->title}}"
                                               type="text" placeholder=""
                                               class="form-control order-edit-control @error('plan_title') danger-border @enderror" />
                                        @error('plan_title')
                                        <div class="input-info danger-bg">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Monthly Price ($)</label>
                                        <input name='plan_monthly_price'
                                               value="{{!empty(old('plan_monthly_price')) ? old('plan_monthly_price') : $plan->monthly_price}}"
                                               type="text" placeholder=""
                                               class="form-control order-edit-control @error('plan_monthly_price') danger-border @enderror" />
                                        @error('plan_monthly_price')
                                        <div class="input-info danger-bg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Yearly Price ($)</label>
                                        <input name='plan_yearly_price'
                                               value="{{!empty(old('plan_yearly_price')) ? old('plan_yearly_price') : $plan->yearly_price}}"
                                               type="text" placeholder=""
                                               class="form-control order-edit-control @error('plan_yearly_price') danger-border @enderror" />
                                        @error('plan_yearly_price')
                                        <div class="input-info danger-bg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Description</label>
                                        <textarea name='plan_desc'
                                                  class="form-control order-edit-control @error('plan_desc') danger-border @enderror">{{!empty(old('plan_desc')) ? old('plan_desc') : $plan->description}}</textarea>
                                        @error('plan_desc')
                                        <div class="input-info danger-bg">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Plan Options</label>

                                        <div class="form-icon">
                                            <select name="plan_option" id='plan_option'
                                                    class="order-edit-control form-control @error('plan_options') danger-border @enderror">
                                                <option value="">--Select--</option>
                                                @foreach(\App\Helpers\CommonHelper::planOptions() as $key => $planopt )
                                                    <option value="{{ $key }}"
                                                            data-type="{{ $planopt['type'] }}">{{ $planopt['title'] }}</option>
                                                @endforeach


                                            </select>
                                            <span><img src="{{asset('business_assets/images/angledown.png')}}"
                                                       alt="image"></span>
                                            @error('plan_options')
                                            <div class="input-info danger-bg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Select Option Value</label>
                                                    <div id="plan_option_html"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Option Text</label>
                                                            <div id="plan_option_text"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <a href="javascript:void(0)" onclick="addMoreOptions(++id);"
                                           class="btn-underline btn-size btn-rounded primary-text my-4 primary-border border">+
                                            Add</a>
                                    </div>
                                    <div id="planOptionError"></div>
                                    <div class="col-12">
                                        <div class="row mt-5">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <div class="table-responsive scroll-bar-thin location-group sm-radius-control"
                                                         style="max-height: 750px">
                                                        <table class="table m-0 plans_options_list">
                                                            <thead>
                                                            <tr>
                                                                <th>Option</th>
                                                                <th>Value</th>
                                                                <th>Text</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="plans_options_list">
                                                            @foreach($plan->planoption as $planopt)
                                                                <tr id="deleteOption{{$planopt->id}}" data-option="{{$planopt->option}}">
                                                                    <td>
                                                                        {{$planopt->option}}
                                                                        <input type="hidden" name="option[{{$loop->iteration+50}}][option]" value="{{$planopt->option}}"/>
                                                                    </td>
                                                                    <td>
                                                                        {{$planopt->values}}
                                                                        <input type="hidden" name="option[{{$loop->iteration+50}}][value]" value="{{$planopt->values}}"/>
                                                                    </td>
                                                                    <td>
                                                                        {{$planopt->option_text}}
                                                                        <input type="hidden" name="option[{{$loop->iteration+50}}][text]" value="{{$planopt->option_text}}"/>
                                                                    </td>
                                                                    <td>
                                                                        <div class="table-action">
                                                                            <a href="javascript:void(0);" onclick="deleteOption('#deleteOption{{$planopt->id}}')" class="edit-order"><img src="{{asset('business_assets/images/delete.png')}}" alt=""></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="role_id" value="{{$plan->role_id}}">
                                    @php
                                        $outercount = 1;$innercount = 1;
                                    @endphp
                                    <div class="col-12">
                                        <hr class="mt-4">
                                    </div>
                                    <div class="col-12 my-2">
                                        <h3 class="font-weight-700 dark-one">Please choose the Plan access rights.</h3>
                                    </div>
                                    <div class="col-12">
                                        <hr class="mb-2">
                                    </div>
                                    @foreach($groups as $group)
                                        @php
                                            $outercount++;
                                            $roleTotal = 0;
                                        @endphp
                                        @php
                                            $groupTotal = \App\Models\PermissionModel::whereGroup($group->group)->whereIsBusiness(1)->count('id');
                                            if(!empty($plan->role)){
                                                $roleTotal = optional($plan->role)->permissions()->whereGroup($group->group)->count('id');
                                            }
                                        @endphp
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <div class="custom-checkbox lgcheck-text mb-3">
                                                    <input type="checkbox" class="custom-control-input check-role-group" data-group="{{$group->group}}" id="{{$group->group}}"
                                                           @if($groupTotal == $roleTotal)
                                                           checked
                                                            @endif
                                                    />
                                                    <label class="custom-control-label w-100 h-100 pl-4" for="{{$group->group}}">
                                                        <span class="pl-2 font-weight-700 dark-one text-capitalize">{{$group->group}}</span>
                                                    </label>
                                                </div>
                                                @foreach($permissions as $key => $permission)
                                                    @php
                                                        $innercount++;
                                                    @endphp
                                                    @if($permission->group==$group->group)
                                                        <div class="custom-checkbox lgcheck-text mb-3 ml-5">
                                                            <input type="checkbox" name="permission[]"
                                                                   value="{{ $permission['id'] }}"
                                                                   class="custom-control-input"
                                                                   id="role{{ $permission['id'].$outercount.$innercount }}"
                                                                   data-group-item="{{$group->group}}"
                                                                   data-role-items="permission"
                                                                   @if(!empty(old('permission')) && in_array($permission['id'], old('permission')))
                                                                   checked
                                                                   @endif

                                                                   @if(empty(old('permission')) && !empty($existingPermissions) && in_array($permission['id'], $existingPermissions)) checked @endif
                                                            />
                                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                                   for="role{{ $permission['id'].$outercount.$innercount}}">
                                                                <span class="pl-2">{{ $permission['description']  }}</span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group mb-0 text-right">
                                    <hr class="mt-5 mb-3" />
                                    <input type='hidden' name='plan_id' value='{{$plan->id}}'>
                                    <button class="btn-size btn-rounded btn-primary mr-3">Update</button>
                                    <a href="{{route('admin-plans-setting')}}" class="btn-size btn-dark btn-rounded mr-3">Cancel</a>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>


        @endsection

        @section('scripts')
            @include('layouts.jquery')
            <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
        @endsection
        @section('custom_script')
            <script>
              let $allOptions = [];
              let $existingOptions = @json($plan->planoption)

              function addMoreOptions (id) {
                let $planOption = $('[name="plan_option"]').val();
                let $optionValue = [];
                let $optionValueText = [];
                let $errorContainter = $('#planOptionError');

                $errorContainter.find('.alert').remove()

                if ($planOption === '' || $planOption === undefined){
                  $errorContainter.append("<div class='alert bg-danger text-white'>Please select option first</div>")
                  return;
                }
                if ($('[data-item="option"]').attr('type') === 'radio' || $('[data-item="option"]').attr('type') === 'checkbox') {
                  if ($('[data-item="option"]:checked').val() === '' || $('[data-item="option"]:checked').val() === undefined) {
                    $errorContainter.append("<div class='alert bg-danger text-white'>Please select option value first</div>")
                    return;
                  }
                }else{
                  if ($('[data-item="option"]').val() === '' || $('[data-item="option"]').val() === undefined) {
                    $errorContainter.append("<div class='alert bg-danger text-white'>Please enter option value first</div>")
                    return;
                  }
                }

                if ($('[data-item="option"]').attr('type') === 'radio' || $('[data-item="option"]').attr('type') === 'checkbox') {
                  $('[data-item="option"]:checked').each(function(e) {
                    $optionValue.push($(this).val());
                    $optionValueText.push($(this).data('optiontext'));
                  });
                } else {
                  $('[data-item="option"]').each(function(e) {
                    $optionValue.push($(this).val());
                    $optionValueText.push($(this).val());
                  });
                }

                let $existing = $existingOptions.some(alloption => {
                  return alloption.option === $planOption;
                })

                if ($existing === true){
                  $errorContainter.append("<div class='alert bg-danger text-white'>Option already added</div>")
                  return;
                }

                let $optionText = $('[name="option_text[]"]').val();
                $allOptions.push({
                  planOption: $planOption,
                  planOptionValue: $optionValueText,
                  planOptionOriginalValue: $optionValue,
                  planOptionText: $optionText
                });

                $('[name="plan_option"]').val('');
                $('#plan_option_html').html('');
                $('#plan_option_text').html('');

                let $tds = Object.keys($allOptions).map((key) => {

                  $('[data-type="new"]').remove();

                  return '<tr id="deleteOption'+key+'" data-type="new">' +
                    '<td>' + $allOptions[key].planOption + '<input type="hidden" name="option[' + key + '][option]" value="' + $allOptions[key].planOption + '"/> </td>' +
                    '<td>' + $allOptions[key].planOptionValue + '<input type="hidden" name="option[' + key + '][value]" value="' + $allOptions[key].planOptionOriginalValue + '"/></td>' +
                    '<td>' + $allOptions[key].planOptionText + '<input type="hidden" name="option[' + key + '][text]" value="' + $allOptions[key].planOptionText + '"/></td>' +
                    '<td>' +
                    '<div class="table-action">' +
                    '<a href="javascript:void(0);" onclick="deleteOption(\'#deleteOption'+key+'\', '+key+')" class="edit-order"><img src="{{asset('business_assets/images/delete.png')}}" alt=""></a>' +
                    '</div>' +
                    '</td>'+
                    '</tr>';
                });

                $('#plans_options_list').append($tds);

              }

              $('#plan_option').on('change', function() {
                let $errorContainter = $('#planOptionError');

                $errorContainter.find('.alert').remove()

                $('#plan_option_html').html('');
                $('#plan_option_text').html('');

                let $optionType = $('#plan_option :selected').data('type');
                let $optionValue = $(this).val();
                axios.get("{{route('plan-option-value')}}/" + $optionValue).then(response => {
                  $('#plan_option_html').html(response.data.data.html);
                });
              });

              $(document).on('change', '[data-item="option"]', function() {
                if ($('[data-item="option"]').attr('type') === 'radio' || $('[data-item="option"]').attr('type') === 'checkbox') {
                  Options(this);
                }
              });
              $(document).on('keyup', '[data-item="option"]', function() {
                Options(this);
              });

              function Options ($this) {
                let $allTextString = '';

                if ($('[data-item="option"]').attr('type') === 'radio' || $('[data-item="option"]').attr('type') === 'checkbox') {
                  $('[data-item="option"]:checked').each(function(e) {
                    let $optionValue = $(this).val();

                    let $selectedLength = $('[data-item="option"]:checked').length;

                    axios.get("{{route('plan-option-text')}}/" + $optionValue).then(response => {
                      let $text = response.data.data.text;

                      if ($selectedLength > 1) {
                        if ($allTextString !== '') {
                          $allTextString += ' & ';
                        }
                        $allTextString += $text;
                        $('#plan_option_text').html('<input class=\'form-control order-edit-control\' name=\'option_text[]\' value=\'' + $allTextString + '\'>');
                      } else {
                        $allTextString = $text;
                        $('#plan_option_text').html('<input class=\'form-control order-edit-control\' name=\'option_text[]\' value=\'' + $allTextString + '\'>');
                      }
                    });
                  });
                } else {
                  let $optionValue = $($this).data('option');
                  axios.get("{{route('plan-option-text')}}/" + $optionValue).then(response => {
                    let $text = response.data.data.text;

                    $allTextString += $($this).val() + ' ';
                    $allTextString += $text;

                    $('#plan_option_text').html('<input class=\'form-control order-edit-control\' name=\'option_text[]\' value=\'' + $allTextString + '\'>');
                  });
                }
              }

              function deleteOption(id, index = null){
                $existingOptions = $existingOptions.filter(existing => {
                  if (existing.option !== $(id).data('option')){
                    return existing;
                  }
                })
                $(id).remove()
                if (index){
                  $allOptions.splice(index,1)
                }
              }
            </script>
            <script>
              $('.check-role-group').on('change', function() {
                let $dataGroup = $(this).data('group');
                if ($(this).is(':checked') === true){
                  $('[data-group-item="'+$dataGroup+'"]').attr('checked', true).prop('checked', true)
                }else{
                  $('[data-group-item="'+$dataGroup+'"]').attr('checked', false).prop('checked', false)
                }
              })

              $('[data-role-items="permission"]').on('click', function() {

                let $parent = $(this).parent().parent().children().find('input.check-role-group');

                let $group = $parent.data('group');
                let $groupItems = $('[data-group-item="'+$group+'"]');
                if( $groupItems.length === $('[data-group-item="'+$group+'"]:checked').length ){
                  $parent.attr('checked', true).prop('checked', true);
                }else{
                  $parent.attr('checked', false).prop('checked', false);
                }
              })
            </script>

            <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! \Proengsoft\JsValidation\Facades\JsValidatorFacade::formRequest('App\Http\Requests\PlanRequests', '#plan-form') !!}
@endsection
