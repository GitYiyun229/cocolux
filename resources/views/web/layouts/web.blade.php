@extends('web.layouts.app')
@section('page')
    <div id="app">
        <!-- Header -->
        @include('web.partials._header')
        <!-- /.Header -->
        <div class="content">
            @yield('content')
        </div>
        <!-- Main Footer -->
        @include('web.partials._footer')
    </div>
    <nav class="menu-mobile d-block d-lg-none" id="menu-mobile">
        <ul>
            @php
                $routeName = \Route::currentRouteName();
            @endphp
            <li class="w-100 h-100">
                <a href="{{ route('home') }}"
                    class="d-flex align-items-center justify-content-center h-100 flex-column {{ $routeName == 'home' ? 'text-danger' : '' }}">
                    <i class="fa-solid fa-house-chimney"></i>
                    Trang chủ
                </a>
            </li>
            <li class="w-100 h-100">
                <a href="{{ route('dealHotProducts') }}"
                    class="d-flex align-items-center justify-content-center h-100 flex-column {{ $routeName == 'dealHotProducts' ? 'text-danger' : '' }}">
                    <i class="fa-solid fa-gift"></i>
                    Ưu đãi
                </a>
            </li>
            <li class="w-100 h-100">
                <a href="{{ route('homeArticle') }}"
                    class="d-flex align-items-center justify-content-center h-100 flex-column {{ $routeName == 'homeArticle' ? 'text-danger' : '' }}">
                    <i class="fa-regular fa-newspaper"></i>
                    Xu hướng
                </a>
            </li>
        </ul>
    </nav>
@endsection
@section('link')
    @parent
    <style>
        .image-frame1 {

                border-radius: 8px;
                display: inline-block;
                padding: 0px 10px 0px 10px;

        }
      a.product-template.khung-sale {


                padding: 0px ;

        }
      a.product-template.khung-sale .product-discount{


                right: 0;

        }
        .image-frame-home-1 {

                border-radius: 8px;
                display: inline-block;
                padding: 0px 0px 0px 0px;

        }

        .image-frame2 {

                border-radius: 8px;
                display: inline-block;
                padding: 0px 5px 0px 5px;

        }

        .product-template.image-frame--2 {
            margin-top: 10px;
            padding: 0px 11px;
        }
        .image-frame-top {
            top: 8px ;
        }

        .image-frame {
            @if ($setting['frame_image_for_sale'])
                background: url('{{ asset($setting['frame_image_for_sale']) }}') center center no-repeat;
                background-size: cover;
                padding: 10px;
                border-radius: 8px;
                display: inline-block;
            @endif
        }
    </style>
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/web/manifest.js') }}"></script>
    <script src="{{ mix('js/web/vendor.js') }}"></script>
@endsection
