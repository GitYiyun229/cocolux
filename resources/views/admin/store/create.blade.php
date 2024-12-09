@extends('admin.layouts.admin')

@section('title_file', trans('form.store.create'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.store.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.store.form.inputs')
            <button type="submit" class="btn btn-primary">@lang('form.button.submit')</button>
        </form>
{{--        <button id="ckfinder-popup" class="button-a button-a-background" style="float: left">Open Popup</button>--}}
    </div>
@endsection

@section('script')
    @parent
    <script src="{{ asset('js/select2.js') }}?v=1.0"></script>
    <script>
        $(document).ready(function() {
            $('.selec2-box').select2({
                // Các tùy chọn Select2 ở đây
            });
        });
    </script>
@endsection

