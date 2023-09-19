@extends('admin.layouts.admin')

@section('title_file', trans('form.page.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.page.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.page.form.inputs')
            <input type="hidden" name="id" value="{{ $page->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
