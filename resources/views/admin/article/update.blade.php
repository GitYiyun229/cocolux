@extends('admin.layouts.admin')

@section('title_file', trans('form.article.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.article.form.inputs')
            <input type="hidden" name="id" value="{{ $article->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
@endsection
