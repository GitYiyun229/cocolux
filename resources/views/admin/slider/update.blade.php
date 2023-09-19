@extends('admin.layouts.admin')

@section('title_file', trans('form.slider.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.slider.form.inputs')
            <input type="hidden" name="id" value="{{ $slider->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
