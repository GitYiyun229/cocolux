<button
        type="button" class="btn btn-sm btn-outline-primary btn-edit"
        data-toggle="modal"
        data-target="#roll-call-modal"
        data-id="{{ $traineeId?$traineeId:'' }}"
        data-name="{{ $traineeSelect->name ?? '' }}"
        title="{{ isset($text)?$text:trans('form.button.edit') }}"
>
    <i class="fa fa-check"></i>
</button>