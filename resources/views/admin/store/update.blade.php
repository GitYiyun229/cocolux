@extends('admin.layouts.admin')

@section('title_file', trans('form.store.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.store.update', $store->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.store.form.inputs')
            <input type="hidden" name="id" value="{{ $store->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
