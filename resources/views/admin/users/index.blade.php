@extends('admin.layouts.admin')

@section('title_file', trans('form.user.manage'))

@section('content')
    <a class="btn btn-primary mb-3" href="{{ route('admin.users.create') }}"><i class="fa fa-plus"></i> @lang('form.button.create')</a>
    {!! $dataTable->table(['id' => 'user-table', 'class' => 'table table-striped table-bordered table-width-auto']) !!}
@endsection

@section('script')
    @parent
    {!! $dataTable->scripts() !!}
@endsection
