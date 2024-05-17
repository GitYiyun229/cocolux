@extends('web.layouts.web')

@section('content')
    <div class="container py-3 position-relative view-404">
        <div class="view-1">
            <img src="{{ asset('images/404_cocolux1.svg') }}" alt=""
                class="img-fluid w-100">
        </div>
        <div class="position-absolute w-100 d-flex justify-content-center view-2" >
            <a href="{{ route('home') }}" class="d-flex gap-2 align-items-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">  <path d="M7.825 13L13.425 18.6L12 20L4 12L12 4L13.425 5.4L7.825 11H20V13H7.825Z" fill="black" />
                </svg>
                Quay lại trang chủ</a>

        </div>
    </div>
@endsection
@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/product-detail.css') }}">
@endsection
@section('script')
    @parent
    <script src="{{ mix('js/web/home.js') }}"></script>
    @include('web.components.extend')
@endsection
