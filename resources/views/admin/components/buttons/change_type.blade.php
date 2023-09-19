<button
        type="button"
        class="btn btn-sm btn-outline-dark btn-change-status"
        data-title="@if(isset($dataAlert['title'])) {{ $dataAlert['title'] }} @endif"
        data-text="@if(isset($dataAlert['text'])) {{ $dataAlert['text'] }} @endif"
        data-url="@if(isset($urlChangeType)) {{ $urlChangeType }} @endif"
        data-table-id="@if(isset($lowerModelName)) #{{ $lowerModelName }}-table @endif"
        title="@lang('form.button.change_type')">
    <i class="fa fa-random"></i>
</button>