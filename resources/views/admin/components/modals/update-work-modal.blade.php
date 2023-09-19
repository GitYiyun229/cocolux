<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#update-work-modal-{{$q->id}}" title="{{ trans('form.button.edit') }}"><i class="fa fa-edit"></i></button>
<!-- Modal -->
<div id="update-work-modal-{{$q->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.update_work")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.works.update', $q->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $q->id }}">
                    <div>
                        <label for="">@lang("form.user.name")</label>
                        <input type="text" name="name" class="form-control" value="{{ $q->name }}" required>
                    </div>
                    <div>
                        <label for="">@lang("form.order.desc")</label>
                        <textarea name="desc" class="form-control">{{ $q->desc }}</textarea>
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
