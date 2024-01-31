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
@section('script')
    @parent
    <script src="{{ mix('js/web/manifest.js') }}"></script>
    <script src="{{ mix('js/web/vendor.js') }}"></script>
@endsection
