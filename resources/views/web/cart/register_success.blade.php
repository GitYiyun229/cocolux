@extends('web.layouts.web')

@section('content')
    <div class="content-register">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <img src="{{ asset('images/register_success.png') }}" alt="" class="img-fluid mb-4">
                    <h1 class="title-register">Đặt hàng thành công</h1>
                    <div class="mb-4">
                        <p>Cảm ơn {{ $order->gender == 1 ? 'Chị': 'Anh' }} <b>{{ $order->full_name }}</b> đã mua hàng trên Lẩu Nấm Gia Khánh!</p>
                        Lẩu Nấm Gia Khánh sẽ gọi điện thông qua số điện thoại Đặt hàng của quý khách để xác nhận đơn hàng trong thời gian sớm nhất.
                        Nếu Quý khách có nhu cầu xem lại thông tin Đặt hàng, Quý khách vui lòng kiểm tra xác nhận đơn hàng đã được gửi qua email.
                        Mọi thắc mắc xin vui lòng liên hệ với Lẩu Nấm Gia Khánh qua Hotline {{ $setting['hotline'] }}
                    </div>
                    <div class="row button-go-to-page">
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="go-to-home-page"><i class="fas fa-tv"></i> Về trang chủ</a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('productHome') }}" class="go-to-course-page">Khám phá thêm thực đơn <i class="fas fa-paper-plane"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('link')
    @parent
    <style>
        .content-register{
            padding: 80px 0;
            text-align: center;
        }
        .content-register img{
            display: block;
            margin: 0 auto;
        }
        .content-register .title-register{
            color: #E91A22;
            font-size: 32px;
            margin-bottom: 40px;
            text-transform: uppercase;
        }
        .button-go-to-page a{
            border-radius: 8px;
            text-align: center;
            padding: 14px 20px;
            display: block;
            text-decoration: none;
            font-family: GoogleSans-Bold;
        }
        .button-go-to-page .go-to-course-page{
            background: #E91A22;
            color: #fff;
        }
        .button-go-to-page .go-to-home-page{
            color: #620B0E;
            background: #E4A812;
        }
    </style>
@endsection

@section('script')
    @parent
@endsection
