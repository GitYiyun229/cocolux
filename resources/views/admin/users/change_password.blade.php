@extends('admin.layouts.admin')

@section('title_file', trans('form.user.change_profile'))

@section('content')
    <div class="card card-primary card-body container">
        <form action="{{ route('admin.updatePassword') }}" method="POST">
            @csrf
            <div class="row">
                <!-- text input -->
                <div class="form-group col-lg-4">
                    <label>@lang('form.user.password_current')</label> <span class="text-danger">*</span>
                </div>
                <div class="form-group col-lg-8">
                    <input type="password" class="form-control" name="password_current" value="{{ old('password_current') }}" required>
                    @if ($errors->has('password_current'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('password_current') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <!-- text input -->
                <div class="form-group col-lg-4">
                    <label>@lang('form.user.password')</label> <span class="text-danger">*</span>
                </div>
                <div class="form-group col-lg-8">
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" required>
                    @if ($errors->has('password'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <!-- text input -->
                <div class="form-group col-lg-4">
                    <label>@lang('form.user.password_confirm')</label> <span class="text-danger">*</span>
                </div>
                <div class="form-group col-lg-8">
                    <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary">@lang('form.button.submit')</button>
        </form>
    </div>
@endsection

@section('script')
    @parent
@endsection
