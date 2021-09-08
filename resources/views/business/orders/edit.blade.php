@extends('layouts.business.app')

@section('title','Edit Order')

@section('content')
    @php
        /**
         * @var $order \App\Models\Order
         * */
    @endphp
    @include('business.orders.partials.header')
    <form action='{{route('orders-update',$order->id)}}' method='post' enctype='multipart/form-data'
          id='order-edit-form'>
        @csrf
        {!! Form::hidden('order_id',$order->id) !!}
        <div class="row">
            <div class="col-xl-8 col-md-8 col-sm-12">
                <div class="sf-order">
                    <div class="table-responsive scroll-bar-thin">
                        <table class="table table-space first-tran v-middle order-table">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col" width="300px">Product</th>
                                <th scope="col">Category</th>
                                <th scope="col" style="width:70px">QTY</th>
                                <th scope="col">Discount </th>
                                <th scope="col">Price</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody id="user_Prods">
                            <?php
                            /**
                             * @var $order \App\Models\Order
                             */
                            $subTotal = 0; $orderTotal = 0;?>
                            @if(sizeof($order->details) > 0)
                                @foreach($order->details as $key => $detail)
                                    <tr>
                                        <td>
                                            <div class="pro-img">
                                                @if($detail['product']['url'])
                                                    <img src="{{ $orderProduct['product']['url'] }}" alt="image">
                                                @else
                                                    <img src="{{asset('img/camera_icon.png')}}" alt="image">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {!! Form::select('cart['.$loop->iteration.'][product_id]', $allProducts->pluck('title','id'), $detail->product_id, ['class' => 'order-edit-control form-control select2']) !!}
                                            @error('product_id')
                                                <div class="input-info danger-bg">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            {!! Form::select('cart['.$loop->iteration.'][category_id]', $detail->product->categories()->pluck('title', 'category_id'), $detail->category_id, ['class' => 'categories order-edit-control form-control']) !!}
                                            @error('category_id')
                                                <div class="input-info danger-bg">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td style="width: 70px; padding: 0">
                                            {!! Form::number('cart['.$loop->iteration.'][qty]', $detail->qty, ['class' => 'qty form-control order-edit-control '.($errors->has('qty') ? 'border-danger' : '')]) !!}
                                            @error('qty')
                                                <div class="input-info danger-bg">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            {!! Form::number('cart['.$loop->iteration.'][discount_value]', $detail->discount_value, ['class' => 'discount form-control order-edit-control '.($errors->has('discount_value') ? 'border-danger' : '')]) !!}
                                            @error('discount_value')
                                                <div class="input-info danger-bg">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <?php
                                                $productTotal = $detail->price * $detail->qty;
                                                $subTotal += $productTotal;
                                            ?>
                                            <p class="mb-0 product_total_text">{{$productTotal}}</p>
                                            <input name="{{'cart['.$loop->iteration.'][price]'}}" type="hidden" class="price" value="{{$detail->price}}">
                                            <input type="hidden" class="product_total" value="{{format_number($productTotal)}}">
                                        </td>

                                        <td>
                                            <a onclick="deleteProd(this);" href="javascript:void(0)">
                                                <img src="{{asset('business_assets/images/delete.png')}}" alt="image">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4">
                                    <a onclick="addMoreProd();" class="btn-size btn-rounded btn-dark">Add New Item</a>
                                </td>
                                <td>
                                    Total:
                                </td>
                                <td colspan="2">
                                    <?php $orderTotal += $subTotal; ?>
                                    <?php $orderTotal += $order->delivery_charges; ?>
                                    <?php $orderTotal += $order->tip_amount; ?>
                                    <?php $orderTotal -= $order->discount_value; ?>
                                    <?php $orderTotal += $order->tax; ?>
                                    <h4 class="font-weight-700 danger-text text-right">{{currency_format($orderTotal)}}</h4>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-sm-12">
                <div class="right-side">
                    <div class="form-group mb-2">
                        {!! Form::text('customer[name]', optional($order->customer)->name, ['class' => 'order-edit-control form-control '. ($errors->has('customer.name') ? 'danger-border' : '')]) !!}
                        @error('customer.name')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        {!! Form::text('customer[email]', optional($order->customer)->email, ['class' => 'order-edit-control form-control '. ($errors->has('customer.email') ? 'danger-border' : '')]) !!}
                        @error('customer.email]')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        {!! Form::text('customer[phone]', optional($order->customer)->phone, ['class' => 'order-edit-control form-control '. ($errors->has('customer.phone') ? 'danger-border' : '')]) !!}
                        @error('customer.phone')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        {!! Form::textarea('customer[address]', optional($order->customer)->address, ['class' => 'order-edit-control form-control '. ($errors->has('customer.address') ? 'danger-border' : '')]) !!}
                        <input type='hidden' name='customer[id]' value='{{$order->customer_id}}'>
                        <input type='hidden' name='customer_id' value='{{$order->customer_id}}'>
                        @error('customer.address')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <h4 class="font-weight-600 mb-2 mt-4">Customer Note</h4>
                        {!! Form::textarea('customer_notes', $order->customer_notes, ['class' => 'order-edit-control form-control '. ($errors->has('customer_notes') ? 'danger-border' : '')]) !!}
                        @error('customer_notes')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <h4 class="font-weight-600 mb-2 mt-4">Shipping</h4>
                        {!! Form::text('shippingInfo[shipping_address][name]', optional($order->shippingAddress)->name, ['class' => 'order-edit-control form-control '. ($errors->has('shippingInfo.shipping_address.name') ? 'danger-border' : '')]) !!}
                        @error('shippingInfo.shipping_address.name')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        {!! Form::text('shippingInfo[shipping_address][email]', optional($order->shippingAddress)->email, ['class' => 'order-edit-control form-control '. ($errors->has('shippingInfo.shipping_address.email') ? 'danger-border' : '')]) !!}
                        @error('shippingInfo.shipping_address.email')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        {!! Form::text('shippingInfo[shipping_address][phone]', optional($order->shippingAddress)->phone, ['class' => 'order-edit-control form-control '. ($errors->has('shippingInfo.shipping_address.phone') ? 'danger-border' : '')]) !!}
                        @error('shippingInfo.shipping_address.phone')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        {!! Form::textarea('shippingInfo[shipping_address][address]', optional($order->shippingAddress)->address, ['class' => 'order-edit-control form-control '. ($errors->has('shippingInfo.shipping_address.address') ? 'danger-border' : '')]) !!}
                        <input type='hidden' name='shippingInfo[shipping_address][id]' value='{{optional($order->shippingAddress)->id}}'>
                        @error('shippingInfo.shipping_address.address')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <h4 class="font-weight-600 mb-2 mt-4">Billing Address</h4>
                        {!! Form::text('shippingInfo[billing_address][name]', optional($order->billingAddress)->name, ['class' => 'order-edit-control form-control '. ($errors->has('shippingInfo.billing_address.name') ? 'danger-border' : '')]) !!}
                        @error('shippingInfo.billing_address.name')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        {!! Form::text('shippingInfo[billing_address][email]', optional($order->billingAddress)->email, ['class' => 'order-edit-control form-control '. ($errors->has('shippingInfo.billing_address.email') ? 'danger-border' : '')]) !!}
                        @error('shippingInfo.billing_address.email')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        {!! Form::text('shippingInfo[billing_address][phone]', optional($order->billingAddress)->phone, ['class' => 'order-edit-control form-control '. ($errors->has('shippingInfo.billing_address.phone') ? 'danger-border' : '')]) !!}
                        @error('shippingInfo.billing_address.phone')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        {!! Form::textarea('shippingInfo[billing_address][address]', optional($order->billingAddress)->address, ['class' => 'order-edit-control form-control '. ($errors->has('shippingInfo.billing_address.address') ? 'danger-border' : '')]) !!}
                        <input type='hidden' name='shippingInfo[billing_address][id]' value='{{optional($order->billingAddress)->id}}'>
                        @error('shippingInfo.billing_address.address')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type='hidden' name='shippingInfo[same_billing_address]' value='false'>
                </div>
            </div>
        </div>
    </form>
        @endsection
        @section('footer')

            <table class="d-none" id="more_pro">
                <tr class="addnew">
                    <td>
                        <div class="pro-img">
                            <img src="{{asset('img/camera_icon.png')}}" alt="image">
                        </div>
                    </td>
                    <td>
                        {!! Form::select('cart[][product_id]', $allProducts->pluck('title','id'), null, ['class' => 'products order-edit-control form-control']) !!}
                    </td>
                    <td>
                        @php
                            $product = $allProducts[0];
                            $categories = [];
                            if(!empty($product->categories)){
                                $categories = $product->categories()->pluck('title', 'category_id');
                            }
                        @endphp
                        {!! Form::select('cart[][category_id]', $categories, null, ['class' => 'categories order-edit-control form-control']) !!}
                    </td>
                    <td style="width: 70px; padding: 0">
                        <input type="number" name="cart[][qty]" value="1" class="qty form-control order-edit-control">
                    </td>
                    <td>
                        <input type="number" name="cart[][discount_value]" class="discount order-edit-control form-control" >
                    </td>
                    <td>
                        <p class="mb-0 product_total_text text-white">{{$product->retail_price}}</p>
                        <input name="cart[][price]" type="hidden" class="price" value="{{$product->retail_price}}">
                        <input type="hidden" class="product_total" value="{{$product->retail_price * 1}}">
                    </td>
                    <td>
                        <a href="javascript:void(0)"><img onclick="deleteProd(this)" src="{{asset('business_assets/images/delete.png')}}" alt="image"></a>
                    </td>
                </tr>
            </table>
        @endsection
@section('extras')
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="order_id" id="order_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title</span> Order?
                        </h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update</span>
                            this Order?</h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span
                                    data-modal-title="title">Ok</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1"
                           data-dismiss="modal">
                            Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
        @section('scripts')
            @include('layouts.jquery')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                $(function() {
                  $('.qty').on('change', function(){
                    calculateCartItems($(this))
                  });
                })
                function calculateCartItems(element){
                  let $parent = $(element).parent().parent();
                  let $price = $parent.find('.price').val();
                  let $qty = $(element).val();

                  let $total = formatValue($qty * $price);
                  $parent.find('.product_total_text').text($total);
                  $parent.find('.product_total').val($total)

                  let $orderTotal = 0;
                  $('#user_Prods .product_total').each(function() {
                    $orderTotal += parseFloat($(this).val());
                  });

                  $('.order_total').text(formatValue($orderTotal));
                }
            </script>

            <script>
              $('.select2').select2({
                closeOnSelect: false,
                placeholder: '--Multi Select--',
                allowClear: true
              }).on('change.select2', function() {
                getProductCategories($(this))
              });
            </script>
            <script>
              // order payment status change
              function submitOrderForm () {
                $('#order-edit-form').submit();
              }

              var i = 0;

              function addMoreProd () {
                var $proObj = $('#more_pro tbody');
                let $cart = $('#user_Prods');
                let $cartProducts = $cart.find('tr').length;

                $proObj.find('.addnew').addClass('newItem')
                var pro_html = $proObj.html();
                $proObj.find('.addnew').removeClass('newItem')
                $cart.append(pro_html);

                let $newItem = $cart.find('tr');

                let $productId = $newItem.find('[name="cart[][product_id]"]');
                let $category = $newItem.find('[name="cart[][category_id]"]');
                let $qty = $newItem.find('[name="cart[][qty]"]');
                let $discount = $newItem.find('[name="cart[][discount_value]"]');
                let $price = $newItem.find('[name="cart[][price]"]');

                $productId.attr("name", "cart["+($cartProducts+1)+"][product_id]")
                $category.attr("name", "cart["+($cartProducts+1)+"][category_id]")
                $qty.attr("name", "cart["+($cartProducts+1)+"][qty]")
                $discount.attr("name", "cart["+($cartProducts+1)+"][discount_value]")
                $price.attr("name", "cart["+($cartProducts+1)+"][price]")


                calculateCartItems($cart.find('tr').find('.qty')[0])

                $('.qty').on('change', function(){
                  calculateCartItems($(this))
                });

                $('.newItem .products').select2({
                  closeOnSelect: false,
                  placeholder: '--Multi Select--',
                  allowClear: true
                }).on('change.select2', function() {
                    getProductCategories($(this))
                });
              }


              function getProductCategories($element) {
                var self = $element;
                let $parent = $(self).parent().parent();
                $parent.find('.categories option').remove();
                axios.post("{{route('get-product-categories')}}",{product_id: $element.val()}).
                then(response => {
                  for (i=0; i < response.data.categories.length; i++){
                    var option = new Option(response.data.categories[i].title, response.data.categories[i].category_id);
                    $(option).html(response.data.categories[i].title);
                    $parent.find('.categories').append(option);
                    if (response.data.image){
                      $parent.find('.pro-img img').attr('src', response.data.image);
                    }
                    $parent.find('.product_price_text').text(response.data.price);
                    $parent.find('.price').val(response.data.price);
                  }
                })
              }

              function deleteProd (obj) {
                $(obj).closest('tr').remove();
                let $cart = $('#user_Prods');
                calculateCartItems($cart.find('tr').find('.qty')[0])
              }

              // Order product

              let ids = [];
              $('[data-modal="modal"]').on('click', function() {
                if ($(this).data('id') === 'bulk') {
                  $.each($('.list-check:checked'), function() {
                    ids.push($(this).val());
                  });
                  $('#order_id').val(ids);
                } else {
                  $('#order_id').val($(this).data('id'));
                }
                $('#status_id').val($(this).data('status'));
                $('[data-modal-title="title"]').text($(this).data('title'));
                $('#confirmForm').attr('action', $(this).data('url'));
                $('#method').val($(this).data('type'));
                $;
              });

            </script>
@endsection
