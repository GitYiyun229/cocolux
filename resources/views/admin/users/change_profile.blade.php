@extends('admin.layouts.admin')

@section('title_file', trans('form.user.change_profile'))

@section('content')
    <div class="card card-primary card-body">
        <form action="{{ route('admin.changeProfile') }}" method="POST">
            @csrf
            @include('admin.users.form.inputs_change_profile')
            <button type="submit" class="btn btn-primary">@lang('form.button.submit')</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
@endsection
