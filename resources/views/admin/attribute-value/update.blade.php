@extends('admin.layouts.admin')

@section('title_file', trans('form.attribute-value.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.attribute-value.update', $attribute_value->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.attribute-value.form.inputs')
            <input type="hidden" name="id" value="{{ $attribute_value->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
@endsection
