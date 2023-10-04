@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <div class="layout-page-checkout mt-4 mb-5">
                <div class="page-title mb-2 fw-bold">Giỏ hàng ({{ getCart() }} sản phẩm)</div>

                <div class="table-container">
                    <table class="page-table table table-hover mb-4">
                        <thead>
                        <tr class="fw-bold">
                            <th></th>
                            <th>Sản phẩm</th>
                            <th>Giá sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($cartItems as $item)
                        <tr>
                            <td>
                                <img src="{{ $item['image'][0] }}" alt="{{ $item['product']->title }}" class="img-fluid">
                            </td>
                            <td class="fw-bold">
                                {{ $item['product']->title }}
                            </td>
                            <td>
                                <div class="public-price">{{ format_money($item['product']->price) }}</div>
                            </td>
                            <td>
                                <input type="number" min="1" name="quantity[]" class="form-control" value="{{ $item['quantity'] }}">
                            </td>
                            <td>
                                {{ format_money($item['subtotal']) }}
                            </td>
                            <td>
                                <a href="{{ route('removeItem',['id'=>$item["product"]->id]) }}">Xóa</a>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        <tr>
                            <td colspan="6">
                                <i class="fa-solid fa-truck-fast me-2"></i> Miễn phí vận chuyển toàn quốc cho đơn hàng từ 3 sản phẩm (99k/SP)
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="page-confirm d-flex justify-content-end">
                    <div class="item-confirm pe-4 text-end fw-bold">
                        <p class="mb-0">Tổng tiền hàng ({{ getCart() }} sản phẩm)</p>
                        <p class="mb-0 text-danger">{{ format_money($total_price) }}</p>
                        <p class="mb-0">Nhận thêm: 5892 COCO COIN</p>
                    </div>
                    <div class="item-confirm">
                        <a href="{{ route('payment') }}">Tiến hành đặt hàng</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/cart-checkout.css') }}">
@endsection

@section('script')
    @parent
    <script>
        function removeItemCart(id_prd) {
            var quantity = $("#quantity").val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{{ route('addToCart') }}',
                data: {
                    quantity: quantity,
                    id: id_prd,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function (data) {
                    console.log(data);
                    $("#number-added-cart").html(data.total);
                }
            });
        }
        $(document).ready(function(){
            $(".number-input").focusout(function(){
                var id_prd = $(this).data('id');
                var quantity = $('#quantity-'+id_prd).val();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '{{ route('updateCart') }}',
                    data: {
                        quantity: quantity?quantity:1,
                        id: id_prd,
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (data) {
                        $("#number-added-cart").html(data.total);
                    }
                });
            });
        });
    </script>
@endsection
