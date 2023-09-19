<!-- Modal -->
<div id="create-question-group-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.question_group.create")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.question-groups.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div>
                        <label for="">@lang("form.question.title")</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div>
                        <label for="">@lang("form.order.type")</label>
                        <select name="type" class="form-control" required>
                            <option value="" hidden>@lang('form.order.type')</option>
                            @forelse(\App\Constants\TypeQuestionConstant::TYPE as $key => $type)
                                <option value="{{ $key }}">{{ $type }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <label for="">@lang("form.question_group.scores_for_one_question")</label>
                        <input type="number" min="1" max="10" name="scores" class="form-control" required>
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
