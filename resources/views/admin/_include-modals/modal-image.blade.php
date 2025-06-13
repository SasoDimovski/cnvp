<div class="modal fade" id="ModalImage" style="text-align: center;" >
    <div class="modal-dialog">
        <div class="modal-content"  style="max-width: 100%; width: auto !important; display: inline-block;">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-exclamation-triangle  text-danger" ></i> <strong><span id="title_image"></span></strong></h6>
                <button type="button" class="close" data-dismiss="modal" style="cursor: pointer">&times;</button>
            </div>

            <!-- Modal body -->
{{--            <div class="modal-body" id="comment" name="comment"></div>--}}
            <div class="modal-body" id="body_image">
                <img src="" alt="modal_image" id="img_source" style="max-width: 100%">
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" style="cursor: pointer">{{__('global.close')}}</button>
            </div>

        </div>
    </div>
</div>
