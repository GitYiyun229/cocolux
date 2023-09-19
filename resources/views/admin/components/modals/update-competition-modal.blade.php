<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#update-competition-modal-{{$q->id}}" title="{{ trans('form.button.edit') }}"><i class="fa fa-edit"></i></button>
<div id="update-competition-modal-{{$q->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.competition.update")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.competitions.update', $q->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div>
                        <label for="" class="float-left">@lang("form.competition.title")</label> <span class="text-danger float-left">*</span>
                        <input type="text" name="title" class="form-control" value="{{ $q->title }}">
                        @if ($errors->has('title'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <label for="" class="float-left">@lang("form.user.status")</label> <span class="text-danger float-left">*</span>
                        <select name="is_active" class="form-control" required>
                            <option value="" hidden>@lang('form.user.status')</option>
                            <option value="{{ \App\Models\Competition::TYPE_ACTIVE }}" @if($q->is_active == \App\Models\Competition::TYPE_ACTIVE) selected @endif>@lang('form.status.active')</option>
                            <option value="{{ \App\Models\Competition::TYPE_INACTIVE }}" @if($q->is_active == \App\Models\Competition::TYPE_INACTIVE) selected @endif>@lang('form.status.inactive')</option>
                        </select>
                        @if ($errors->has('is_active'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('is_active') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <label for="" class="float-left">@lang("form.question.lesson")</label> <span class="text-danger float-left">*</span><br>
                        <select name="lesson[]" class="form-control js-select2" required  multiple="multiple">
                            @forelse(\App\Constants\LessonExamConstant::LESSON_EXAM as $key => $lesson)
                                <option value="{{ $key }}" @if(in_array($key, optional($q->lessons)->pluck('lesson')->toArray())) selected @endif>{{ $lesson }}</option>
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
