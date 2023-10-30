<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.product_category.title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="title" value="{{ isset($product_category) ? $product_category->title : old('title') }}" required>
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
                    <label>@lang('form.product_category.slug')</label> <span class="text-danger">(@lang('form.auto_slug'))</span>
                    <input type="text" class="form-control" name="slug" value="{{ isset($product_category) ? $product_category->slug : old('slug') }}">
                    @if ($errors->has('slug'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('slug') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.product_category.image')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($product_category->image) ? $product_category->image : old('image'),'name' => 'image'])
                        @if ($errors->has('image'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.product_category.logo')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($product_category->logo) ? $product_category->logo : old('logo'),'name' => 'logo'])
                        @if ($errors->has('logo'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('logo') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.product_category.banner')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($product_category->banner) ? $product_category->banner : old('banner'),'name' => 'banner'])
                        @if ($errors->has('banner'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('banner') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.product_category.ordering')</label>
                    <input type="text" class="form-control" name="ordering" value="{{ isset($product_category) ? $product_category->ordering : old('ordering') }}" >
                    @if ($errors->has('ordering'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('ordering') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.product_category.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="activeRadio1" name="active" value="{{ \App\Models\ProductsCategories::STATUS_ACTIVE }}" {{ isset($product_category) && $product_category->active == \App\Models\productsCategories::STATUS_ACTIVE ? 'checked' : (old('active') && (old('active') == \App\Models\productsCategories::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="activeRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="activeRadio2" name="active" value="{{ \App\Models\productsCategories::STATUS_INACTIVE }}" {{ isset($product_category) && $product_category->active == \App\Models\productsCategories::STATUS_INACTIVE ? 'checked' : (old('active') && (old('active') === \App\Models\productsCategories::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
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
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.product_category.is_home')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="is_homeRadio1" name="is_home" value="{{ \App\Models\ProductsCategories::IS_HOME }}" {{ isset($product_category) && $product_category->is_home == \App\Models\productsCategories::IS_HOME ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\productsCategories::IS_HOME)) ? 'checked' : '' }}  required>
                            <label for="is_homeRadio1" class="custom-control-label">@lang('form.status.is_home')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="is_homeRadio2" name="is_home" value="{{ \App\Models\productsCategories::IS_NOT_HOME }}" {{ isset($product_category) && $product_category->is_home == \App\Models\productsCategories::IS_NOT_HOME ? 'checked' : (old('is_home') && (old('is_home') === \App\Models\productsCategories::IS_NOT_HOME)) ? 'checked' : '' }}  required>
                            <label for="is_homeRadio2" class="custom-control-label">@lang('form.status.is_not_home')</label>
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
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.product_category.is_visible')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="is_visibleRadio1" name="is_visible" value="{{ \App\Models\ProductsCategories::IS_VISIBLE }}" {{ isset($product_category) && $product_category->is_visible == \App\Models\productsCategories::IS_VISIBLE ? 'checked' : (old('is_visible') && (old('is_visible') == \App\Models\productsCategories::IS_VISIBLE)) ? 'checked' : '' }}  required>
                            <label for="is_visibleRadio1" class="custom-control-label">@lang('form.status.is_visible')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="is_visibleRadio2" name="is_visible" value="{{ \App\Models\productsCategories::IS_NOT_VISIBLE }}" {{ isset($product_category) && $product_category->is_visible == \App\Models\productsCategories::IS_NOT_VISIBLE ? 'checked' : (old('is_visible') && (old('is_visible') === \App\Models\productsCategories::IS_NOT_VISIBLE)) ? 'checked' : '' }}  required>
                            <label for="is_visibleRadio2" class="custom-control-label">@lang('form.status.is_not_visible')</label>
                        </div>
                    </div>
                    @if ($errors->has('is_visible'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('is_visible') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card card-warning">
            <div class="card-header" style="background-color: #ccc;">
                <h3 class="card-title">SEO</h3>
            </div>
            <div class="card-body p-3">
                <div class="form-group">
                    <label>@lang('form.seo_title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="seo_title" value="{{ isset($product_category) ? $product_category->seo_title : old('seo_title') }}" >
                    @if ($errors->has('seo_title'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_keyword')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="seo_keyword" value="{{ isset($product_category) ? $product_category->seo_keyword : old('seo_keyword') }}" >
                    @if ($errors->has('seo_keyword'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_keyword') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_description')</label> <span class="text-danger">*</span>
                    <textarea class="form-control" rows="3" name="seo_description" >{{ isset($product_category) ? $product_category->seo_description : old('seo_description') }}</textarea>
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
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>@lang('form.content')</label> <span class="text-danger">*</span>
            <textarea id="content" name="content" class="form-control" rows="10" >{{ isset($product_category->content) ? replace_image($product_category->content) : old('content') }}</textarea>
            @if ($errors->has('content'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
            <div class="editor"></div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-6">
                <h3>Thuộc tính lọc</h3>
                <ul id="sortable1" class="connectedSortable">
                    @if(!empty($attributes))
                    @forelse($attributes as $item)
                        <li class="ui-state-default li_odd_bg" data-id="{{ $item->id }}">{{ $item->name }}</li>
                    @empty
                    @endforelse
                    @endif
                </ul>
            </div>
            <div class="col-md-6">
                <h3>Thuộc tính lọc đã chọn</h3>
                <ul id="sortable2" class="connectedSortable">
                    @if(!empty($attributes_choose))
                        @forelse($attributes_choose as $item)
                            <li class="ui-state-default li_odd_bg" data-id="{{ $item->id }}">{{ $item->name }}</li>
                        @empty
                        @endforelse
                    @endif
                </ul>
            </div>
            <input type="hidden" name="attribute_id" value="{{ isset($product_category->attribute_id) ? $product_category->attribute_id : old('attribute_id') }}">
        </div>
    </div>
</div>


@section('link')
    @parent
    <style>
        #sortable1, #sortable2 {
            border: 1px solid #eee;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
            width: 100%;
        }
        #sortable1 li, #sortable2 li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
        }
        h3{
            background-color: #ccc;
            padding: 10px;
        }
        .li_odd_bg:nth-child(odd) {
            background-color: #f1f1f1;
        }

    </style>
@endsection

@section('script')
    @parent
    <script src="{{ asset('ckeditor/ckeditor.js') }}?v=1.0"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    <script>
        CKEDITOR.replace( 'content' );
    </script>
    <script>
        $( function() {
            $( "#sortable1, #sortable2" ).sortable({
                connectWith: ".connectedSortable",
                update: function(event, ui) {
                    var attributeIds = [];
                    $("#sortable2 li").each(function() {
                        attributeIds.push($(this).data("id"));
                    });
                    $("input[name='attribute_id']").val(attributeIds.join(','));
                }
            }).disableSelection();
        } );
    </script>
@endsection
