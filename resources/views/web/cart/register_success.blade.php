@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <div class="layout-page-payment-success mt-4 mb-4 bg-white">
                <div class="layout-image">
                    <img src="{{ asset('images/checkout-success.svg') }}" alt="success" class="img-fluid">
                </div>
                <div class="layout-infomation">
                    <div class="layout-title">Cảm ơn bạn đã đặt hàng tại Cocolux!</div>

                    <div class="order-info mb-3">
                        <p class="mb-2">Mã đơn hàng của bạn là:</p>
                        <a href="" title="Chi tiết đơn hàng">
                            DH00105114
                        </a>
                    </div>

                    <p>Bạn có thể xem <a href="">chi tiết đơn hàng tại đây</a></p>

                    <p>Để đơn hàng được xử lý nhanh chóng, Cocolux có thể không gọi điện xác nhận đơn hàng. Hệ thống tự động xử lý và nhân viên giao hàng sẽ liên hệ trực tiếp với bạn.</p>

                    <p>Mọi thắc mắc vui lòng liên hệ tại <a href="tel:+84-988888825" class="fw-bold">+84-988888825</a></p>

                    <a href="{{ route('home') }}" class="continue">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/cart-success.css') }}">
@endsection

@section('script')
    @parent
@endsection
