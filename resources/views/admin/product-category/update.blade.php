@extends('admin.layouts.admin')

@section('title_file', trans('form.product_category.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.product-category.update', $product_category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.product-category.form.inputs')
            <input type="hidden" name="id" value="{{ $product_category->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
