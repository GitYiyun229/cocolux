@extends('admin.layouts.admin')

@section('title_file', trans('form.setting.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.setting.form.inputs')
            <input type="hidden" name="id" value="{{ $setting->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
