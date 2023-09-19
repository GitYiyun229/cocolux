@extends('admin.layouts.admin')

@section('title_file', trans('form.user.create'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            @include('admin.users.form.inputs')
            <button type="submit" class="btn btn-primary">@lang('form.button.submit')</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
@endsection
