<div class="row">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.store.title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="title" value="{{ isset($store) ? $store->title : old('title') }}" required>
                    @if ($errors->has('title'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.store.city_id')</label>
                    <select name="city_id" id="city_id" class="form-control">
                        @forelse($cities as $city)
                            <option value="{{ $city->id }}" {{ isset($store) ? $store->city_id == $city->id ? 'selected': '' : old('city_id') }}>{{ $city->name }}</option>
                        @empty
                        @endforelse
                    </select>
                    @if ($errors->has('city_id'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('city_id') }}</strong>
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
                    <label>@lang('form.store.latitude')</label>
                    <input type="text" class="form-control" name="latitude" value="{{ isset($store) ? $store->latitude : old('latitude') }}">
                    @if ($errors->has('latitude'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('latitude') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.store.longitude')</label>
                    <input type="text" class="form-control" name="longitude" value="{{ isset($store) ? $store->longitude : old('longitude') }}">
                    @if ($errors->has('longitude'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('longitude') }}</strong>
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
        </div>
    </div>
    <div class="col-sm-5">
{{--        @include('admin.store.form.ping')--}}
    </div>
</div>
@section('script')
    @parent
@endsection
