<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#update-question-group-modal-{{$q->id}}" title="{{ trans('form.button.edit') }}"><i class="fa fa-edit"></i></button>
<!-- Modal -->
<div id="update-question-group-modal-{{$q->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.question_group.update")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.question-groups.update', $q->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $q->id }}">
                    <div>
                        <label for="" class="float-left">@lang("form.question.title")</label>
                        <input type="text" name="title" class="form-control" value="{{ $q->title }}" required>
                    </div>
                    <div>
                        <label for="" class="float-left">@lang("form.order.type")</label>
                        <select name="type" class="form-control" required>
                            <option value="" hidden>@lang('form.order.type')</option>
                            @forelse(\App\Constants\TypeQuestionConstant::TYPE as $key => $type)
                                <option value="{{ $key }}" @if($q->type == $key) selected @endif>{{ $type }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <label for="" class="float-left">@lang("form.question_group.scores_for_one_question")</label>
                        <input type="number" min="1" max="10" name="scores" value="{{ $q->scores }}" class="form-control" required>
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
