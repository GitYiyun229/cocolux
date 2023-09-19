<div id="change-time-test-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.competition.change_time_test")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div>
                        <label for="" class="float-left">@lang("form.competition.time")</label> <span class="text-danger float-left">*</span><br>
                        <input type="number" min="1" name="time" required class="form-control" placeholder="@lang("form.competition.time")">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >@lang('form.button.save')</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('form.button.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
