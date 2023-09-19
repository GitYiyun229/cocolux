<div class="form-group">
    <label>@lang('form.change_lang')</label> <span class="text-danger">*</span>
    <div class="form-group clearfix">
        <select name="locale" id="change_lang" class="text-capitalize form-control" >
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <option value="{{ $localeCode }}" {{ (isset($local) && $local == $localeCode) ?'selected':(!isset($local) && $localeCode == 'vi') ? 'selected' : '' }}>{{ $properties['native'] }}</option>
            @endforeach
        </select>
    </div>
    @if ($errors->has('change_lang'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('change_lang') }}</strong>
        </span>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const selectLang = document.getElementById('change_lang');

    selectLang.addEventListener('change', (event) => {
        Swal.fire({
            title: 'Bạn có chắc chắn không?',
            text: "Thông tin chưa lưu sẽ mất",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý!'
        }).then((result) => {
            if (result.isConfirmed) {
                const selectedRoute = event.target.value;
                window.location.href = `{{ isset($url)?$url:'' }}?local=${selectedRoute}`;
            }
        })

    });
</script>
