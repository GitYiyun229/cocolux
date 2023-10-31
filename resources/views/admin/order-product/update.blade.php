@extends('admin.layouts.admin')

@section('title_file', trans('form.order-product.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.order-product.update', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.order-product.form.inputs')
            <input type="hidden" name="id" value="{{ $order->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
@endsection
