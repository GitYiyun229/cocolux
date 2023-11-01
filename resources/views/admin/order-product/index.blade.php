@extends('admin.layouts.admin')

@section('title_file', trans('form.order-product.'))

@section('content')
    {!! $dataTable->table(['id' => 'order-table', 'class' => 'table table-striped table-bordered table-width-auto']) !!}
@endsection

@section('script')
    @parent
    {!! $dataTable->scripts() !!}
@endsection
