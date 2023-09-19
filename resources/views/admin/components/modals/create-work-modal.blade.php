<!-- Modal -->
<div id="create-work-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.create_work")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.works.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div>
                        <label for="">@lang("form.user.name")</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div>
                        <label for="">@lang("form.order.desc")</label>
                        <textarea name="desc" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">@lang('form.button.save')</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('form.button.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
