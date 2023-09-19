@extends('admin.layouts.admin')

@section('title_file', trans('form.menu_category.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.menu-category.update', $menu_category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.menu-category.form.inputs')
            <input type="hidden" name="id" value="{{ $menu_category->id }}">
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
