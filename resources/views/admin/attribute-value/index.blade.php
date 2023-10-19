@extends('admin.layouts.admin')

@section('title_file', trans('form.attribute-value.'))

@section('content')
    <div class="row mb-3">
        <a href="{{ route('admin.attribute-value.create') }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i> @lang('form.button.create')</a>
    </div>
    {!! $dataTable->table(['id' => 'attribute-value-table', 'class' => 'table table-striped table-bordered table-width-auto']) !!}
@endsection

@section('script')
    @parent
    {!! $dataTable->scripts() !!}
@endsection
