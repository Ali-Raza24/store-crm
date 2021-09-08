<div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="" id="confirmForm" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="" id="method">
                    <input type="hidden" name="product_id" id="product_id">
                    <input type="hidden" name="status_id" id="status_id">
                    <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title Product</span>?</h2>
                    <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update this Product?</span></h4>
                    <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Ok</span></button>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">Cancel </a>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade customer-modal" id="addNewCategory" role="dialog" aria-hidden="true">
    <form id="categoryForm" method="post" action="{{route('category.create')}}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="font-weight-700 dark-one mb-2">
                        Add New Category
                    </h3>
                    <div class="alert-message"></div>
                    <div class="mt-4 mb-4 ml-auto mr-auto">
                        <div class="form-group text-left">
                            <label class="font-weight-600 dark-one mb-2">Category Name</label>
                            {!! Form::text('title', null, ['class' => 'form-control sm-radius-control white-border-control '.($errors->has('title') ? 'danger-border' : '')]) !!}
                            @error('title')
                            <div class="input-info danger-bg">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-left">
                        <label class="font-weight-600 dark-one mb-2">Status</label>
                        {!! Form::select('is_active', [1 => 'Active', 2 => 'InActive'], null, ['class' => 'form-control sm-radius-control white-border-control '.($errors->has('is_active') ? 'danger-border' : '')]) !!}
                        @error('is_active')
                        <div class="input-info danger-bg">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                    <button class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal" data-form="add">Close</button>
                    <button class="btn-size btn-rounded btn-primary ml-1 mr-1">Add</button>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="modal fade customer-modal" id="addNewBrand" role="dialog" aria-hidden="true">
    <form id="brandForm" method="post" action="{{route('brand.create')}}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="font-weight-700 dark-one mb-2">
                        Add New Brand
                    </h3>
                    <div class="alert-message"></div>
                    <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                        <div class="form-group text-left">
                            <label class="font-weight-600 dark-one mb-2">Brand Name</label>
                            {!! Form::text('title', null, ['class' => 'form-control sm-radius-control white-border-control '.($errors->has('title') ? 'danger-border' : '')]) !!}
                            @error('title')
                            <div class="input-info danger-bg">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group text-left">
                            <label class="font-weight-600 dark-one mb-2">Status</label>
                            <div class="form-icon">
                            {!! Form::select('is_active', [1 => 'Active', 2 => 'InActive'], null, ['class' => 'form-control sm-radius-control white-border-control '.($errors->has('is_active') ? 'danger-border' : '')]) !!}
                            @error('is_active')
                            <div class="input-info danger-bg">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                                <span>
                                    <img src="{{asset('business_assets/images/angledown.png')}}" alt="">
                                </span>
                            </div>
                        </div>
                    </div>
                    <button class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal" data-form="add">Close</button>
                    <button class="btn-size btn-rounded btn-primary ml-1 mr-1">Add</button>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Modal -->
<div class="modal fade customer-modal" id="impCsv" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="font-weight-700 dark-one mb-2">Import Customers from CSV file</h3>
                {!! Form::open(['route' => 'product-import', 'files' => true]) !!}
                <div class="form-group mt-4 mb-4 w-75 ml-auto mr-auto">
                    <div class="form-icon">
                        <input type="file" placeholder="C/:" name="products"
                               class="form-control sm-radius-control white-border-control">
                        <span>
                                <img alt="" src="{{asset('business_assets/images/folder.png')}}">
                            </span>
                    </div>
                </div>
                <h4 class="dark-two mb-3">
                    Download a sample file CSV file <span class="dark-one font-weight-600">
                        <a href="{{asset('sample-files/sample-products.csv')}}" target="_blank">Click Here</a>
                    </span>
                </h4>
                <button class="btn-size btn-rounded btn-primary ml-1 mr-1"> Upload </button>
                <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                    Cancel </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="body-overlay"></div>
