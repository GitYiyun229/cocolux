@extends('admin.layouts.admin')

@section('title_file', trans('form.article_category.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.article-category.update', $article_category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.article-category.form.inputs')
            <input type="hidden" name="id" value="{{ $article_category->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection

