<div class="row">
    <div class="col-sm-6">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.slider.title')</label> <span class="text-danger">*</span>
            <input type="text" class="form-control" name="title" value="{{ isset($slider) ? $slider->title : old('title') }}" required>
            @if ($errors->has('title'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group clearfix">
            <label>@lang('form.slider.active')</label> <span class="text-danger">*</span>
            <div class="form-group">
                <div class="icheck-success d-inline">
                    <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Sliders::STATUS_ACTIVE }}" {{ isset($slider->active) && $slider->active == \App\Models\Sliders::STATUS_ACTIVE ? 'checked' : 'checked' }} required>
                    <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                </div>
                <div class="icheck-danger d-inline">
                    <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Sliders::STATUS_INACTIVE }}" {{ isset($slider->active) && $slider->active == \App\Models\Sliders::STATUS_INACTIVE ? 'checked' : '' }} required>
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
    <div class="col-sm-3">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.slider.ordering')</label>
            <input type="text" class="form-control" name="ordering" value="{{ isset($slider) ? $slider->ordering : (old('ordering') ? old('ordering') : 1) }}" >
            @if ($errors->has('ordering'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('ordering') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>@lang('form.slider.image_url')</label> <span class="text-danger">*</span>
            <div class="input-group">
                @include('admin.components.buttons.image',['src' => isset($slider->image_url) ? $slider->image_url : old('image_url'),'name' => 'image_url'])
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
            <label>@lang('form.slider.mobile_url')</label> <span class="text-danger">*</span>
            <div class="input-group">
                @include('admin.components.buttons.image',['src' => isset($slider->mobile_url) ? $slider->mobile_url : old('mobile_url'),'name' => 'mobile_url'])
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
@section('script')
    @parent
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
@endsection
