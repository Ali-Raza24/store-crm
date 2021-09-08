

<form method='post' id='updatepageform' enctype='multipart/form-data' action='{{route('business-page-store')}}'>
    @csrf
    <div class="row">
        <div class="col-sm-6 form-group mb-3">
            <label class="font-weight-600 dark-one mb-2">Name</label>

            <input type="text" name='page_name' value='{{$page->name ?? ''}}' placeholder="" class="form-control order-edit-control @error('page_name') danger-border @enderror" readonly/>
            @error('page_name')
            <div class="input-info danger-bg">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-sm-6 form-group mb-3">
            <label class="font-weight-600 dark-one mb-2">Title</label>
            <input type="text" name='page_title' value='{{$page->title ?? ''}}' placeholder="" class="form-control order-edit-control @error('page_title') danger-border @enderror"/>
            @error('page_title')
            <div class="input-info danger-bg">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12 form-group mb-3">
            <label class="font-weight-600 dark-one">Meta Description</label>
            <textarea  name='meta_description' placeholder="" class="form-control order-edit-control @error('meta_description') danger-border @enderror">{{strip_tags($page->meta_discription ?? '')}}</textarea>
            @error('meta_description')
            <div class="input-info danger-bg">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-sm-6 form-group mb-3">
            <label class="font-weight-600 dark-one">Heading</label>
            <input type="text" name='page_heading' value='{{$page->heading ?? ''}}' placeholder="John Smith " class="form-control order-edit-control @error('page_heading') danger-border @enderror"/>
            @error('page_heading')
            <div class="input-info danger-bg">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-sm-6 form-group mb-3">
            <label class="font-weight-600 dark-one mb-2">Link</label>
            <input type="text" name='slug' value='@if(!empty($page->slug)){{ url($page->slug) }} @endif' placeholder="Johnsmith@gmail.com" class="form-control order-edit-control @error('slug') danger-border @enderror" readonly/>
            @error('slug')
            <div class="input-info danger-bg">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12 form-group mb-3">
            <label class="font-weight-600 dark-one mb-2">Content</label>
            <textarea id="myTextarea" name='page_content' placeholder="" class="form-control order-edit-control @error('page_content') danger-border @enderror">{{$page->content ?? ''}}</textarea>
            @error('page_content')
            <div class="input-info danger-bg">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12 form-group mb-3">
            <input type="hidden" name='page_id' value='{{$page->id ?? ''}}'/>
        </div>
    </div>
</form>
<div class="form-group mb-0 text-right">
    <hr class="mt-5 mb-3"/>
    <a onclick='return submitPageEditForm();' href="javascript:void(0)" class="btn-size btn-rounded btn-primary mr-3">
        Update
    </a>
</div>


