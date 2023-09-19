function Application() {
    this.deleteRecord = function () {
        let btn = '.btn-delete';
        let title = "Xóa bản ghi?";
        let text = "Bạn có chắc chắn muốn xóa!";
        this.alertAndAjax(btn, title, text)
    };

    this.changeStatus = function () {
        let btn = '.btn-change-status';
        let title = "";
        let text = "";
        this.alertAndAjax(btn, title, text)
    };

    this.alertAndAjax = function (btn, title, text) {
        $(document).on('click', btn, function () {
            let url = $(this).data('url');
            let tableId = $(this).data('table-id');
            let buttonDelete = $(this);
            if ($(this).data('title')){
                title = $(this).data('title')
            }
            if ($(this).data('text')){
                text = $(this).data('text')
            }
            swal({
                title: title,
                text: text,
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (result) {
                if (result.value === true) {
                    $.ajaxSetup({
                        headers:
                            {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    });
                    $.ajax({
                        type: 'POST',
                        url: url,
                        success: function (result) {
                            if (result.status === true) {
                                if (tableId == undefined) {
                                    buttonDelete.closest('.col-sm-3').remove();
                                }
                                var table = $(tableId).DataTable();
                                table.ajax.reload(null, false);
                                toastr["success"](result.message);
                            }

                            if (result.status === false) {
                                if (tableId == undefined) {
                                    buttonDelete.closest('.col-sm-3').remove();
                                }
                                var table = $(tableId).DataTable();
                                table.ajax.reload(null, false);
                                toastr["error"](result.message);
                            }
                        }
                    });
                }
            }, function (dismiss) {
                return false;
            });
        })
    }

    this.initDatepicker = function () {
        $('.js-datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    };

    this.initCallModal = function () {
        $('#roll-call-modal').on('shown.bs.modal', function (e) {
            var target = e.relatedTarget;
            var id = $(target).data('id');
            var name = $(target).data('name');
            $('.modal-title').text(name);
            $('.input-trainee-id-modal').val(id);
        });

        $('#trainee-manner-modal').on('shown.bs.modal', function (e) {
            var target = e.relatedTarget;
            var id = $(target).data('id');
            var name = $(target).data('name');
            $('.modal-title').text(name);
            $('.input-trainee-id-modal').val(id);
        });
    };

    this.initTimepicker = function () {
        $('.js-timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 15,
            minTime: '06',
            maxTime: '11:00pm',
            startTime: '06:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    };

    this.initSelect2Tag = function () {
        $(".js-select2-tags").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });
    };

    this.initSelect2 = function () {
        $(".js-select2").select2();
    };

    /**
     * Show modal when form contained in modal validate fail
     */
    this.showModalValidateFail = function (hasError, modalTarget) {
        if (hasError) {
            if (modalTarget !== '') {
                $("#" + modalTarget).modal('show');
            }
        }
    };

    this.changeStatusInput = function () {
        let btn = '.input-change-status';
        this.AjaxChange(btn)
    };

    this.AjaxChange = function (btn) {
        $(document).on('click', btn, function () {
            let url = $(this).data('url');
            let tableId = $(this).data('table-id');
            let buttonDelete = $(this);
            $.ajaxSetup({
                headers:
                    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $.ajax({
                type: 'POST',
                url: url,
                success: function (result) {
                    if (result.status === true) {
                        if (tableId == undefined) {
                            buttonDelete.closest('.col-sm-3').remove();
                        }
                        var table = $(tableId).DataTable();
                        table.ajax.reload(null, false);
                        toastr["success"](result.message);
                    }
                }
            });
        })
    }

    this.initEasyMDE = function () {
        var easyMDE = new EasyMDE({
            element: document.getElementById('easy-mde'),
            toolbar: [
                'bold',
                'italic',
                'strikethrough',
                'heading',
                'quote',
                'unordered-list',
                'ordered-list',
                'link',
                'table',
                'horizontal-rule',
                'preview',
            ]
        });
    }
}

function Trainee() {
    this.removeInputForm = function () {
        $(document).on('click', '.table-history .fa-trash', function () {
            $(this).closest('tr').remove();
        });
    }

    this.translateName = function () {
        $('.js-trainee-name').blur(function () {
            var name = $(this).val();
            var urlTranslate = $(this).data('url-translate');
            $.ajax({
                url: urlTranslate,
                data: {name: name},
                success: function (result) {
                    if (result.status === true) {
                        $('.js-trainee-name-jp').val(result.nameJp);
                    }
                }
            })
        })
    }

    this.hiddenShowRelativesInJp = function () {
        $('#is-relative-jp-yes-radio').click(function () {
            $('.js-relative-in-jp').removeClass('hidden');
        })
        $('#is-relative-jp-no-radio').click(function () {
            $('.js-relative-in-jp').addClass('hidden');
        })
    }

    this.hiddenShowIsQuitSmoking = function () {
        $('#is-smoking-much-radio').click(function () {
            $('.js-quit-smoking').removeClass('hidden');
        })
        $('#is-smoking-normal-radio').click(function () {
            $('.js-quit-smoking').removeClass('hidden');
        })
        $('#is-smoking-no-radio').click(function () {
            $('.js-quit-smoking').addClass('hidden');
        })
    }
}

function Order() {
    this.changeStatus = function () {
        $(document).on('click', '.js-change-order-status', function () {
            let tableId = $(this).closest('ul').data('table-id');
            let url = $(this).data('url-change-status');
            let orderStatusName = $(this).data('order-status-name');
            let text = 'Bạn muốn chuyển trạng thái đơn hàng sang ' + orderStatusName + '?';
            swal({
                title: 'Chuyển trạng thái đơn hàng?',
                text: text,
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (result) {
                if (result.value === true) {
                    $.ajaxSetup({
                        headers:
                            {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    });
                    $.ajax({
                        type: 'POST',
                        url: url,
                        success: function (result) {
                            if (result.status === true) {
                                var table = $(tableId).DataTable();
                                table.ajax.reload(null, false);
                                toastr["success"](result.message);
                            }
                        }
                    });
                }
            }, function (dismiss) {
                return false;
            });
        })
    }
}
function Role() {
    this.checkFullPermission = function () {
        $('#select_all').click(function() {
            var isChecked = this.checked;
            $(':checkbox').prop('checked', isChecked);
        });

        $("input[name='permissions[]']").on('change', function() {
            var permissionsCount = $("input[name='permissions[]']").length;
            var countCheckedCheckboxes = $("input[name='permissions[]']").filter(':checked').length;
            if (countCheckedCheckboxes != permissionsCount) {
                $('#select_all').prop('checked', false);
            } else {
                $('#select_all').prop('checked', true);
            }
        });
    }
}

function Question() {
    this.hiddenInputParentViaValueDesc = function () {
        $('.js-question-desc').blur(function () {
            let value = $(this).val();
            if (value != '') {
                $('.js-question-parent').closest('.row').addClass('hidden');
            } else {
                $('.js-question-parent').closest('.row').removeClass('hidden');
            }
        })
    }

    this.submitFormQuestion = function () {
        $('.js-question-lesson').change(function () {
            let lesson =  $('.js-question-lesson').val();
            let type =  $('.js-question-type').val();
            if (lesson != '' && type != '') {
                $('.js-question-type').closest('form').submit();
            }
        })

        $('.js-question-type').change(function () {
            let lesson =  $('.js-question-lesson').val();
            let type =  $('.js-question-type').val();
            if (lesson != '' && type != '') {
                $('.js-question-type').closest('form').submit();
            }
        })
    }
}

function Competition() {
    this.showModalAddGroupQuestion = function () {
        $('.js-btn-add-group-question').click(function () {
            let urlGetGroups = $(this).data('url');
            let urlAddGroupToSection = $(this).data('add-group-question');
            let sectionGroupId = $(this).data('section-group-id');

            $.ajax({
                url: urlGetGroups,
                data: {sectionGroupId: sectionGroupId},
                success: function (result) {
                    if (result.status === true) {
                        $('#group-question-modal select').html(result.html);
                        $('#group-question-modal form').attr('action', urlAddGroupToSection);
                        $('#group-question-modal').modal('show');
                    }
                }
            })
        });
    }

    this.showModalAddQuestions = function () {
        $('.js-btn-add-questions').click(function () {
            let urlCountQuestion = $(this).data('url-count-question');
            let urlAddQuestionForGroup = $(this).data('url-add-questions-for-group');
            let type = $(this).data('type');
            let competitionId = $(this).data('competition-id');
            let questionGroupId = $(this).data('question-group-id');

            $.ajax({
                url: urlCountQuestion,
                data: {type: type, competitionId: competitionId, questionGroupId:questionGroupId},
                success: function (result) {
                    if (result.status === true) {
                        $('#add-questions-modal form').attr('action', urlAddQuestionForGroup);
                        $('#add-questions-modal input[name="number_question"]').attr('max', result.countQuestion);
                        $('#add-questions-modal .total-number-question').html(result.countQuestion);
                        $('#add-questions-modal .js-type').val(type);
                        $('#add-questions-modal .js-competition-id').val(competitionId);
                        $('#add-questions-modal .js-question-group-id').val(questionGroupId);
                        $('#add-questions-modal').modal('show');
                    }
                }
            })
        })
    }

    this.deleteSectionGroup = function () {
        $('.js-destroy-section-group').click(function () {
            let title = $(this).data('delete-section-group');
            let text = $(this).data('sure-delete');
            let urlDeleteSectionGroup = $(this).data('url-delete');
            swal({
                title: title,
                text: text,
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (result) {
                if (result.value === true) {
                    $.ajaxSetup({
                        headers:
                            {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    });
                    $.ajax({
                        type: 'POST',
                        url: urlDeleteSectionGroup,
                        success: function (result) {
                            if (result.status === true) {
                                location.reload();
                            }
                        }
                    });
                }
            }, function (dismiss) {
                return false;
            });
        });
    }

    this.showModalChangeTimeTest = function () {
        $('.js-change-time-test').click(function () {
            let urlUpdateTimeTest = $(this).data('url-update-time-test');
            let time = $(this).data('time');
            $('#change-time-test-modal form').attr('action', urlUpdateTimeTest);
            $('#change-time-test-modal input[name="time"]').val(time);
            $('#change-time-test-modal').modal('show');
        });
    }
}

function Course() {
    this.showHiddenInputByTypeKanji = function () {
        $('.js-select-type-kanji').change(function () {
            let valueTypeKanji = $(this).val();
            if (parseInt(valueTypeKanji) === 3) {
                $('.js-kanji-learning').addClass('hidden');
                $('.js-question-type-practice').removeClass('hidden');
            } else {
                $('.js-kanji-learning').removeClass('hidden');
                $('.js-question-type-practice').addClass('hidden');
                if (parseInt(valueTypeKanji) === 1) {
                    $('.js-kanji-know').removeClass('hidden');
                    $('.js-kanji-understand').addClass('hidden');
                } else {
                    $('.js-kanji-know').addClass('hidden');
                    $('.js-kanji-understand').removeClass('hidden');
                }
            }
        })
    }
}

function ClassRoom() {
    this.showHiddenTestLesson = function () {
        $('.js-course').change(function () {
            let courseId = $(this).val();
            if (parseInt(courseId) > 0) {
                $('.js-is-test-lesson').removeClass('hidden');
            } else {
                $('.js-is-test-lesson').addClass('hidden');
            }
        })
    }
}
