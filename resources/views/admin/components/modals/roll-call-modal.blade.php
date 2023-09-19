<div id="roll-call-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.roll_call.")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.roll-calls.save') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="trainee_id" value="{{ old('trainee_id') }}" class="input-trainee-id-modal">
                    <div>
                        <label for="">@lang("form.roll_call.rate_to_class")</label>
                        <input type="number" min="0" max="100" name="value" class="form-control" value="{{ old('value') ?? 100 }}" required>
                        @if ($errors->has('value'))
                            <span class="help-block text-danger">
                                    <strong>{{ $errors->first('value') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div>
                        <label for="">@lang("form.roll_call.date")</label>
                        <input type="text" name="date" class="form-control js-datepicker" value="{{ old('date') }}" required autocomplete="off">
                        @if ($errors->has('date'))
                            <span class="help-block text-danger">
                                    <strong>{{ $errors->first('date') }}</strong>
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
