<div class="row">
{{--    đánh dấu loại tin tức--}}
    <input type="hidden" value="0" name="type" id="type">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.attribute-value.name')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="name" value="{{ isset($attribute_value) ? $attribute_value->name : old('name') }}" required>
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
                    <label>@lang('form.attribute-value.slug')</label> <span class="text-danger">(@lang('form.auto_slug'))</span>
                    <input type="text" class="form-control" name="slug" value="{{ isset($attribute_value) ? $attribute_value->slug : old('slug') }}">
                    @if ($errors->has('slug'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('slug') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.attribute-value.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\AttributeValues::STATUS_ACTIVE }}" {{ (isset($attribute_value->active) && $attribute_value->active == \App\Models\AttributeValues::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\AttributeValues::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\AttributeValues::STATUS_INACTIVE }}" {{ (isset($attribute_value) && $attribute_value->active == \App\Models\AttributeValues::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\AttributeValues::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
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
                    <label>Nổi bật</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="homeRadio1" name="is_home" value="{{ \App\Models\AttributeValues::IS_HOME }}" {{ (isset($attribute_value->is_home) && $attribute_value->is_home == \App\Models\AttributeValues::IS_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\AttributeValues::IS_HOME)) ? 'checked' : '' }}  required>
                            <label for="homeRadio1" class="custom-control-label">Có</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="homeRadio2" name="is_home" value="{{ \App\Models\AttributeValues::IS_NOT_HOME }}" {{ (isset($attribute_value) && $attribute_value->is_home == \App\Models\AttributeValues::IS_NOT_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\AttributeValues::IS_NOT_HOME)) ? 'checked' : '' }}  required>
                            <label for="homeRadio2" class="custom-control-label">Không</label>
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
                    <label>@lang('form.attribute-value.image')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($attribute_value->image) ? $attribute_value->image : old('image'),'name' => 'image'])
                        @if ($errors->has('image'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.attribute-value.category')</label> <span class="text-danger">*</span>
                    <select name="attribute_id" id="attribute_id" class="form-control" required>
                        <option value="" selected>--@lang('form.attribute-value.category')--</option>
                        @forelse($categories as $key => $category)
                            <option value="{{ $category['id'] }}" {{ isset($attribute_value->attribute_id) && $attribute_value->attribute_id == $category['id'] ? 'selected' : old('attribute_id') == $category['id'] ? 'selected' : '' }}>{{ $category['name'] }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>@lang('form.content')</label> <span class="text-danger">*</span>
                    <textarea id="content" name="content" class="form-control" rows="10" >{{ isset($attribute_value->content) ? replace_image($attribute_value->content) : old('content') }}</textarea>
                    @if ($errors->has('content'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
                    @endif
                    <div class="editor"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">SEO</h3>
            </div>
            <div class="card-body p-3">
                <div class="form-group">
                    <label>@lang('form.seo_title')</label>
                    <input type="text" class="form-control" name="seo_title" value="{{ isset($attribute_value) ? $attribute_value->seo_title : old('seo_title') }}" >
                    @if ($errors->has('seo_title'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_keyword')</label>
                    <input type="text" class="form-control" name="seo_keyword" value="{{ isset($attribute_value) ? $attribute_value->seo_keyword : old('seo_keyword') }}" >
                    @if ($errors->has('seo_keyword'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_keyword') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_description')</label>
                    <textarea class="form-control" rows="3" name="seo_description" >{{ isset($attribute_value) ? $attribute_value->seo_description : old('seo_description') }}</textarea>
                    @if ($errors->has('seo_description'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@section('link')
    @parent
@endsection

@section('script')
    @parent
    <script src="{{ asset('ckeditor/ckeditor.js') }}?v=1.0"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    <script>
        CKEDITOR.replace( 'content' );
    </script>
@endsection
