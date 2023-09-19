<label class="switch">
    <input type="checkbox" class="input-change-status"
           data-url="@if(isset($url)) {{ $url }} @endif"
           data-table-id="@if(isset($lowerModelName)) #{{ $lowerModelName }}-table @endif"
            {{ $status }}>
    <span class="slider round"></span>
</label>