@extends('web.layouts.web')

@section('content')
<main>

    <div class="container">
        <div class="layout-page-payment-success mt-4 mb-4 ">
            <div class='order-detail-title'>
                Chi tiết đơn hàng:
                <span> {{ $maDonHang }}</span>
                <span> -
                    @forelse( \App\Models\Order::STATUS as $key => $name)
                    {{ isset($order->status) && $order->status == $key ? $name : '' }}
                    @empty
                    @endforelse
                </span>
            </div>
            <div class='order-detail-time mb-3'>
                Ngày đặt hàng: {{ $order->created_at }}
            </div>
            <div class='content-detail'>
                <table class='ccs-table account-table order-detail-table table'>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Giảm giá</th>
                            <th>Tạm tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($products))
                        @forelse($products as $k => $item)
                        <tr key={{ $k }}>
                            <td class='item-product'>
                                <div class='ccs-cart-product p-2'>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <a href="{{ route('detailProduct',['slug' => $item->productOption->slug,'sku'=>$item->productOption->sku]) }}" class="ccs-cart-product--thumb">
                                                <img src="{{ asset($item->productOption->image_first) }}" alt="{{ $item->product_title }}" class="img-fluid" />
                                            </a>
                                        </div>
                                        <div class="col-md-7">
                                            <div class='ccs-cart-product--body'>
                                                <div class='ccs-cart-product--body__subtitle' title="{{ $item->product_title }}">
                                                    {{ $item->product_title }}
                                                </div>
                                                <div class='product-body-custom'>
                                                    <div class='group-buttons'>
                                                        <a class='btn btn-light btn-outline-danger' href="{{ route('detailProduct',['slug' => $item->productOption->slug,'sku'=>$item->productOption->sku]) }}">
                                                            Mua lại
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class='compare-price'>
                                    @if($item->productOption->normal_price)
                                    <span class='original-price'>{{ format_money($item->productOption->normal_price) }}</span>
                                    @endif
                                    <span>{{ format_money($item->product_price) }}</span>
                                </div>
                            </td>
                            <td>
                                <span>{{ $item->product_number }}</span>
                            </td>
                            <td>
                                <span>
                                    @if($item->productOption->normal_price)
                                    {{ format_money($item->productOption->normal_price - $item->product_price) }}
                                    @else
                                    0
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span>{{ format_money($item->product_price * $item->product_number) }}</span>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        @endif
                    </tbody>
                </table>
                <div class='order-summary bg-white'>
                    <div class='order-detail'>
                        <div class='item'>
                            <span>Tạm tính:</span>
                            <span>{{ format_money($total_money) }}</span>
                        </div>
                        <div class='item'>
                            <span>Phí vận chuyển:</span>
                            <span>{{ $order->price_ship_coco?format_money($order->price_ship_coco):0 }}</span>
                        </div>
                        @if($order->coupon && $order->price_coupon_now)
                        <div class='item'>
                            <span>Giảm giá:</span>
                            <span>(Mã áp dụng: {{ $order->coupon }}) - {{ $order->price_coupon_now?format_money($order->price_coupon_now):0 }}</span>
                        </div>
                        @endif
                        <div class='item'>
                            <span>Tổng cộng:</span>
                            <span>{{ format_money($total_money + $order->price_ship_coco - $order->price_coupon_now) }}</span>
                        </div>
                        {{-- <div class='item'>--}}
                        {{-- <span>Cần thanh toán:</span>--}}
                        {{-- <span>{{ format_money($total_money + $order->price_ship_coco - $order->price_coupon_now) }}</span>--}}
                        {{-- </div>--}}
                    </div>
                </div>
            </div>
            <div class='order-detail-info'>
                <div class='title'>
                    Thông tin đơn hàng
                </div>
                <div class='order-information bg-white p-3'>
                    <!-- <div class='block-left'>
                            <div class='order-title'>Địa chỉ nhận hàng</div>
                            <div class='order-address'>
                                <span>Địa chỉ: {{ $order->address }},{{ $order->ward_name }},{{ $order->district_name }},{{ $order->city_name }}</span>
                                <span>Điện thoại: 0{{ $order->tel }}</span>
                            </div>
                        </div> -->
                    <div class='block-right'>
                        <div class="d-none">
                            <span class='highlight'>Phương thức vận chuyển</span>
                            <span>{shippMethods(+model.deliveries[0].service_id)}</span>
                        </div>
                        <div>
                            <span class='highlight'>HÌNH THỨC THANH TOÁN</span>
                            <span>{{ $order->payment == \App\Models\Order::METHOD_PAY_2 ?"Thanh toán qua bảo kim": ($order->payment == \App\Models\Order::METHOD_PAY_1)?"Thanh toán chuyển khoản":"Thanh toán khi nhận hàng" }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('link')
@parent
<link rel="stylesheet" href="{{ mix('css/web/cart-detail-success.css') }}">
@endsection

@section('script')
@parent
<script src="{{ mix('js/app.js') }}"></script>
@include('web.components.extend')
@endsection