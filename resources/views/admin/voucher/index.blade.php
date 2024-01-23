@extends('admin.layouts.admin')

@section('title_file', trans('form.banner.'))

@section('content')
    <a href="{{ route('listCoupons') }}" class="btn btn-primary mb-3" target="_blank">Lấy danh sách coupon</a>
    {!! $dataTable->table(['id' => 'voucher-table', 'class' => 'table table-striped table-bordered table-width-auto']) !!}
@endsection

@section('script')
    @parent
    {!! $dataTable->scripts() !!}
@endsection
