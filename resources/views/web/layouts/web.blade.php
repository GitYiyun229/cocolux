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
                <a href="{{ route('home') }}" class="d-flex align-items-center justify-content-center h-100 flex-column {{ $routeName == 'home' ? 'text-danger' : ''}}">
                    <i class="fa-solid fa-house-chimney"></i>
                    Trang chủ
                </a>
            </li>
            <li class="w-100 h-100">
                <a href="{{ route('dealHotProducts') }}" class="d-flex align-items-center justify-content-center h-100 flex-column {{ $routeName == 'dealHotProducts' ? 'text-danger' : ''}}">
                    <i class="fa-solid fa-gift"></i>
                    Ưu đãi
                </a>
            </li>
            <li class="w-100 h-100">
                <a href="{{ route('homeArticle') }}" class="d-flex align-items-center justify-content-center h-100 flex-column {{ $routeName == 'homeArticle' ? 'text-danger' : ''}}">
                    <i class="fa-regular fa-newspaper"></i>
                    Xu hướng
                </a>
            </li>
        </ul>
    </nav>
@endsection

@section('link')
    <link rel="stylesheet" href="{{ asset('/js/web/fontawesome-free-6.1.1-web/css/all.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('/css/mmenu.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('/css/web/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/web/template.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/web/style.css') }}">
@endsection

@section('script')
    <!-- Bootstrap -->
    <script src="{{ asset('/js/web/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/web/template.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{--    <script src="{{ asset('js/mmenu.js') }}"></script>--}}
    <script src="{{ asset('js/web/main.js') }}" defer></script>
    <script>
        let toastrSuccsee = '{{ Session::get('success') }}';
        let toastrDanger = '{{ Session::get('danger') }}';
        if (toastrDanger.length > 0 || toastrSuccsee.length > 0) {
            if (toastrDanger.length > 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: toastrDanger,
                })
                toastr["error"](toastrDanger)
            } else {
                Swal.fire(
                    'Thành công!',
                    toastrSuccsee,
                    'success'
                )
            }
        }
    </script>

@endsection
