@extends('web.layouts.web')

@section('content')
    <div class="container py-3">
        <img src="{{ asset('images/404_cocolux.svg') }}" alt="" width="29" height="29" class="img-fluid w-100">
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
