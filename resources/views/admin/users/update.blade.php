@extends('admin.layouts.admin')

@section('title_file', trans('form.user.update'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @include('admin.users.form.inputs')
            <input type="hidden" name="id" value="{{ $user->id }}">
            <button type="submit" class="btn btn-primary">@lang('form.button.update')</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
@endsection
