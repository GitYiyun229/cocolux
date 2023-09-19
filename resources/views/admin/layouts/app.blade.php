<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Finalstyle</title>
    <link rel="icon" href="/favicon.ico" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="{{ asset('/css/fontawesome.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('/css/fonts.googleapis.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    @yield('link')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @yield('page')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('/js/jquery.min.js') }}"></script>
<script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/fontawesome.min.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('js/demo.js') }}"></script>

@yield('script')
</body>
</html>
