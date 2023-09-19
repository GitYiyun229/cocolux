<div class="row">
    <div class="col-sm-3">
        <!-- text input -->
        <div class="form-group">
            <label>@lang('form.user.name')</label> <span class="text-danger">*</span>
            <input type="text" class="form-control" name="display_name" value="{{ isset($role) ? $role->display_name : old('display_name') }}" required>
            @if ($errors->has('display_name'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('display_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="" id="select_all" {{ isset($role) &&  isset($permissions) &&  $role->permissions->count() == $permissions->count() ? 'checked' : '' }}>
            <label class="form-check-label" for="select_all"><strong>@lang('form.roles.full_permission')</strong></label>
        </div>
        @if ($errors->has('permissions'))
            <span class="help-block text-danger">
            <strong>{{ $errors->first('permissions') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="row">
    @forelse($permissions as $permission)
        <div class="col-sm-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="radio-{{ $permission->id }}" {{ isset($role) && $role->permissions->contains($permission) ? 'checked' : '' }} >
                <label class="form-check-label" for="radio-{{ $permission->id }}">{{ $permission->display_name }}</label>
            </div>
        </div>
    @empty
    @endforelse
</div>
