<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <link type='image/x-icon' href='{{ asset('images/favicon.ico') }}' rel='icon'/>
    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    @yield('link')
    <script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-NGPB3KQ"></script><script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-JKPNMVXR47&amp;l=dataLayer&amp;cx=c" nonce="g3FmeM9o"></script><script type="text/javascript">
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NGPB3KQ');
    </script>
</head>
<body>
    @yield('page')
    <!-- jQuery -->
    <script src="{{ asset('/js/web/jquery-3.7.1.min.js') }}"></script>
    <!-- Scripts -->
    @yield('script')
</body>
</html>
