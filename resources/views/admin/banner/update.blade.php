@extends('admin.layouts.admin')

@section('title_file', trans('form.banner.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.banner.form.inputs')
            <input type="hidden" name="id" value="{{ $banner->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
