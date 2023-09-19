<!-- Modal -->
<div id="trainee-manner-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.trainee_manner.")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.trainee-manners.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="trainee_id" class="input-trainee-id-modal" value="{{ old('trainee_id') }}">
                    <div class="form-group">
                        <label>@lang('form.trainee_manner.date')</label> <span class="text-danger">*</span>
                        <input type="text" class="form-control js-datepicker" name="date" value="{{ old('date') }}" required>
                        @if ($errors->has('date'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('date') }}</strong>
                            </span>
                        @endif
                    </div>
                    @forelse(\App\Constants\MannerConstant::MANNER as $key => $manner)
                        <div class="form-group">
                            <label>{{ $manner['name'] }}</label> <span class="text-danger">*</span>
                            <input type="hidden" class="form-control" name="trainee[{{ $key }}][name]" value="{{ $manner['name'] }}" required>
                            <input type="hidden" class="form-control" name="trainee[{{ $key }}][max]" value="{{ $manner['max_scores'] }}" required>
                            <input type="number" min="0" max="{{ $manner['max_scores'] }}" class="form-control" name="trainee[{{ $key }}][scores]" value="10" required>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">@lang('form.button.save')</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('form.button.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
