

<form method='post' id='updatepageform' enctype='multipart/form-data' action='{{route('admin-privacy-page-store')}}'>
        @csrf
    <?php
    if(!empty($page->content)){
        $pagecontent=json_decode($page->content);
    }
    ?>
        <div class="row">
            <div class="row">
            <!-- Why oogo Image section -->
                <div class="col-sm-6 form-group mb-3">
                    <label class="font-weight-600 dark-one mb-2">Title</label>
                    <input type="text" name='title' value='@if(old('title')){{old('title')}}@elseif(!empty($page->title)){{$page->title ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('title') danger-border @enderror"/>
                    @error('title')
                    <div class="input-info danger-bg">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6 form-group mb-3">
                    <label class="font-weight-600 dark-one mb-2">Name</label>
                    <input type="text" name='name' value='@if(old('name')){{old('name')}}@elseif(!empty($page->name)){{$page->name ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('name') danger-border @enderror" readonly/>
                    @error('name')
                    <div class="input-info danger-bg">{{ $message }}</div>
                    @enderror
                </div>
                    <div class="col-sm-6 form-group mb-3">
                        <label class="font-weight-600 dark-one"> Heading</label>
                        <input type="text" name='page_heading' value='@if(old('page_heading')){{old('page_heading')}}@elseif(!empty($page->heading)){{ $page->heading ?? ''}}@endif' placeholder="John Smith " class="form-control order-edit-control @error('page_heading') danger-border @enderror"/>
                        @error('page_heading')
                        <div class="input-info danger-bg">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="col-sm-6 form-group mb-3">
                    <label class="font-weight-600 dark-one mb-2">Link</label>
                    <input type="text" name='slug' value='{{url($page->slug) ?? ''}}' placeholder="Johnsmith@gmail.com" class="form-control order-edit-control @error('slug') danger-border @enderror" readonly/>
                    @error('slug')
                    <div class="input-info danger-bg">{{ $message }}</div>
                    @enderror
                </div>
            <div class="col-md-12 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2">Meta Discription</label>
                <textarea id="" name='meta_discription'  placeholder=""  class="form-control order-edit-control @error('meta_discription') danger-border @enderror">@if(old('meta_discription')){{old('meta_discription')}}@elseif(!empty($page->meta_discription)){{ $page->meta_discription ?? ''}}@endif</textarea>

                @error('meta_discription')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 form-group mb-3">
                <label class="font-weight-600 dark-one mb-2"> Content</label>
                <textarea id="myTextarea" name='content' class="form-control order-edit-control @error('content') danger-border @enderror">@if(old('content')){{strip_tags(old('content'))}}@elseif(!empty($pagecontent)){{ $pagecontent ?? ''}}@endif</textarea>

                @error('content')
                <div class="input-info danger-bg">{{ $message }}</div>
                @enderror
            </div>
                <div class="col-md-12 form-group mb-3">
                    <input type="hidden" name='page_id' value='@if(!empty($page->id)){{$page->id ?? ''}}@endif'/>
                </div>
            </div>

        </div>

    </form>
    <div class="form-group mb-0 text-right">
        <hr class="mt-5 mb-3"/>
        <a onclick='return submitPageEditForm();' href="javascript:void(0)" class="btn-size btn-rounded btn-primary mr-3">
            Update
        </a>
    </div>


