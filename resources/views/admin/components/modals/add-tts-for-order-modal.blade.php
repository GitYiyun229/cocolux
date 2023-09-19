<!-- Modal -->
<div id="add_tts_for_order_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.button.add_trainee_for_order")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.orders.addTrainees', $order->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label for="">@lang("form.trainee.not_order")</label>
                    <div>
                        <select class="form-control js-select2" name="trainee_ids[]" multiple="multiple" required>
                            @foreach ($trainees as $trainee)
                                <option value="{{ $trainee->id }}">{{ $trainee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">@lang('form.button.save')</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('form.button.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
