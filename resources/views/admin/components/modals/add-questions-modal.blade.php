<div id="add-questions-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("form.competition.add_question_for_group")</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div>
                        <label for="" class="float-left">@lang("form.competition.number_question_for_group")</label> <span class="text-danger float-left">*</span><br>
                        <div class="input-group">
                            <input type="number" min="1" max="" name="number_question" required class="form-control" id="exampleInputFile" placeholder="@lang("form.competition.number_question_for_group")">
                            <div class="input-group-append">
                                <span class="input-group-text">/ @lang("form.competition.in_total") &nbsp<span class="total-number-question"></span></span>
                            </div>
                            <p class="text-danger">@lang("form.competition.random_question")</p>
                            <input type="hidden" name="type" class="js-type">
                            <input type="hidden" name="competition_id" class="js-competition-id">
                            <input type="hidden" name="question_group_id" class="js-question-group-id">
                        </div>
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
