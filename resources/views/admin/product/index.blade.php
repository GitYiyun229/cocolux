@extends('admin.layouts.admin')

@section('title_file', trans('form.product.'))

@section('content')
    <div class="row mb-3">
        <div class="col-sm-9">
            <form action="{{ route('admin.product.index') }}" method="GET" class="form-inline">
                <select name="category" class="form-control">
                    <option value="">@lang('form.product.category')</option>
                    @forelse($categories as $key => $category)
                        <option value="{{ $category['id'] }}" @if (isset($data['category']) && $data['category'] ==  $category['id']) selected @endif>{{ $category['title'] }}</option>
                    @empty
                    @endforelse
                </select>
                <button type="submit" class="btn btn-primary ml-3"><i class="fa fa-search"></i> @lang('form.button.search')</button>
                <a class="btn btn-success ml-2" href="{{ route('admin.product.index') }}"><i class="fa fa-recycle"></i> @lang('form.button.refresh')</a>
            </form>
        </div>
        <div class="col-sm-3">
{{--            <a href="{{ route('admin.product.create') }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i> @lang('form.button.create')</a>--}}
            <button class="btn btn-primary mb-4 float-right" type="button" data-toggle="modal" data-target="#createProduct"><i class="fas fa-plus"></i>Thêm sản phẩm mới</button>
        </div>
    </div>
    {!! $dataTable->table(['id' => 'product-table', 'class' => 'table table-striped table-bordered table-width-auto']) !!}
    @include('admin.product.form.new_product')
@endsection
@section('link')
    @parent
    <style>
        th{
            text-align: center;
        }

    </style>
@endsection
@section('script')
    @parent
    {!! $dataTable->scripts() !!}
@endsection
