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
                    <label>@lang('form.promotion.link')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="link" value="{{ isset($promotion) ? $promotion->link : old('link') }}" required>
                    @if ($errors->has('link'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('link') }}</strong>
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
                        <select name="type" class="form-control" required>
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
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.promotion.thumbnail_url')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($promotion->thumbnail_url) ? $promotion->thumbnail_url : old('thumbnail_url'),'name' => 'thumbnail_url'])
                        @if ($errors->has('thumbnail_url'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('thumbnail_url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.promotion.image_deal')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($promotion->image_deal) ? $promotion->image_deal : old('image_deal'),'name' => 'image_deal'])
                        @if ($errors->has('image_deal'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('image_deal') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.promotion.applied_start_time')</label>
                    <input type="datetime-local" class="form-control" name="applied_start_time" value="{{ isset($promotion) ? $promotion->applied_start_time : old('applied_start_time') }}" required>
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
                    <input type="datetime-local" class="form-control" name="applied_stop_time" value="{{ isset($promotion) ? $promotion->applied_stop_time : old('applied_stop_time') }}" required>
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
        <div class="row">
            <div class="col-sm-12">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.promotion.file')</label>
                    <input type="file" class="form-control" name="file" value="">
                    @if ($errors->has('file'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('file') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <!-- text input -->
                <div class="form-group">
                    <label>Mã sku những sản phẩm xếp trước(cách nhau bởi dấu phẩy)</label>
                    <textarea name="sort_product" placeholder="sku1,sku2" id="sort_product" class="form-control" cols="30" rows="5">{{ isset($promotion) ? $promotion->sort_product : old('sort_product') }}</textarea>
                    @if ($errors->has('sort_product'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('sort_product') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    @parent
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
@endsection
