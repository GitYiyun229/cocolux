@extends('admin.layouts.admin')

@section('title_file', trans('form.roles.create'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            @include('admin.roles.form.inputs')
            <button type="submit" class="btn btn-primary">@lang('form.button.submit')</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
    <script>
        let role = new Role();
        role.checkFullPermission()
    </script>
@endsection
