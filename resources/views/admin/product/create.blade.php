@extends('admin.layouts.admin')

@section('title_file', trans('form.product.create'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.product.form.inputs')
            <button type="submit" class="btn btn-primary">@lang('form.button.submit')</button>
        </form>
        {{--        <button id="ckfinder-popup" class="button-a button-a-background" style="float: left">Open Popup</button> --}}
    </div>
@endsection

@section('script')
    @parent
    <script src="{{ asset('ckeditor/ckeditor.js') }}?v=1.0"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}?v=1.0"></script>
    <script src="{{ asset('js/select2.js') }}?v=1.0"></script>
    <script>
        CKEDITOR.replace('description');
        @if (!empty($attribute))
            @forelse($attribute as $item)
                @if ($item->type == 'ckeditor')
                    CKEDITOR.replace("{{ $item->code }}");
                @endif
            @empty
            @endforelse
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                // Các tùy chọn Select2 ở đây
            });
        });
    </script>


    <script>


        function editProductOption(id_product) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product-option.edit') }}",
                data: {
                    id: id_product,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    $("#form-product-option").html(data);
                }
            });
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
            }).then(function(result) {
                if (result.value == true) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.product-option.destroy') }}",
                        data: {
                            id: id_product,
                            _token: $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function(result) {
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
            }, function(dismiss) {
                return false;
            });
        }

        function addProductOption() {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product-option.create', ['id_parent' => !empty($product) ? $product->id : 0]) }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    $("#form-product-option").html(data);
                }
            });
        }

        function checkSku() {
            var sku = $('#form-product-option #sku-product-option').val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.product-option.checkSku') }}",
                data: {
                    sku: sku,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function(result) {
                    if (result.status === true) {
                        toastr["success"](result.message);
                    }

                    if (result.status === false) {
                        toastr["error"](result.message);
                    }
                }
            });
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
                    stock: $('#form-product-option input[name="store[]"]').map(function() {
                        return $(this).data('id') + ':' + $(this).val() + ':' + $(this).data('id-stock');
                    }).get(),
                    slug: $('#form-product-option #slug-product-option').val(),
                    parent_id: $('#form-product-option #id_product_parent').val(),
                    active: $('#form-product-option input[name="active"]:checked').val(),
                    is_default: $('#form-product-option input[name="is_default"]:checked').val(),
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function(result) {
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
    </script>
@endsection
