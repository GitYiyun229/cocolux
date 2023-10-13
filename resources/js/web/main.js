$(document).ready(function() {
    $('.item-parent, .item-child').on('click', function() {
        var selectedItem = $(this).data('value');
        $('#cat_product').val(selectedItem);
    });
    $('#search_product').submit(function () {
        $(this).find('input').each(function () {
            if ($(this).val() === '') {
                $(this).remove();
            }
        });
    });
});
