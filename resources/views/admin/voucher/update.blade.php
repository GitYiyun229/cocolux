@extends('admin.layouts.admin')

@section('title_file', trans('form.voucher.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.voucher.update', $voucher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.voucher.form.inputs')
            <input type="hidden" name="id" value="{{ $voucher->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection
