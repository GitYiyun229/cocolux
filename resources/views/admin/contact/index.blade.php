@extends('admin.layouts.admin')

@section('title_file', trans('form.user.manage'))

@section('content')
    {!! $dataTable->table(['id' => 'contact-table', 'class' => 'table table-striped table-bordered table-width-auto']) !!}
@endsection

@section('script')
    @parent
    {!! $dataTable->scripts() !!}
@endsection
