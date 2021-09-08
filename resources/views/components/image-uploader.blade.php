<div class="col-12">
    <div id="image-upload" class="modal fade" role="dialog" data-easein="expandIn" data-modal="image-upload" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method='post' action='' enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title" data-modal-title="title">Upload Image</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        Select file : <input type='file' name='' data-file='file'
                                             class="form-control order-edit-control"><br>
                        <div id='uploader_message'></div>
                        <div id="uploader_progress" class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                 aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                        <div id='upload_preview' class="my-4">
                            <img src="" alt="" class="w-100" style="max-height: 500px; display: none" id="upload_preview_item">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type='button' style="display: none" class='btn-size btn-rounded btn-primary' data-action="crop">Crop
                        </button>
                        <button type='button' class='btn-size btn-rounded btn-secondary' data-action="cancel"
                                data-dismiss="modal">Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
