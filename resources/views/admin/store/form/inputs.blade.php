<div class="row">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.store.name')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="name" value="{{ isset($store) ? $store->name : old('name') }}" required>
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
                    <label>@lang('form.store.phone')</label>
                    <input type="text" class="form-control" name="phone" value="{{ isset($store) ? $store->phone : old('phone') }}">
                    @if ($errors->has('phone'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.store.address')</label>
                    <input type="text" class="form-control" name="address" value="{{ isset($store) ? $store->address : old('address') }}">
                    @if ($errors->has('address'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.store.email')</label>
                    <input type="text" class="form-control" name="email" value="{{ isset($store) ? $store->email : old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.page.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Store::STATUS_ACTIVE }}" {{ (isset($store->active) && $store->active == \App\Models\Store::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Page::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Store::STATUS_INACTIVE }}" {{ (isset($store) && $store->active == \App\Models\Store::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Page::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
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
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.slider.image')</label>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($store->image) ? $store->image : old('image'),'name' => 'image'])
                        @if ($errors->has('image'))
                            <span class="help-block text-danger">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
{{--        @include('admin.store.form.ping')--}}
    </div>
</div>
@section('script')
    @parent
@endsection
