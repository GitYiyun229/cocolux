<div class="modal-body">
    <input type="hidden" name="form_product_option" id="form_product_option" value="{{ !empty($link_submit)?$link_submit:'' }}">
    <input type="hidden" name="id_product_parent" id="id_product_parent" value="{{ isset($product_parent)?$product_parent:'' }}">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Thông tin</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="stores-tab" data-toggle="tab" href="#stores" role="tab" aria-controls="stores" aria-selected="false">Tồn kho</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active p-3" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">

                <div class="col-sm-6">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-md-4 font-weight-bold small p-0 m-0"> Mã hàng sku: </label>
                        <input type="text" name="sku" class="form-control" id="sku-product-option" value="{{ isset($product_option)?$product_option->sku:'' }}">
                        <button type="button" class="btn btn-warning" onclick="checkSku()">Check</button>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-md-4 font-weight-bold small p-0 m-0"> Barcode: </label>
                        <input type="text" name="barcode" class="form-control" id="barcode-product-option" value="{{ isset($product_option)?$product_option->barcode:'' }}">
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-md-4 font-weight-bold small p-0 m-0"> Tên phân loại: </label>
                        <input type="text" name="name" class="form-control" id="name-product-option" value="{{ isset($product_option)?$product_option->title:'' }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-md-4 font-weight-bold small p-0 m-0"> Giá bán: </label>
                        <input type="text" name="price" class="form-control" id="price-product-option" value="{{ isset($product_option)?$product_option->price:'' }}">
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-md-4 font-weight-bold small p-0 m-0"> Giá vốn: </label>
                        <input type="text" name="normal_price" class="form-control" id="normal_price-product-option" value="{{ isset($product_option)?$product_option->normal_price:'' }}">
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-md-4 font-weight-bold small p-0 m-0"> Tồn kho </label>
                        <input type="text" name="stock" disabled class="form-control" id="stock-product-option" value="{{ isset($count_stock)?$count_stock:0 }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group clearfix">
                        <label>Trạng thái</label> <span class="text-danger">*</span>
                        <div class="form-group">
                            <div class="icheck-success d-inline">
                                <input class="" type="radio" id="statusOptionRadio1" name="active" value="{{ \App\Models\ProductOptions::STATUS_ACTIVE }}" {{ (isset($product_option->active) && $product_option->active == \App\Models\ProductOptions::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\ProductOptions::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                                <label for="statusOptionRadio1" class="custom-control-label">Hoạt động</label>
                            </div>
                            <div class="icheck-danger d-inline">
                                <input class="" type="radio" id="statusOptionRadio2" name="active" value="{{ \App\Models\ProductOptions::STATUS_INACTIVE }}" {{ (isset($product_option) && $product_option->active == \App\Models\ProductOptions::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\ProductOptions::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
                                <label for="statusOptionRadio2" class="custom-control-label">Không hoạt động</label>
                            </div>
                        </div>
                        @if ($errors->has('active'))
                            <span class="help-block text-danger">
                                    <strong>{{ $errors->first('active') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group clearfix">
                        <label>Mặc định</label>
                        <div class="form-group">
                            <div class="icheck-success d-inline">
                                <input class="" type="radio" id="is_defaultOptionRadio1" name="is_default" value="{{ \App\Models\ProductOptions::IS_DEFAULT }}" {{ (isset($product_option->is_default) && $product_option->is_default == \App\Models\ProductOptions::IS_DEFAULT) ? 'checked' : (old('is_default') && (old('is_default') == \App\Models\ProductOptions::IS_DEFAULT)) ? 'checked' : '' }}  required>
                                <label for="is_defaultOptionRadio1" class="custom-control-label">Có</label>
                            </div>
                            <div class="icheck-danger d-inline">
                                <input class="" type="radio" id="is_defaultOptionRadio2" name="is_default" value="{{ \App\Models\ProductOptions::IS_NOT_DEFAULT }}" {{ (isset($product_option) && $product_option->is_default == \App\Models\ProductOptions::IS_NOT_DEFAULT) ? 'checked' : (old('is_default') && (old('is_default') == \App\Models\ProductOptions::IS_NOT_DEFAULT)) ? 'checked' : '' }}  required>
                                <label for="is_defaultOptionRadio2" class="custom-control-label">Không</label>
                            </div>
                        </div>
                        @if ($errors->has('is_default'))
                            <span class="help-block text-danger">
                                    <strong>{{ $errors->first('is_default') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-md-3 font-weight-bold small p-0 m-0" style="max-width: 157px;">
                            Đường dẫn (Slug)
                            <p class="text-danger">(@lang('form.auto_slug'))</p>
                        </label>
                        <input type="text" name="slug" class="form-control" id="slug-product-option" value="{{ isset($product_option)?$product_option->slug:'' }}" >
                    </div>
                </div>
                <div class="col-md-12">
                    <button id="ckfinder-modal" type="button" class="btn btn-success button-a button-a-background" style="float: left">UpLoad</button>
                    <div id="sortable-container">
                        @if(!empty($images))
                            @forelse($images as $item)
                                <span class="mr-2 mb-3" style="width: 200px;">
                                        <img src="{{ asset(replace_image($item)) }}" class="img-responsive mr-2" style="width: 50px;">
                                        <button class="delete-btn" type="button">Xóa</button>
                                    </span>
                            @empty
                            @endforelse
                        @endif
                    </div>
                    <input type="hidden" name="sortedIds" id="sortedIdsInput" value="{{ (!empty($images))?replace_image(implode(',',$images)):'' }}">
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="stores" role="tabpanel" aria-labelledby="stores-tab">
            <table class="table table-bordered mt-2 card-body table-responsive p-0" id="list_products" style="height: 300px;">
                <thead class="thead-light">
                <tr>
                    <th style="width: 50px;">STT</th>
                    <th style="width: 280px;">Chi nhánh</th>
                    <th style="width: 100px;">Tổng tồn</th>
                    <th style="width: 200px;">Trạng thái</th>
                </tr>
                </thead>
                <tbody id="table-body">
                @if(!empty($stores))
                    @forelse($stores as $k => $item)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td><input type="text" name="store[]" data-id="{{ !empty($item->id)?$item->id:0 }}" data-id-stock="{{ !empty($item->number)?$item->number['id_stock']:0 }}" value="{{ !empty($item->number)?$item->number['total_quantity']:0 }}" class="form-control"></td>
                            <td>
                                @if($item->active == 1)
                                    Đang hoạt động
                                @else
                                    Không hoạt động
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" form="form_product_option" class="btn btn-primary" onclick="submitFormOption({{ isset($product_option)?$product_option->id:'' }})">Save changes</button>
</div>
