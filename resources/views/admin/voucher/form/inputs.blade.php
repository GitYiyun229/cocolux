<div class="row">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.name')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="name" value="{{ isset($voucher) ? $voucher->name : old('name') }}" required>
                    @if ($errors->has('name'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.status.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Voucher::STATUS_ACTIVE }}" {{ (isset($voucher->active) && $voucher->active == \App\Models\Voucher::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Voucher::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Voucher::STATUS_INACTIVE }}" {{ (isset($voucher) && $voucher->active == \App\Models\Voucher::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Voucher::STATUS_INACTIVE)) ? 'checked' : '' }} required>
                            <label for="statusRadio2" class="custom-control-label">@lang('form.status.inactive')</label>
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
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.start_date')</label> <span class="text-danger">*</span>
                    <input type="date" class="form-control" name="start_date" value="{{ isset($voucher) ? $voucher->start_date : old('start_date') }}" readonly>
                    @if ($errors->has('start_date'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.end_date')</label> <span class="text-danger">*</span>
                    <input type="date" class="form-control" name="end_date" value="{{ isset($voucher) ? $voucher->end_date : old('end_date') }}" readonly>
                    @if ($errors->has('end_date'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.from_value')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="from_value" value="{{ isset($voucher) ? $voucher->from_value : old('from_value') }}" readonly>
                    @if ($errors->has('from_value'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('from_value') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.number_of_codes')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="number_of_codes" value="{{ isset($voucher) ? $voucher->number_of_codes : old('number_of_codes') }}" readonly>
                    @if ($errors->has('number_of_codes'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('number_of_codes') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.total_used_time')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="total_used_time" value="{{ isset($voucher) ? $voucher->total_used_time : old('total_used_time') }}" readonly>
                    @if ($errors->has('total_used_time'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('total_used_time') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.total_assign')</label>
                    <input type="text" class="form-control" name="total_assign" value="{{ isset($voucher) ? $voucher->total_assign : old('total_assign') }}" readonly>
                    @if ($errors->has('total_assign'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('total_assign') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.status.value_type')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="value_typeRadio1" name="value_type" value="{{ \App\Models\Voucher::VOUCHER_TYPE }}" {{ (isset($voucher->value_type) && $voucher->value_type == \App\Models\Voucher::STATUS_ACTIVE) ? 'checked' : (old('value_type') && (old('value_type') == \App\Models\Voucher::VOUCHER_TYPE)) ? 'checked' : '' }}  required>
                            <label for="value_typeRadio1" class="custom-control-label">Tiền mặt&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="value_typeRadio2" name="value_type" value="{{ \App\Models\Voucher::VOUCHER_TYPE_P }}" {{ (isset($voucher) && $voucher->value_type == \App\Models\Voucher::VOUCHER_TYPE_P) ? 'checked' : (old('value_type') && (old('value_type') == \App\Models\Voucher::VOUCHER_TYPE_P)) ? 'checked' : '' }} required>
                            <label for="value_typeRadio2" class="custom-control-label">Phần trăm</label>
                        </div>
                    </div>
                    @if ($errors->has('value_type'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('value_type') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.value')</label>
                    <input type="text" class="form-control" name="value" value="{{ isset($voucher) ? $voucher->value : old('value') }}" readonly>
                    @if ($errors->has('value'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('value') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.value_max')</label>
                    <input type="text" class="form-control" name="value_max" value="{{ isset($voucher) ? $voucher->value_max : old('value_max') }}" readonly>
                    @if ($errors->has('value_max'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('value_max') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.voucher.description')</label>
                    <textarea class="form-control" rows="3" name="description" >{{ isset($voucher) ? $voucher->description : old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5">

    </div>
</div>

@section('script')
    @parent
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
@endsection
