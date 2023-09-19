@extends('admin.layouts.admin')

@section('title_file', trans('form.media-image.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.media-image.update', $image->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.media-image.form.inputs')
            <input type="hidden" name="id" value="{{ $image->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
