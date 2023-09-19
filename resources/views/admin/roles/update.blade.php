@extends('admin.layouts.admin')

@section('title_file', trans('form.roles.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @include('admin.roles.form.inputs')
            <input type="hidden" name="id" value="{{ $role->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
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
