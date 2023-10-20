@extends('admin.layouts.admin')

@section('title_file', trans('form.page_category.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.page-category.update', $page_category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.page-category.form.inputs')
            <input type="hidden" name="id" value="{{ $page_category->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection

