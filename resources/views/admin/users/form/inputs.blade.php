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
            <input type="email" class="form-control" name="email" value="{{ isset($user->email) ? $user->email : old('email') }}" required>
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
</div>
@if(!isset($user))
    <div class="row">
        <div class="col-sm-6">
            <!-- text input -->
            <div class="form-group">
                <label>@lang('form.user.password')</label>
                <input type="password" class="form-control" name="password">
                @if ($errors->has('password'))
                    <span class="help-block text-danger">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <!-- text input -->
            <div class="form-group">
                <label>@lang('form.user.password_confirm')</label>
                <input type="password" class="form-control" name="password_confirmation" value="{{ isset($user->password_confirmation) ? $user->password_confirmation : old('password_confirmation') }}">
                @if ($errors->has('password_confirmation'))
                    <span class="help-block text-danger">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
@endif
<div class="row">
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
            <label>@lang('form.user.type')</label> <span class="text-danger">*</span>
            <select name="type" class="form-control" required>
                @foreach(\App\Models\User::TYPE_ROLE as $key => $type)
                    <option value="{{ $key }}"  {{ isset($user->type) && $user->type == $key ? 'selected' : old('type') == $key ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
            @if ($errors->has('type'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.roles.')</label> <span class="text-danger">*</span>
            <select name="role_id[]" class="form-control js-select2" multiple="multiple" required >
                @if(!empty($roles))
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"  {{ isset($user->roles) && $user->roles->contains($role) ? 'selected' : is_array(old('role_id')) && in_array($role->id, old('role_id')) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                    @endforeach
                @endif
            </select>
            @if ($errors->has('role_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('role_id') }}</strong>
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
    <div class="col-sm-4">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.user.status')</label> <span class="text-danger">*</span>
            <div class="form-group clearfix">
                <div class="icheck-success d-inline">
                    <input class="" type="radio" id="statusRadio1" name="status" value="{{ \App\Models\User::STATUS_ACTIVE }}" {{ isset($user->status) && $user->status == \App\Models\User::STATUS_ACTIVE ? 'checked' : '' }} required>
                    <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')</label>
                </div>
                <div class="icheck-danger d-inline">
                    <input class="" type="radio" id="statusRadio2" name="status" value="{{ \App\Models\User::STATUS_INACTIVE }}" {{ isset($user->status) && $user->status == \App\Models\User::STATUS_INACTIVE ? 'checked' : '' }} required>
                    <label for="statusRadio2" class="custom-control-label">@lang('form.status.inactive')</label>
                </div>
            </div>
            @if ($errors->has('status'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
