<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#update-course-modal-{{$q->id}}" title="{{ trans('form.button.edit') }}"><i class="fa fa-edit"></i></button>
<div id="update-course-modal-{{$q->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.course.update")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.courses.update', $q->id) }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $q->id }}" name="id">
                <div class="modal-body">
                    <div>
                        <label class="float-left">@lang('form.trainee.language_level')</label> <span class="text-danger float-left">*</span>
                        <input type="text" class="form-control" name="language_level" value="{{ $q->language_level }}" required>
                        @if ($errors->has('language_level'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('language_level') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <label class="float-left">@lang("form.user.status")</label> <span class="text-danger float-left">*</span>
                        <select name="is_active" class="form-control" required>
                            <option value="" hidden>@lang('form.user.status')</option>
                            <option value="{{ \App\Models\Course::ACTIVE }}" @if($q->is_active == \App\Models\Course::ACTIVE) selected @endif>@lang('form.status.active')</option>
                            <option value="{{ \App\Models\Course::INACTIVE }}" @if($q->is_active == \App\Models\Course::INACTIVE) selected @endif>@lang('form.status.inactive')</option>
                        </select>
                        @if ($errors->has('is_active'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('is_active') }}</strong>
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
