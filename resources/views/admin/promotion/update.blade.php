@extends('admin.layouts.admin')

@section('title_file', trans('form.promotion.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.promotion.update', $promotion->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.promotion.form.inputs')
            <input type="hidden" name="id" value="{{ $promotion->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection

