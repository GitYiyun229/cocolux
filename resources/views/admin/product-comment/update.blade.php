@extends('admin.layouts.admin')

@section('title_file', trans('form.product_comment.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.product-comment.update', $product_comment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.product-comment.form.inputs')
            <input type="hidden" name="id" value="{{ $product_comment->id }}">
            <button type="submit" class="btn btn-primary mt-md-3">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
