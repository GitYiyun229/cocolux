@extends('admin.layouts.admin')

@section('title_file', trans('form.media-video.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.media-video.update', $video->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.media-video.form.inputs')
            <input type="hidden" name="id" value="{{ $video->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
