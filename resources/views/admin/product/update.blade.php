@extends('admin.layouts.admin')

@section('title_file', trans('form.product.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.product.update', $product->id) }}" id="form-product" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.product.form.inputs')
            <input type="hidden" name="id" value="{{ $product->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
    <script src="{{ asset('ckeditor/ckeditor.js') }}?v=1.0"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}?v=1.0"></script>
    <script src="{{ asset('js/admin/Sortable.js') }}"></script>
    <script>
        CKEDITOR.replace( 'description' );
        @if(!empty($attribute))
        @forelse($attribute as $item)
        @if($item->type == 'ckeditor')
        CKEDITOR.replace("{{ $item->code }}");
        @endif
        @empty
        @endforelse
        @endif
    </script>
    <script>
        function editProductOption(id_product) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product-option.edit') }}",
                data: {id: id_product, _token: $('meta[name="csrf-token"]').attr("content")},
                success: function(data) {
                    $("#form-product-option").html(data);
                    initializeSortable();
                    deleteImages();
                    uploadImagesCk();
                }
            });
        }

        function initializeSortable() {
            var sortableContainer = $('#form-product-option #sortable-container');

            new Sortable(sortableContainer[0], {
                animation: 150,
                handle: 'img',
                onEnd: function (/**Event*/evt) {
                    var imageElements = sortableContainer.find('img');
                    var imageLinks = imageElements.map(function () {
                        return this.src.replace(/^.*\/\/[^/]+/, '');
                    }).get();
                    $('#sortedIdsInput').val(imageLinks.join(','));
                }
            });
        }

        function deleteImages() {
            $('#form-product-option .delete-btn').on('click', function() {
                var confirmed = confirm('Bạn có chắc chắn muốn xóa?');

                if (confirmed) {
                    $(this).parent().remove();
                    var imageElements = $('#sortable-container img');
                    var imageLinks = imageElements.map(function() {
                        return this.src.replace(/^.*\/\/[^/]+/, '');
                    }).get();
                    $('#sortedIdsInput').val(imageLinks.join(','));
                }
            });
        }

        function uploadImagesCk() {
            const sortableContainer = document.getElementById('sortable-container');
            $('#form-product-option #ckfinder-modal').on('click', function() {
                CKFinder.modal({
                    chooseFiles: true,
                    width: 800,
                    height: 600,
                    onInit: function(finder) {
                        finder.on('files:choose', function(evt) {
                            const files = evt.data.files;
                            files.forEach( function( file, i ) {
                                const fileroot = file.getUrl();
                                const divElement = document.createElement('span');
                                divElement.classList.add('mr-2');
                                divElement.classList.add('mb-3');
                                divElement.style.width = '200px';
                                divElement.innerHTML = `
                                    <img src="${fileroot}" class="img-responsive mr-2" style="width: 50px;">
                                    <button class="delete-btn" type="button">Xóa</button>
                                `;
                                sortableContainer.appendChild(divElement);
                            });
                            updateSortedIdsInput();
                            deleteImages();
                        });

                        finder.on('file:choose:resizedImage', function(evt) {
                            const files = evt.data.resizedUrl;
                            files.forEach( function( file, i ) {
                                const fileroot = file.getUrl();
                                const divElement = document.createElement('span');
                                divElement.classList.add('mr-2');
                                divElement.classList.add('mb-3');
                                divElement.style.width = '200px';
                                divElement.innerHTML = `
                                    <img src="${fileroot}" class="img-responsive mr-2" style="width: 50px;">
                                    <button class="delete-btn" type="button">Xóa</button>
                                `;
                                sortableContainer.appendChild(divElement);
                            });
                            updateSortedIdsInput();
                            deleteImages();
                        });
                    }
                });
            });
        }

        function updateSortedIdsInput() {
            const imageElements = $('#sortable-container img');
            const imageLinks = imageElements.map(function() {
                return this.src.replace(/^.*\/\/[^/]+/, '');
            }).get();
            $('#sortedIdsInput').val(imageLinks.join(','));
        }

        function deleteProductOption(id_product) {
            swal({
                title: 'Xóa bản ghi?',
                text: "Bạn có chắc chắn muốn xóa!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (result) {
                if (result.value == true) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.product-option.destroy') }}",
                        data: {id: id_product, _token: $('meta[name="csrf-token"]').attr("content")},
                        success: function (result) {
                            if (result.status === true) {
                                toastr["success"](result.message);
                                window.location.reload();
                            }

                            if (result.status === false) {
                                toastr["error"](result.message);
                            }
                        }
                    });
                }
            }, function (dismiss) {
                return false;
            });
        }

        function addProductOption() {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product-option.create',['id_parent' => $product->id]) }}",
                data: {_token: $('meta[name="csrf-token"]').attr("content")},
                success: function(data) {
                    $("#form-product-option").html(data);
                    initializeSortable();
                    deleteImages();
                    uploadImagesCk();
                }
            });
        }

        function checkSku() {
            var sku = $('#form-product-option #sku-product-option').val();
            if(sku){
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.product-option.checkSku') }}",
                    data: {
                        sku: sku,
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (result) {
                        if (result.status === true) {
                            toastr["success"](result.message);
                        }

                        if (result.status === false) {
                            toastr["error"](result.message);
                        }
                    }
                });
            }else{
                toastr["error"]("Bạn cần nhập mã sku");
            }

        }

        function submitFormOption(id_product) {

            $.ajax({
                type: "POST",
                url: $('#form-product-option #form_product_option').val(),
                data: {
                    id: id_product,
                    sku: $('#form-product-option #sku-product-option').val(),
                    barcode: $('#form-product-option #barcode-product-option').val(),
                    name: $('#form-product-option #name-product-option').val(),
                    price: $('#form-product-option #price-product-option').val(),
                    normal_price: $('#form-product-option #normal_price-product-option').val(),
                    stock: $('#form-product-option input[name="store[]"]').map(function(){
                        return $(this).data('id')+':'+$(this).val()+':'+$(this).data('id-stock');
                    }).get(),
                    slug: $('#form-product-option #slug-product-option').val(),
                    parent_id: $('#form-product-option #id_product_parent').val(),
                    active: $('#form-product-option input[name="active"]:checked').val(),
                    is_default: $('#form-product-option input[name="is_default"]:checked').val(),
                    sortedIds: $('#form-product-option #sortedIdsInput').val(),
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function(result) {
                    if (result.status === true) {
                        toastr["success"](result.message);
                        $("form#form-product").submit();
                        // window.location.reload();
                    }

                    if (result.status === false) {
                        toastr["error"](result.message);
                    }
                }
            });
        }

    </script>
@endsection
