<button
    type="button" class="btn btn-sm btn-outline-warning btn-edit"
    data-toggle="modal"
    data-target="#trainee-manner-modal"
    data-id="{{ $traineeId?$traineeId:'' }}"
    data-name="{{ $traineeSelect->name ?? '' }}"
    title="{{ isset($text)?$text:trans('form.button.edit') }}"
>
    <i class="fa fa-gavel"></i>
</button>