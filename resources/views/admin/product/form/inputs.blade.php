<div class="row">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.product.title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="title" value="{{ isset($product) ? $product->title : old('title') }}" required>
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
                    <label>@lang('form.product.slug')</label> <span class="text-danger">(@lang('form.auto_slug'))</span>
                    <input type="text" class="form-control" name="slug" value="{{ isset($product) ? $product->slug : old('slug') }}">
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
                    <label>@lang('form.product.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Product::STATUS_ACTIVE }}" {{ (isset($product->active) && $product->active == \App\Models\Product::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Product::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Product::STATUS_INACTIVE }}" {{ (isset($product) && $product->active == \App\Models\Product::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Product::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
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
                    <label>@lang('form.product.is_home')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="homeRadio1" name="is_home" value="{{ \App\Models\Product::IS_HOME }}" {{ (isset($product->is_home) && $product->is_home == \App\Models\Product::IS_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Product::IS_HOME)) ? 'checked' : '' }}  required>
                            <label for="homeRadio1" class="custom-control-label">Có</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="homeRadio2" name="is_home" value="{{ \App\Models\Product::IS_NOT_HOME }}" {{ (isset($product) && $product->is_home == \App\Models\Product::IS_NOT_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Product::IS_NOT_HOME)) ? 'checked' : '' }}  required>
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
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.product.is_hot')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="is_hotRadio1" name="is_hot" value="{{ \App\Models\Product::IS_HOT }}" {{ (isset($product->is_hot) && $product->is_hot == \App\Models\product::IS_HOT) ? 'checked' : (old('is_hot') && (old('is_hot') == \App\Models\product::IS_HOT)) ? 'checked' : '' }}  required>
                            <label for="is_hotRadio1" class="custom-control-label">Có</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="is_hotRadio2" name="is_hot" value="{{ \App\Models\Product::IS_NOT_HOT }}" {{ (isset($product) && $product->is_hot == \App\Models\product::IS_NOT_HOT) ? 'checked' : (old('is_hot') && (old('is_hot') == \App\Models\product::IS_NOT_HOT)) ? 'checked' : '' }}  required>
                            <label for="is_hotRadio2" class="custom-control-label">Không</label>
                        </div>
                    </div>
                    @if ($errors->has('is_hot'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('is_hot') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.product.is_new')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="is_newRadio1" name="is_new" value="{{ \App\Models\Product::IS_NEW }}" {{ (isset($product->is_new) && $product->is_new == \App\Models\product::IS_NEW) ? 'checked' : (old('is_new') && (old('is_new') == \App\Models\product::IS_NEW)) ? 'checked' : '' }}  required>
                            <label for="is_newRadio1" class="custom-control-label">Có</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="is_newRadio2" name="is_new" value="{{ \App\Models\Product::IS_NOT_NEW }}" {{ (isset($product) && $product->is_new == \App\Models\product::IS_NOT_NEW) ? 'checked' : (old('is_new') && (old('is_new') == \App\Models\product::IS_NOT_NEW)) ? 'checked' : '' }}  required>
                            <label for="is_newRadio2" class="custom-control-label">Không</label>
                        </div>
                    </div>
                    @if ($errors->has('is_new'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('is_new') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.product.category')</label> <span class="text-danger">*</span>
                    <select name="category_id" id="category_id" class="form-control select2" required>
                        @forelse($categories as $key => $category)
                            <option value="{{ $category['id'] }}" {{ isset($product->category_id) && $product->category_id == $category['id'] ? 'selected' : old('category_id') == $category['id'] ? 'selected' : '' }}>{{ $category['title'] }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.product.image')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($product->image) ? replace_image($product->image) : old('image'),'name' => 'image'])
                        @if ($errors->has('image'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @if(!empty($attribute))
                <div class="col-sm-12">
                    <div class="row">
                        @forelse($attribute as $item)
                            @if($item->type == 'select')
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{ $item->name }}</label>
                                        <select name="{{ $item->code }}" id="{{ $item->code }}" class="form-control select2">
                                            <option value="" selected>--{{ $item->name }}--</option>
                                            @forelse($item->attributeValue as $key => $val)
                                                <option value="{{ $val->id }}" {{ isset($item->content) && $item->content['id'] == $val->id ? 'selected' : old($item->code) == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @if ($errors->has($item->code))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first($item->code) }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @empty
                        @endforelse
                    </div>
                </div>
            @endif
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.product.ordering')</label>
                    <input type="text" class="form-control" name="ordering" value="{{ isset($product) ? $product->ordering : old('ordering') }}" >
                    @if ($errors->has('ordering'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('ordering') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.product.video_url')</label>
                    <input type="text" class="form-control" name="video_url" value="{{ isset($product) ? $product->video_url : old('video_url') }}">
                    @if ($errors->has('video_url'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('video_url') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.product.canonical_url')</label>
                    <input type="text" class="form-control" name="canonical_url" value="{{ isset($product) ? $product->canonical_url : old('canonical_url') }}">
                    @if ($errors->has('canonical_url'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('canonical_url') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="div-list-products">
                <table class="table table-bordered mt-2 w-100" id="list_products" style="width: 100%">
                    <thead class="thead-light">
                    <tr>
                        <th >Tên sản phẩm</th>
                        <th >SKU</th>
                        <th >Giá vốn</th>
                        <th >Giá bán</th>
                        <th >Mặc định</th>
                        <th style="width: 50px;">#</th>
                    </tr>
                    </thead>
                    <tbody id="table-body">
                    @if(!empty($product_option))
                        @forelse($product_option as $k => $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ format_money($item->normal_price) }}</td>
                                <td>
                                    {{ format_money($item->price) }}
                                </td>
                                <td>
                                    @if($item->is_default == 1)
                                        <span class="badge badge-primary">MẶc định</span>
                                    @else
                                        <span class="badge badge-secondary">Không mẶc định</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" onclick="editProductOption({{ $item->id }})" class="btn btn-warning mb-2" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-edit"></i></button>
                                    <button type="button" onclick="deleteProductOption({{ $item->id }})" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    @endif
                    </tbody>
                </table>
                <button class="btn btn-warning mb-4" onclick="addProductOption()" type="button" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus"></i>Thêm sản phẩm phụ</button>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="card card-warning">
            <div class="card-header" style="background-color: #ccc;">
                <h3 class="card-title">SEO</h3>
            </div>
            <div class="card-body p-3" style="background-color: #f1f1f1;">
                <div class="form-group">
                    <label>@lang('form.seo_title')</label>
                    <input type="text" class="form-control" name="seo_title" value="{{ isset($product) ? $product->seo_title : old('seo_title') }}" >
                    @if ($errors->has('seo_title'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_keyword')</label>
                    <input type="text" class="form-control" name="seo_keyword" value="{{ isset($product) ? $product->seo_keyword : old('seo_keyword') }}" >
                    @if ($errors->has('seo_keyword'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_keyword') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_description')</label>
                    <textarea class="form-control" rows="3" name="seo_description" >{{ isset($product) ? $product->seo_description : old('seo_description') }}</textarea>
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
            <label>@lang('form.description')</label> <span class="text-danger">*</span>
            <textarea id="description" name="description" class="form-control" rows="10" >{{ isset($product->description) ? replace_image($product->description) : old('description') }}</textarea>
            @if ($errors->has('description'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>
    @if(!empty($attribute))
        @forelse($attribute as $item)
            @if($item->type == 'ckeditor')
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>{{ $item->name }}</label>
                        <textarea id="{{ $item->code }}" name="{{ $item->code }}" class="form-control" rows="10" >{{ isset($item->content) ? replace_image($item->content['content']) : old($item->code) }}</textarea>
                        @if ($errors->has($item->code))
                            <span class="help-block text-danger">
                                 <strong>{{ $errors->first($item->code) }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
            @endif
        @empty
        @endforelse
    @endif
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Sản phẩm phụ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="form-product-option"></div>
        </div>
    </div>
</div>
