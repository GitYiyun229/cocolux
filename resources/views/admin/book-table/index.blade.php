@extends('admin.layouts.admin')

@section('title_file', trans('form.book_table.'))

@section('content')
    {!! $dataTable->table(['id' => 'books-table', 'class' => 'table table-striped table-bordered table-width-auto']) !!}
@endsection

@section('script')
    @parent
    {!! $dataTable->scripts() !!}
@endsection
