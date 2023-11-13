<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.promotion.name')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="name" value="{{ isset($promotion) ? $promotion->name : old('name') }}" required>
                    @if ($errors->has('name'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.promotion.code')</label>
                    <input type="text" class="form-control" name="code" value="{{ isset($promotion) ? $promotion->code : old('code') }}">
                    @if ($errors->has('code'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('code') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.promotion.type')</label>
                    <div class="form-group clearfix ">
                        <select name="type" class="form-control">
                            <option value="" hidden>@lang('form.promotion.type')</option>
                            @forelse(\App\Models\Promotions::TYPE as $key => $value)
                                <option value="{{ $value }}" @if (isset($promotion) && isset($promotion->type) && ($promotion->type == $value)) selected @elseif (old('type') == $value ) selected @endif>{{ $value }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    @if ($errors->has('type'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.promotion.applied_start_time')</label>
                    <input type="datetime-local" class="form-control" name="applied_start_time" value="{{ isset($promotion) ? $promotion->applied_start_time : old('applied_start_time') }}">
                    @if ($errors->has('applied_start_time'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('applied_start_time') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.promotion.applied_stop_time')</label>
                    <input type="datetime-local" class="form-control" name="applied_stop_time" value="{{ isset($promotion) ? $promotion->applied_stop_time : old('applied_stop_time') }}">
                    @if ($errors->has('applied_stop_time'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('applied_stop_time') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.promotion.file')</label>
            <input type="file" class="form-control" name="file" value="{{ old('applied_start_time') }}">
            @if ($errors->has('file'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('file') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

@section('script')
    @parent
@endsection
