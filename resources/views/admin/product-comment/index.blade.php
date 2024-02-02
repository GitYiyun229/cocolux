@extends('admin.layouts.admin')
@section('link')
    @parent
@endsection
@section('title_file', trans('form.product_comment.'))

@section('content')
{{--    <a href="{{ route('admin.product-comment.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> @lang('form.button.create')</a>--}}
    {!! $dataTable->table(['id' => 'product-comment-table', 'class' => 'table table-striped table-bordered table-width-auto']) !!}
@endsection

@section('script')
    @parent
    {!! $dataTable->scripts() !!}
@endsection
