<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-md-6">
                @if(isset($menu_category))
                    @include('admin.components.buttons.change_lang',['url'=> route('admin.menu-category.edit',['id'=>$menu_category->id])])
                @else
                    @include('admin.components.buttons.change_lang',['url'=> route('admin.menu-category.create')])
                @endif
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.menu_category.name')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="name" value="{{ isset($menu_category) ? $menu_category->translations->first()->name : old('name') }}" required>
                    @if ($errors->has('name'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6"></div>
</div>


