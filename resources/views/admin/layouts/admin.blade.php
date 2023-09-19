@extends('admin.layouts.app')

@section('page')
    <!-- Header -->
    @include('admin.partials._admin_header')
    <!-- /.Header -->
    <!-- Main Sidebar Container -->
    @include('admin.partials._admin_sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('admin.components.notification')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4 col-12">
                        <h1 class="m-0 text-dark">@yield('title_file')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-8 col-12">
                        <ol class="breadcrumb float-sm-right">
                            @yield('menu_instruction')
                        </ol>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            @yield('content')
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    @include('admin.partials._admin_footer')
@endsection

@section('link')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/jquery.timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/easymde.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
@endsection

@section('script')
    <!-- AdminLTE -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/datatable-custom.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/easymde.min.js') }}"></script>

    <script>
        $(function () {
            let application = new Application();
            application.deleteRecord();
            application.initDatepicker();
            application.initTimepicker();
            application.initSelect2Tag();
            application.initSelect2();
            application.changeStatus();
            application.initCallModal();
            let hasError = '{{ $errors->any() }}';
            let modalTarget = '{{ Session::get('modal_target') }}';
            application.showModalValidateFail(hasError, modalTarget);
            application.changeStatusInput();
        })

        let toastrSuccsee = '{{ Session::get('success') }}';
        let toastrDanger = '{{ Session::get('danger') }}';
        if (toastrDanger.length > 0 || toastrSuccsee.length > 0) {
            if (toastrDanger.length > 0) toastr["error"](toastrDanger)
            else toastr["success"](toastrSuccsee)
        }
    </script>
@endsection
