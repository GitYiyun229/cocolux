<form action="">
    <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Thông tin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="stores-tab" data-toggle="tab" href="#stores" role="tab" aria-controls="stores" aria-selected="false">Tồn kho</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group d-flex align-items-center">
                            <label class="col-md-4 font-weight-bold small p-0 m-0"> Mã hàng </label>
                            <input type="text" name="sku" class="form-control" id="sku-product-option" value="{{ isset($product_option)?$product_option->sku:'' }}">
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <label class="col-md-4 font-weight-bold small p-0 m-0"> Barcode </label>
                            <input type="text" name="barcode" class="form-control" id="barcode-product-option" value="{{ isset($product_option)?$product_option->barcode:'' }}">
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <label class="col-md-4 font-weight-bold small p-0 m-0"> Tên phân loại </label>
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
                            <input type="text" name="stock" class="form-control" id="stock-product-option" value="{{ isset($count_stock)?$count_stock:0 }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group d-flex align-items-center">
                            <label class="col-md-3 font-weight-bold small p-0 m-0" style="max-width: 157px;">
                                Đường dẫn (Slug)
                            </label>
                            <input type="text" name="slug" class="form-control" id="slug-product-option" value="{{ isset($product_option)?$product_option->slug:'' }}" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="stores" role="tabpanel" aria-labelledby="stores-tab">
                <table class="table table-bordered mt-2" id="list_products">
                    <thead class="thead-light">
                    <tr>
                        <th style="width: 280px;">STT</th>
                        <th style="width: 280px;">Chi nhánh</th>
                        <th style="width: 100px;">Tổng tồn</th>
                        <th style="width: 100px;">Khách đặt</th>
                        <th style="width: 100px;">Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody id="table-body">
                    @if(!empty($stores))
                        @forelse($stores as $k => $item)
                            <tr>
                                <td>{{ $k }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ format_money($item->original_price) }}</td>
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
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
</form>
