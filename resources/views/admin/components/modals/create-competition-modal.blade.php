<!-- Modal -->
<div id="create-competition-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.competition.create")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.competitions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div>
                        <label for="">@lang("form.competition.title")</label> <span class="text-danger">*</span>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        @if ($errors->has('title'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <label for="">@lang("form.user.status")</label> <span class="text-danger">*</span>
                        <select name="is_active" class="form-control" required>
                            <option value="" hidden>@lang('form.user.status')</option>
                            <option value="{{ \App\Models\Competition::TYPE_ACTIVE }}" @if(old('is_active') == \App\Models\Competition::TYPE_ACTIVE) selected @endif>@lang('form.status.active')</option>
                            <option value="{{ \App\Models\Competition::TYPE_INACTIVE }}" @if(old('is_active') == \App\Models\Competition::TYPE_INACTIVE) selected @endif>@lang('form.status.inactive')</option>
                        </select>
                        @if ($errors->has('is_active'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('is_active') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <label for="">@lang("form.question.lesson")</label> <span class="text-danger">*</span><br>
                        <select name="lesson[]" class="form-control js-select2" required  multiple="multiple">
                            @forelse(\App\Constants\LessonExamConstant::LESSON_EXAM as $key => $lesson)
                                <option value="{{ $key }}" @if(is_array(old('lesson')) && in_array($key, old('lesson'))) selected @endif>{{ $lesson }}</option>
                            @empty
                            @endforelse
                        </select>
                        @if ($errors->has('lesson'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('lesson') }}</strong>
                            </span>
                        @endif
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
