<form action="{{ !empty($link_submit)?$link_submit:'' }}" id="form_product_option" method="post">
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
            <div class="tab-pane fade show active p-3" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                    <div class="col-md-12">
                        <button id="ckfinder-modal" type="button" class="button-a button-a-background" style="float: left">Open Modal</button>
                        <div id="sortable-container">
                            @if(!empty($images))
                                @forelse($images as $item)
                                    <span class="mr-2 mb-3" style="width: 200px;">
                                        <img src="{{ asset($item) }}" class="img-responsive mr-2" style="width: 50px;">
                                        <button class="delete-btn" type="button">Xóa</button>
                                    </span>
                                @empty
                                @endforelse
                            @endif
                        </div>
                        <input type="hidden" name="sortedIds" id="sortedIdsInput" value="">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="stores" role="tabpanel" aria-labelledby="stores-tab">
                <table class="table table-bordered mt-2 card-body table-responsive p-0" id="list_products" style="height: 300px;">
                    <thead class="thead-light">
                    <tr>
                        <th style="width: 280px;">STT</th>
                        <th style="width: 280px;">Chi nhánh</th>
                        <th style="width: 100px;">Tổng tồn</th>
                        <th style="width: 100px;">Khách đặt</th>
                        <th style="width: 200px;">Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody id="table-body">
                    @if(!empty($stores))
                        @forelse($stores as $k => $item)
                            <tr>
                                <td>{{ $k }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ !empty($item->number)?$item->number['total_quantity']:0 }}</td>
                                <td>{{ !empty($item->number)?$item->number['total_order_quantity']:0 }}</td>
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
</form>
{{--<script src="{{ asset('ckfinder/ckfinder.js') }}"></script>--}}
{{--<script>--}}
{{--    const buttonModal = document.getElementById( '#form-product-option #ckfinder-modal' );--}}
{{--    buttonModal.onclick = function() {--}}
{{--        CKFinder.modal( {--}}
{{--            chooseFiles: true,--}}
{{--            width: 800,--}}
{{--            height: 600,--}}
{{--            onInit: function( finder ) {--}}
{{--                finder.on( 'files:choose', function( evt ) {--}}
{{--                    const files = evt.data.files;--}}
{{--                    files.forEach( function( file, i ) {--}}
{{--                        const name = file.get( 'name' );--}}
{{--                        const fileroot = file.getUrl();--}}
{{--                        const divElement = document.createElement('span');--}}
{{--                        divElement.classList.add('mr-2');--}}
{{--                        divElement.classList.add('mb-3');--}}
{{--                        divElement.style.width = '200px';--}}
{{--                        divElement.innerHTML = `--}}
{{--                                <img src="${fileroot}" class="img-responsive mr-2" style="width: 200px;">--}}
{{--                                <span>${name}</span>--}}
{{--                                <button class="delete-btn" type="button">Xóa</button>--}}
{{--                            `;--}}

{{--                        sortableContainer.appendChild(divElement);--}}
{{--                        const imageElements = sortableContainer.querySelectorAll('img');--}}
{{--                        const imageLinks = Array.from(imageElements).map((image) => image.src.replace(/^.*\/\/[^/]+/, ''));--}}
{{--                        sortedIdsInput.value = imageLinks.join(',');--}}
{{--                    });--}}
{{--                } );--}}

{{--                finder.on( 'file:choose:resizedImage', function( evt ) {--}}
{{--                    const file = evt.data.resizedUrl;--}}
{{--                    const name = file.get( 'name' );--}}
{{--                    const divElement = document.createElement('span');--}}
{{--                    divElement.classList.add('mr-2');--}}
{{--                    divElement.classList.add('mb-3');--}}
{{--                    divElement.style.width = '200px';--}}
{{--                    divElement.innerHTML = `--}}
{{--                            <img src="${file}" class="img-responsive mr-2" style="width: 200px;">--}}
{{--                            <span>${name}</span>--}}
{{--                            <button class="delete-btn" type="button">Xóa</button>--}}
{{--                        `;--}}
{{--                    sortableContainer.appendChild(divElement);--}}
{{--                    const imageElements = sortableContainer.querySelectorAll('img');--}}
{{--                    const imageLinks = Array.from(imageElements).map((image) => image.src.replace(/^.*\/\/[^/]+/, ''));--}}
{{--                    sortedIdsInput.value = imageLinks.join(',');--}}
{{--                } );--}}
{{--            }--}}
{{--        } );--}}
{{--    };--}}
{{--</script>--}}
