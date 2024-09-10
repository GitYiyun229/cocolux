<div class="modal fade" id="createProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Thêm sản phẩm mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="form-product">
                <div class="modal-body">
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                                <!-- text input -->
                                <div class="form-group clearfix">
                                    <label>@lang('form.product.active')</label> <span class="text-danger">*</span>
                                    <div class="form-group">
                                        <div class="icheck-success d-inline">
                                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Product::STATUS_ACTIVE }}" {{ (isset($product->active) && $product->active == \App\Models\product::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\product::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        </div>
                                        <div class="icheck-danger d-inline">
                                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Product::STATUS_INACTIVE }}" {{ (isset($product) && $product->active == \App\Models\product::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\product::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
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
                        </div>
                        <button type="submit" class="btn btn-primary">@lang('form.button.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
