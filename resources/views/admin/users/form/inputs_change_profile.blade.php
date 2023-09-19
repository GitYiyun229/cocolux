<div class="row">
    <div class="col-sm-4">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.user.name')</label> <span class="text-danger">*</span>
            <input type="text" class="form-control" name="name" value="{{ isset($user->name) ? $user->name : old('name') }}" required>
            @if ($errors->has('name'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>@lang('form.user.email')</label> <span class="text-danger">*</span>
            <input type="email" class="form-control" name="email" value="{{ isset($user->email) ? $user->email : old('email') }}" readonly required>
            @if ($errors->has('email'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.user.phone')</label> <span class="text-danger">*</span>
            <input type="text" class="form-control" name="phone" value="{{ isset($user->phone) ? $user->phone : old('phone') }}" required>
            @if ($errors->has('phone'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.user.birthday')</label>
            <input type="text" class="form-control js-datepicker" name="birthday" value="{{ isset($user->birthday) ? $user->birthday : old('birthday') }}" >
            @if ($errors->has('birthday'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('birthday') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.user.address')</label>
            <input type="text" class="form-control" name="address" value="{{ isset($user->address) ? $user->address : old('address') }}">
            @if ($errors->has('address'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.user.gender')</label> <span class="text-danger">*</span>
            <div class="form-group clearfix">
                <div class="icheck-success d-inline">
                    <input class="" type="radio" id="genderRadio1" name="gender" value="{{ \App\Models\User::GENDER_MALE }}" {{ isset($user->gender) && $user->gender == \App\Models\User::GENDER_MALE ? 'checked' : '' }} required>
                    <label for="genderRadio1" class="custom-control-label">@lang('form.gender.male')</label>
                </div>
                <div class="icheck-success d-inline">
                    <input class="" type="radio" id="genderRadio2" name="gender" value="{{ \App\Models\User::GENDER_FEMALE }}"  {{ isset($user->gender) && $user->gender == \App\Models\User::GENDER_FEMALE ? 'checked' : '' }} required>
                    <label for="genderRadio2" class="custom-control-label">@lang('form.gender.female')</label>
                </div>
            </div>
            @if ($errors->has('gender'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('gender') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
