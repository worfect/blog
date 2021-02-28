<div id="notice-overlay-modal" class="notice-message modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">{{ $title }}</h4>
            </div>

            <div class="modal-body">
                <div class="notice-message alert alert-{{ $message['level'] }}"
                     role="alert"
                >
                    {!! $message['message'] !!}
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
