@extends('admin.layouts.admin')

@section('title_file', trans('form.attribute.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.attribute.update', $attribute->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.attribute.form.inputs')
            <input type="hidden" name="id" value="{{ $attribute->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection

