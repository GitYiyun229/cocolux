@extends('web.layouts.web')

@section('content')
<main>
    <div class="container">
        <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="fa-solid fa-house-chimney"></i>
                        Trang chủ
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Trang tĩnh
                </li>
            </ol>
        </nav>

        <div class="layout-page-content mb-5">
            <div class="layout-menu">
                <div class="group-menu mb-5">
                    <p class="title text-uppercase mb-0">Thông tin</p>
                    <a href="" class="">Hướng dẫn đặt hàng</a>
                    <a href="" class="">Giới thiệu</a>
                    <a href="" class="active">Quy trình giao hàng</a>
                    <a href="" class="">Điều khoản sử dụng</a>
                    <a href="" class="">Chính sách bảo mật</a>
                </div>
                <div class="group-menu mb-5">
                    <p class="title text-uppercase mb-0">Câu hỏi thường gặp</p>
                    <a href="" class="">Kiểm tra đơn hàng</a>
                    <a href="" class="">Đặt hàng tại Cocolux</a>
                    <a href="" class="">Phí vận chuyển</a>
                </div>
            </div>
            <div class="layout-main">
                {!! $page->content !!}
            </div>
        </div>
    </div>

</main>
@endsection

@section('link')
@parent
<link rel="stylesheet" href="{{ asset('/css/web/content.css') }}">
@endsection

@section('script')
@parent
@endsection
