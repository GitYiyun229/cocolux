<div class="row">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.banner.title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="title" value="{{ isset($banner) ? $banner->title : old('title') }}" required>
                    @if ($errors->has('title'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('title') }}</strong>
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
                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Banners::STATUS_ACTIVE }}" {{ (isset($banner->active) && $banner->active == \App\Models\Banners::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Banners::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Banners::STATUS_INACTIVE }}" {{ (isset($banner) && $banner->active == \App\Models\Banners::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Banners::STATUS_INACTIVE)) ? 'checked' : '' }} required>
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
                <div class="form-group">
                    <label>@lang('form.banner.type')</label>
                    <div class="form-group clearfix ">
                        <select name="type" class="form-control">
                            <option value="" hidden>@lang('form.banner.type')</option>
                            @forelse(\App\Models\Banners::GROUP as $key => $value)
                                <option value="{{ $value }}" @if (isset($banner) && isset($banner->type) && ($banner->type == $value)) selected @elseif (old('type') == $value ) selected @endif>{{ $value }}</option>
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
                <div class="form-group">
                    <label>@lang('form.banner.image_url')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($banner->image_url) ? $banner->image_url : old('image_url'),'name' => 'image_url'])
                        @if ($errors->has('image_url'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('image_url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.banner.mobile_url')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($banner->mobile_url) ? $banner->mobile_url : old('mobile_url'),'name' => 'mobile_url'])
                        @if ($errors->has('mobile_url'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('mobile_url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.slider.url')</label>
                    <input type="text" class="form-control" name="url" value="{{ isset($slider) ? $slider->url : old('url') }}" required>
                    @if ($errors->has('url'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('url') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.slider.content')</label>
                    <textarea class="form-control" rows="3" name="content" >{{ isset($slider) ? $slider->content : old('content') }}</textarea>
                    @if ($errors->has('content'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('content') }}</strong>
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
@endsection
