@extends('admin.layouts.admin')

@section('title_file', trans('form.article.'))

@section('content')
    <div class="row mb-3">
        <div class="col-sm-9">
            <form action="{{ route('admin.article.index') }}" method="GET" class="form-inline">
                <select name="category" class="form-control">
                    <option value="">@lang('form.article.category')</option>
                    @forelse($categories as $key => $category)
                        <option value="{{ $category['id'] }}" @if (isset($data['category']) && $data['category'] ==  $category['id']) selected @endif>{{ $category['title'] }}</option>
                    @empty
                    @endforelse
                </select>
                <button type="submit" class="btn btn-primary ml-3"><i class="fa fa-search"></i> @lang('form.button.search')</button>
                <a class="btn btn-success ml-2" href="{{ route('admin.article.index') }}"><i class="fa fa-recycle"></i> @lang('form.button.refresh')</a>
            </form>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.article.create') }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i> @lang('form.button.create')</a>
        </div>
    </div>
    {!! $dataTable->table(['id' => 'article-table', 'class' => 'table table-striped table-bordered table-width-auto']) !!}
@endsection

@section('script')
    @parent
    {!! $dataTable->scripts() !!}
@endsection
