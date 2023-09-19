<div class="row">
{{--    đánh dấu loại tin tức--}}
    <input type="hidden" value="0" name="type" id="type">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.article.title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="title" value="{{ isset($article) ? $article->title : old('title') }}" required>
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
                    <label>@lang('form.article.slug')</label> <span class="text-danger">(@lang('form.auto_slug'))</span>
                    <input type="text" class="form-control" name="slug" value="{{ isset($article) ? $article->slug : old('slug') }}">
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
                    <label>@lang('form.article.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Article::STATUS_ACTIVE }}" {{ (isset($article->active) && $article->active == \App\Models\Article::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Article::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Article::STATUS_INACTIVE }}" {{ (isset($article) && $article->active == \App\Models\Article::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Article::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
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
                            <input class="" type="radio" id="homeRadio1" name="is_home" value="{{ \App\Models\Article::IS_HOME }}" {{ (isset($article->is_home) && $article->is_home == \App\Models\Article::IS_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Article::IS_HOME)) ? 'checked' : '' }}  required>
                            <label for="homeRadio1" class="custom-control-label">@lang('form.status.is_home')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="homeRadio2" name="is_home" value="{{ \App\Models\Article::IS_NOT_HOME }}" {{ (isset($article) && $article->is_home == \App\Models\Article::IS_NOT_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Article::IS_NOT_HOME)) ? 'checked' : '' }}  required>
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
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.article.category')</label> <span class="text-danger">*</span>
                    <select name="category_id" id="category_id" class="form-control" required>
                        @forelse($categories as $key => $category)
                            <option value="{{ $category['id'] }}" {{ isset($article->category_id) && $article->category_id == $category['id'] ? 'selected' : old('category_id') == $category['id'] ? 'selected' : '' }}>{{ $category['title'] }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.article.image')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($article->image) ? $article->image : old('image'),'name' => 'image'])
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
                    <label>@lang('form.article.ordering')</label>
                    <input type="text" class="form-control" name="ordering" value="{{ isset($article) ? $article->ordering : old('ordering') }}" >
                    @if ($errors->has('ordering'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('ordering') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>@lang('form.description')</label> <span class="text-danger">*</span>
                    <textarea class="form-control" rows="3" name="description" required >{{ isset($article) ? $article->description : old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>@lang('form.content')</label> <span class="text-danger">*</span>
                    <textarea id="content" name="content" class="form-control" rows="10" >{{ isset($article->content) ? $article->content : old('content') }}</textarea>
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
                    <input type="text" class="form-control" name="seo_title" value="{{ isset($article) ? $article->seo_title : old('seo_title') }}" >
                    @if ($errors->has('seo_title'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_keyword')</label>
                    <input type="text" class="form-control" name="seo_keyword" value="{{ isset($article) ? $article->seo_keyword : old('seo_keyword') }}" >
                    @if ($errors->has('seo_keyword'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_keyword') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_description')</label>
                    <textarea class="form-control" rows="3" name="seo_description" >{{ isset($article) ? $article->seo_description : old('seo_description') }}</textarea>
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
    <script src="{{ asset('ckeditor5/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    <script>
        InlineEditor
            .create( document.querySelector( '#content' ),{
                ckfinder: {
                    uploadUrl: '{!! asset('ckfinder/core/connector/php/connector.php').'?command=QuickUpload&type=Images&responseType=json' !!}',
                    options: {
                        resourceType: 'Images'
                    }
                },
                mediaEmbed: {previewsInData: true}
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
