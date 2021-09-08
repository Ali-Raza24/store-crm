
<style>
    .imageValMsg{
        background: #e85c62;
        position: absolute;
        position: absolute;
        bottom: -45px;
        left: 0;
        right: 0;
        padding: 8px 11px;
        border-radius: 5px;
        margin-bottom: 8px;
        padding-bottom: 1px;
    }
</style>
<form method='post' id='updatepageform' enctype='multipart/form-data' action='{{route('admin-page-store')}}'>
        @csrf
    <?php

    if(!empty($page->content)){
        $pagecontent=json_decode($page->content);

       $oldvalues= old('content')['page']['name'] ?? '';

        //print_r($oldvalues);
    }
    ?>
        <div class="row">
            <div class="col-md-12 form-group">
                <hr class="mt-5 mb-3">
                <h4 class="col-12 font-weight-700 dark-one mb-4">Banner Section</h4>
                <hr class=" mb-3">
            </div>
            <div class="col-sm-6 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Name</label>
                <input type="text" name='content[page][name]' value='@if(!empty(old('content')['page']['name'])){{old('content')['page']['name'] ?? ''}}@elseif(!empty($page->name)){{$page->name ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('content.page.name') danger-border @enderror" readonly/>
                @error('content.page.name')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>


            <div class="col-sm-6 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Title</label>
                <input type="text" name='content[page][title]' value='@if(!empty(old('content')['page']['title'])){{old('content')['page']['title'] ?? ''}}@elseif(!empty($page->title)){{$page->title ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('content.page.title') danger-border @enderror"/>
                @error('content.page.title')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>
            <!-- banner section -->
            <div class="row">

                    <div class="col-12">
                    <div class="col-12">

                        <div class="form-group mb-4">
                            @error('images.banner')
                            <div class="col-12 imageValMsg" style=''>{{ $message }}</div>
                            @enderror
                            <input type="file" id="imgupload" name="images[banner]" class="d-none">
                            <div class="bg-gray uploader sm-radius-control cursor-pointer" id="eid">
                                @if(!empty($page->banner))
                                            <span>

                                                    <img alt="" id="userPreview"
                                                         src="@if(!empty($page->banner)){{ $page->banner }}@else{{asset('admin_assets/images/upload-img1.png')}}@endif"
                                                         style="max-width: 504px; max-height:147px" onclick="uploadDialog()">

                                            </span>
                                @else
                                    <span>

                                                    <img alt="" id="userPreview"
                                                         src="{{asset('admin_assets/images/upload-img1.png')}}"
                                                         style="max-width: 504px; max-height:147px" onclick="uploadDialog()">

                                            </span>
                                @endif
                            </div>
                            <a class="upload-btner dark-one" href="javascript:void(0)">Home page Banner</a>
                        </div>
                    </div>

            </div>
            </div>
            <div class="row">
            <div class="col-sm-6 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Banner Title</label>
                <input type="text" name='content[banner][title]' value='@if(!empty(old('content')['banner']['title'])){{old('content')['banner']['title'] ?? ''}}@elseif(!empty($pagecontent->banner->title)){{ $pagecontent->banner->title ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('content.banner.title') danger-border @enderror"/>
                @error('content.banner.title')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Banner Button Title</label>
                <input type="text" name='content[banner][btn_title]' value='@if(!empty(old('content')['banner']['btn_title'])){{old('content')['banner']['btn_title'] ?? ''}}@elseif(!empty($pagecontent->banner->btn_title)){{ $pagecontent->banner->btn_title ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('content.banner.btn_title') danger-border @enderror"/>
                @error('content.banner.btn_title')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Banner Button link</label>
                <input type="text" name='content[banner][banner_btn_link]' value='@if(!empty(old('content')['banner']['banner_btn_link'])){{old('content')['banner']['banner_btn_link'] ?? ''}}@elseif(!empty($pagecontent->banner->banner_btn_link)){{ $pagecontent->banner->banner_btn_link ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('content.banner.banner_btn_link') danger-border @enderror"/>
                @error('content.banner.banner_btn_link')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>
                <div class="col-md-12 form-group">
                <hr class="mt-5 mb-3">
                    <h4 class="col-12 font-weight-700 dark-one mb-4">Ecommerce Section</h4>
                <hr class=" mb-3">
                </div>
            <div class="col-sm-6 form-group mb-3">
                <label class="font-weight-600 dark-one">Ecommerce Heading</label>
                <input type="text" name='content[ecommerce][heading]' value='@if(!empty(old('content')['ecommerce']['heading'])){{old('content')['ecommerce']['heading'] ?? ''}}@elseif(!empty($pagecontent->ecommerce->heading)){{ $pagecontent->ecommerce->heading ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('content.ecommerce.heading') danger-border @enderror"/>
                @error('content.ecommerce.heading')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Ecommerce Content</label>
                <textarea id="" name='content[ecommerce][content]'  placeholder="" class="form-control order-edit-control @error('content.ecommerce.content') danger-border @enderror">@if(!empty(old('content')['ecommerce']['content'])){{old('content')['ecommerce']['content'] ?? ''}}@elseif(!empty($pagecontent)){{ strip_tags($pagecontent->ecommerce->content) ?? ''}}@endif</textarea>
                @error('content.ecommerce.content')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Button Title</label>
                <input type="text" name='content[ecommerce][btn_title]' value='@if(!empty(old('content')['ecommerce']['btn_title'])){{old('content')['ecommerce']['btn_title'] ?? ''}}@elseif(!empty($pagecontent->ecommerce->btn_title)){{ $pagecontent->ecommerce->btn_title ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('content.ecommerce.btn_title') danger-border @enderror"/>
                @error('content.ecommerce.btn_title')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Button Link</label>
                <input type="text" name='content[ecommerce][btn_link]' value='@if(!empty(old('content')['ecommerce']['btn_link'])){{old('content')['ecommerce']['btn_link'] ?? ''}}@elseif(!empty($pagecontent->ecommerce->btn_link)){{ $pagecontent->ecommerce->btn_link ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('content.ecommerce.btn_link') danger-border @enderror"/>
                @error('content.ecommerce.btn_link')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Youtube Video Link</label>
                <input type="text" name='content[ecommerce][video_link]' value='@if(!empty(old('content')['ecommerce']['video_link'])){{old('content')['ecommerce']['video_link'] ?? ''}}@elseif(!empty($pagecontent->ecommerce->video_link)){{ $pagecontent->ecommerce->video_link ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('content.ecommerce.video_link') danger-border @enderror"/>
                @error('content.ecommerce.video_link')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12 form-group mb-3">
                <input type="hidden" name='page_id' value='@if(!empty($page->id)){{$page->id ?? ''}}@endif'/>
            </div>
            </div>
            <!-- Why oogo Image section -->
            <div class="col-md-12 form-group">
                <hr class="mt-5 mb-3">
                <h4 class="col-12 font-weight-700 dark-one mb-4">Service Section</h4>
                <hr class=" mb-3">
            </div>
                <div class="row">

                    <div class="col-12">

                            <div class="form-group mb-4">
                                @error('images.service')
                                <div class="imageValMsg" style=''>{{ $message }}</div>
                                @enderror
                                <input type="file" id="imguploadservice" name="images[service]" class="d-none">
                                <div class="bg-gray uploader sm-radius-control cursor-pointer @error('images.service') danger-border @enderror" id="eid">
                                            <span>
                                                @if(!empty($page->service))
                                                    <img alt="" id="userPreviewservice"
                                                         src="{{$page->service}}"
                                                         style="max-width: 504px; max-height:147px" onclick="uploadDialogservice()">
                                                @else
                                                    <img alt="" id="userPreviewservice"
                                                         src="{{asset('admin_assets/images/upload-img1.png')}}"
                                                         style="max-width: 504px; max-height:147px" onclick="uploadDialogservice()">
                                                @endif

                                            </span>

                                </div>
                                <a class="upload-btner dark-one" href="javascript:void(0)">Service Section Banner</a>

                            </div>


                    </div>
                </div>

                    <div class="col-12 form-group mb-3">
                        <label class="font-weight-600 dark-one">Service Heading</label>
                        <input type="text" name='content[service][heading]' value='@if(!empty(old('content')['service']['heading'])){{old('content')['service']['heading'] ?? ''}}@elseif(!empty($pagecontent)){{ $pagecontent->service->heading ?? ''}}@endif' class="form-control order-edit-control @error('content.service.heading') danger-border @enderror"/>
                        @error('content.service.heading')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
            <div class="col-md-12 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Services Content</label>
                <textarea id="myTextarea" name='content[service][content]' class="form-control order-edit-control @error('content.service.content') danger-border @enderror">@if(!empty(old('content')['service']['content'])){{old('content')['service']['content'] ?? ''}}@elseif(!empty($pagecontent->service->content)){!! $pagecontent->service->content !!}@endif</textarea>
                @error('content.service.content')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>

            <!-- home page pricing section -->
            <div class="col-md-12 form-group">
                <hr class="mt-5 mb-3">
                <h4 class="col-12 font-weight-700 dark-one mb-4">Pricing Section</h4>
                <hr class=" mb-3">
            </div>
            <div class="col-md-12 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Pricing Section Content</label>
                <textarea id="pricingTextarea" name='content[pricing][content]' class="form-control order-edit-control @error('content.pricing.content') danger-border @enderror">@if(!empty(old('content')['pricing']['content'])){{old('content')['pricing']['content'] ?? ''}}@elseif(!empty($pagecontent->pricing->content)){{ $pagecontent->pricing->content ?? ''}}@endif</textarea>
                @error('content.pricing.content')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 form-group">
                <hr class="mt-5 mb-3">
                <h4 class="col-12 font-weight-700 dark-one mb-4">Request Section</h4>
                <hr class=" mb-3">
            </div>
            <div class="col-md-12 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Request Section Content</label>
                <textarea id="requstTextarea" name='content[request][content]' class="form-control order-edit-control @error('content.request.content') danger-border @enderror">@if(!empty(old('content')['request']['content'])){{old('content')['request']['content'] ?? ''}}@elseif(!empty($pagecontent->request->content)){{ $pagecontent->request->content ?? ''}}@endif</textarea>
                @error('content.request.content')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>
            <!-- contact information section -->
            <div class="col-md-12 form-group">
                <hr class="mt-5 mb-3">
                <h4 class="col-12 font-weight-700 dark-one mb-4"> Section Contact Information</h4>
                <hr class=" mb-3">
            </div>
            <div class="col-12 form-group mb-3">
                <label class="font-weight-600 dark-one">Contact Information Heading</label>
                <input type="text" name='content[information][heading]' value='@if(!empty(old('content')['information']['heading'])){{old('content')['information']['heading'] ?? ''}}@elseif(!empty($pagecontent)){{ $pagecontent->information->heading ?? ''}}@endif' class="form-control order-edit-control @error('content.information.heading') danger-border @enderror"/>
                @error('content.information.heading')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Contact Information Content</label>
                <textarea id="contactInfoTextarea" name='content[information][content]' class="form-control order-edit-control @error('content.information.content') danger-border @enderror">@if(!empty(old('content')['information']['content'])){{old('content')['information']['content'] ?? ''}}@elseif(!empty($pagecontent->information->content)){{ $pagecontent->information->content ?? ''}}@endif</textarea>
                @error('content.information.content')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>

        </div>

    </form>
    <div class="form-group mb-0 text-right">
        <hr class="mt-5 mb-3"/>
        <a onclick='return submitPageEditForm();' href="javascript:void(0)" class="btn-size btn-rounded btn-primary mr-3">
            Update
        </a>
    </div>


