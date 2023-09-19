<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#update-reference-new-modal-{{$q->id}}" title="{{ trans('form.button.edit') }}"><i class="fa fa-edit"></i></button>
<!-- Modal -->
<div id="update-reference-new-modal-{{$q->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.reference_new.update")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.reference-new.update', $q->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $q->id }}">
                    <div>
                        <label for="" class="float-left">@lang("form.reference_new.title")</label>
                        <input type="text" name="title" class="form-control" value="{{ $q->title }}" required>
                    </div>
                    <div>
                        <label for="" class="float-left">@lang("form.reference_new.category")</label>
                        <input type="text" name="category" class="form-control" value="{{ $q->category }}" required>
                    </div>
                    <div>
                        <label for="" class="float-left">@lang("form.reference_new.url")</label>
                        <input type="text" name="url" class="form-control" value="{{ $q->url }}" required>
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
