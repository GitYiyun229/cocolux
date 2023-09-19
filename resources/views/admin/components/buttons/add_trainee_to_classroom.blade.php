<button
    type="button"
    class="btn btn-sm btn-primary btn-change-status"
    data-title="@lang('alert.add_trainee_to_class')"
    data-text="@lang('alert.sure_to_add_trainee_to_class')"
    data-url="@if(isset($url)) {{ $url }} @endif"
    data-table-id="@if(isset($tableName)) #{{ $tableName }}-table @endif"
    title="@lang('form.button.add_trainee_to_classroom')">
    <i class="fa fa-user-plus"></i>
</button>
