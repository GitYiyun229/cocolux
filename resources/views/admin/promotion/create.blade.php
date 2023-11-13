@extends('admin.layouts.admin')

@section('title_file', trans('form.promotion.create'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.promotion.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.promotion.form.inputs')
            <button type="submit" class="btn btn-primary float-right">@lang('form.button.save')</button>
        </form>
    </div>
@endsection
