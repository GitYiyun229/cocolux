@extends('web.layouts.web')

@section('content')

@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/js/web/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/web/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/web/home.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ asset('/js/web/slick/slick.js') }}"></script>
    <script>
        $('.slide-home').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            dot:false,
            fade: true,
            autoplay: true,
            autoplaySpeed: 2000,
            prevArrow: '<div class="slick-prev"><svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="56" height="56" rx="28" fill="black" fill-opacity="0.12"/><path d="M33 38L23 28L33 18" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
            nextArrow: '<div class="slick-next"><svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="56" y="56" width="56" height="56" rx="28" transform="rotate(-180 56 56)" fill="black" fill-opacity="0.12"/><path d="M23 18L33 28L23 38" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
            asNavFor: '.slider-nav-slide-home',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                }
            ]
        });
        $('.slider-nav-slide-home').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slide-home',
            dots: false,
            centerMode: false,
            arrows: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 2000,
            focusOnSelect: true
        });

        $('.article-list-home').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                }
            ]
        });
    </script>
@endsection
