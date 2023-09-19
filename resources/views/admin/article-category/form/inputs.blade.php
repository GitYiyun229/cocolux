<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.article_category.title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="title" value="{{ isset($article_category) ? $article_category->title : old('title') }}" required>
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
                    <label>@lang('form.article_category.slug')</label> <span class="text-danger">(@lang('form.auto_slug'))</span>
                    <input type="text" class="form-control" name="slug" value="{{ isset($article_category) ? $article_category->slug : old('slug') }}">
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
                    <label>@lang('form.article_category.image')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($article_category->image) ? $article_category->image : old('image'),'name' => 'image'])
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
                <div class="form-group clearfix">
                    <label>@lang('form.article_category.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="activeRadio1" name="active" value="{{ \App\Models\ArticlesCategories::STATUS_ACTIVE }}" {{ isset($article_category) && $article_category->active == \App\Models\ArticlesCategories::STATUS_ACTIVE ? 'checked' : (old('active') && (old('active') == \App\Models\ArticlesCategories::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="activeRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="activeRadio2" name="active" value="{{ \App\Models\ArticlesCategories::STATUS_INACTIVE }}" {{ isset($article_category) && $article_category->active == \App\Models\ArticlesCategories::STATUS_INACTIVE ? 'checked' : (old('active') && (old('active') === \App\Models\ArticlesCategories::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
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
                    <label>@lang('form.article_category.type')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="typeRadio1" name="type" value="{{ \App\Models\ArticlesCategories::TYPE_ARTICLE }}" {{ isset($article_category) && $article_category->type == \App\Models\ArticlesCategories::TYPE_ARTICLE ? 'checked' : (old('type') && (old('type') == \App\Models\ArticlesCategories::TYPE_ARTICLE)) ? 'checked' : '' }}  required>
                            <label for="typeRadio1" class="custom-control-label">Tin tức   </label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="typeRadio2" name="type" value="{{ \App\Models\ArticlesCategories::TYPE_PROMOTION }}" {{ isset($article_category) && $article_category->type == \App\Models\ArticlesCategories::TYPE_PROMOTION ? 'checked' : (old('type') && (old('type') === \App\Models\ArticlesCategories::TYPE_PROMOTION)) ? 'checked' : '' }}  required>
                            <label for="typeRadio2" class="custom-control-label">Ưu đãi</label>
                        </div>
                    </div>
                    @if ($errors->has('type'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">SEO</h3>
            </div>
            <div class="card-body p-3">
                <div class="form-group">
                    <label>@lang('form.seo_title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="seo_title" value="{{ isset($article_category) ? $article_category->seo_title : old('seo_title') }}" >
                    @if ($errors->has('seo_title'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_keyword')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="seo_keyword" value="{{ isset($article_category) ? $article_category->seo_keyword : old('seo_keyword') }}" >
                    @if ($errors->has('seo_keyword'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_keyword') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_description')</label> <span class="text-danger">*</span>
                    <textarea class="form-control" rows="3" name="seo_description" >{{ isset($article_category) ? $article_category->seo_description : old('seo_description') }}</textarea>
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

@section('script')
    @parent
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
@endsection
