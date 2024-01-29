require('../bootstrap');
import $ from "jquery";
window.$ = $;
import 'bootstrap';
import swal from 'sweetalert2';
window.Swal = swal;

require('./template');
require('./main');

// khi click vào thì submit form rồi lấy thông tin từ url để tạo filter
$('.btn-more-less').click(function() {
    $(this).toggleClass('less');
    $('.layout-article').toggleClass('less');
})

$('.filter-item').click(function () {
    var newValue = $(this).data('value');
    var className = $(this).data('name');
    $('.'+className).find('input[type="hidden"]').val(null);
    $(this).find('input[type="hidden"]').val(newValue);
    $('#form_filter').submit();
});

$('.card-item').click(function () {
    var newValue = $(this).data('value');
    $('.card-item').find('input[type="hidden"]').val(null);
    $(this).find('input[type="hidden"]').val(newValue);
    $('#form_filter').submit();
});

$('.del-icon').click(function () {
    var className = $(this).data('code');
    $('.'+className).find('input[type="hidden"]').val(null);
    $('#form_filter').submit();
});

$('#form_filter').submit(function () {
    $(this).find('input').each(function () {
        if ($(this).val() === '') {
            $(this).remove(); // Loại bỏ input
            // $(this).prop('disabled', true); // Vô hiệu hóa input
        }
    });
});
