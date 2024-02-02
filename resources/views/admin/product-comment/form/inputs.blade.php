<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.product_comment.name')</label>
                    <input type="text" class="form-control" name="name" value="{{ isset($product_comment) ? $product_comment->name : old('name') }}" required>
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
                    <label>@lang('form.product_comment.phone')</label>
                    <input type="text" class="form-control" name="phone" value="{{ isset($product_comment) ? $product_comment->phone : old('phone') }}">
                    @if ($errors->has('phone'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.product_comment.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="activeRadio1" name="active" value="{{ \App\Models\ProductsCategories::STATUS_ACTIVE }}" {{ isset($product_comment) && $product_comment->active == \App\Models\productsCategories::STATUS_ACTIVE ? 'checked' : (old('active') && (old('active') == \App\Models\productsCategories::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="activeRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="activeRadio2" name="active" value="{{ \App\Models\productsCategories::STATUS_INACTIVE }}" {{ isset($product_comment) && $product_comment->active == \App\Models\productsCategories::STATUS_INACTIVE ? 'checked' : (old('active') && (old('active') === \App\Models\productsCategories::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
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
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.content')</label> <span class="text-danger">*</span>
                    <textarea class="form-control" rows="3" id="content" name="content" required >{{ isset($product_comment) ? $product_comment->content : old('content') }}</textarea>
                    @if ($errors->has('content'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('content') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.product_comment.rating')</label>
                    <input type="number" min="1" max="5" class="form-control" name="rating" value="{{ isset($product_comment) ? $product_comment->rating : old('rating') }}">
                    @if ($errors->has('rating'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('rating') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <p>Bình luận sản phầm: <b>{{ $product->title }}</b></p>
    </div>
</div>

@section('link')
    @parent
@endsection

@section('script')
    @parent
@endsection
