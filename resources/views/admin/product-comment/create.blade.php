@extends('admin.layouts.admin')

@section('title_file', trans('form.product_comment.create'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.product-comment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.product-comment.form.inputs')
            <button type="submit" class="btn btn-primary float-right">@lang('form.button.save')</button>
        </form>
    </div>
@endsection
