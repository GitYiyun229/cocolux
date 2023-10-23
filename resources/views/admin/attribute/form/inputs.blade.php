<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.attribute.name')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="name" value="{{ isset($attribute) ? $attribute->name : old('name') }}" required>
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
                    <label>@lang('form.attribute.code')</label>
                    <input type="text" class="form-control" name="code" value="{{ isset($attribute) ? $attribute->code : old('code') }}">
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
                    <label>@lang('form.attribute.type')</label>
                    <div class="form-group clearfix ">
                        <select name="type" class="form-control">
                            <option value="" hidden>@lang('form.attribute.type')</option>
                            @forelse(\App\Models\Attribute::TYPE as $key => $value)
                                <option value="{{ $value }}" @if (isset($attribute) && isset($attribute->type) && ($attribute->type == $value)) selected @elseif (old('type') == $value ) selected @endif>{{ $value }}</option>
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
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.attribute.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="activeRadio1" name="active" value="{{ \App\Models\Attribute::STATUS_ACTIVE }}" {{ isset($attribute) && $attribute->active == \App\Models\Attribute::STATUS_ACTIVE ? 'checked' : (old('active') && (old('active') == \App\Models\Attribute::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="activeRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="activeRadio2" name="active" value="{{ \App\Models\Attribute::STATUS_INACTIVE }}" {{ isset($attribute) && $attribute->active == \App\Models\Attribute::STATUS_INACTIVE ? 'checked' : (old('active') && (old('active') === \App\Models\Attribute::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
                            <label for="activeRadio2" class="custom-control-label">@lang('form.status.inactive')</label>
                        </div>
                    </div>
                    @if ($errors->has('active'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('active') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">

    </div>
</div>

@section('script')
    @parent
@endsection
