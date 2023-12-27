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
            <div class="col-md-6">
                <div class="form-box form-group">
                    <label for="city">Tỉnh thành <span>*</span></label>
                    <select name="province" id="province" class="selec2-box form-control" onchange="loaddistrict(this.value)" required>
                        <option value="0" selected hidden disabled>Chọn Tỉnh/ Thành phố</option>
                        @forelse($list_city as $item)
                            <option value="{{ $item->code }}">{{ $item->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-box form-group">
                    <label for="district">Quận huyện <span>*</span></label>
                    <select name="district" id="district" class="selec2-box form-control" onchange="loadward(this.value)" required>
                        <option value="0" selected hidden disabled>Chọn Quận/ Huyện</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-box form-group">
                    <label for="ward">Phường xã <span>*</span></label>
                    <select name="ward" id="ward" class="selec2-box form-control" required>
                        <option value="0" selected hidden disabled>Chọn Phường/ Xã</option>
                    </select>
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
                <div class="form-group">
                    <label>Id Kho trên Nhanh</label>
                    <input type="text" class="form-control" name="id_nhanh" value="{{ isset($store) ? $store->id_nhanh : old('id_nhanh') }}">
                    @if ($errors->has('id_nhanh'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('id_nhanh') }}</strong>
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
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.article.is_home')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="homeRadio1" name="is_home" value="{{ \App\Models\Article::IS_HOME }}" {{ (isset($store->is_home) && $store->is_home == \App\Models\Article::IS_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Article::IS_HOME)) ? 'checked' : '' }}  required>
                            <label for="homeRadio1" class="custom-control-label">@lang('form.status.is_home')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="homeRadio2" name="is_home" value="{{ \App\Models\Article::IS_NOT_HOME }}" {{ (isset($store) && $store->is_home == \App\Models\Article::IS_NOT_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Article::IS_NOT_HOME)) ? 'checked' : '' }}  required>
                            <label for="homeRadio2" class="custom-control-label">@lang('form.status.is_not_home')</label>
                        </div>
                    </div>
                    @if ($errors->has('is_home'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('is_home') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Hình ảnh</label>
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
        </div>
    </div>
    <div class="col-sm-5">
{{--        @include('admin.store.form.ping')--}}
    </div>
</div>
@section('script')
    @parent
    <script src="{{ asset('ckfinder/ckfinder.js') }}?v=1.0"></script>
    <script>
        function loaddistrict(city_id) {
            $.ajax({
                type: 'post',
                url: '{{ route('loadDistrict') }}',
                dataType: 'JSON',
                data: {
                    city_id: city_id,
                    _token: "{{ csrf_token() }}",
                },
                success: function (data) {
                    let option = ''
                    option += `<option data-id="0" value="0">Chọn Quận/Huyện</option>`;
                    data.district.forEach(item => {
                        option += `<option value="${item.code}">${item.name}</option>`
                    });

                    $("#district").html(option);
                    $("#price_ship").html(formatMoney(data.price_ship));
                    $("#price_ship_coco").val(data.price_ship);
                    let total_price_ship = data.price_ship + parseInt($("#layoutForm #total_price").val());
                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship));
                    return true;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
            return false;
        }

        function loadward(district_id) {
            $.ajax({
                type: 'post',
                url: '{{ route('loadWard') }}',
                dataType: 'JSON',
                data: {
                    city_id: $('#layoutForm #city').val(),
                    district_id: district_id,
                    _token: "{{ csrf_token() }}",
                },
                success: function (data) {
                    let option = ''
                    option += `<option data-id="0" value="0">Chọn Phường/ Xã</option>`;
                    data.ward.forEach(item => {
                        option += `<option value="${item.code}">${item.name}</option>`
                    });

                    $("#ward").html(option);
                    $("#price_ship").html(formatMoney(data.price_ship));
                    $("#price_ship_coco").val(data.price_ship);
                    let total_price_ship = data.price_ship + parseInt($("#layoutForm #total_price").val());
                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship));
                    return true;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
            return false;
        }
    </script>
@endsection
