import $ from "jquery";
window.$ = $;
import 'bootstrap';
import swal from 'sweetalert2';
window.Swal = swal;
import 'slick-carousel';

require('./template');
require('./main');

$('.btn-slide-next').click(function(e) {
    changeSlide(e, 1);
})

$('.btn-slide-prev').click(function(e) {
    changeSlide(e, -1);
})

function changeSlide(e, type) {
    e.preventDefault();

    let currentElement = $('.modal-thumbnail-item.active');
    let index = parseInt(currentElement.attr('data-index'));
    let total = $('.modal-thumbnail-item').length;
    let changeIndex;

    if (type > 0) {
        changeIndex = index + 1 >= total ? 0 : index + 1;
    } else {
        changeIndex = index == 0 ? total - 1 : index - 1;
    }

    $('.modal-thumbnail-item.thumbnail-item-'+changeIndex).click();
}

$('.submit-image').click(function(e){
    e.preventDefault();
    $("#image").click();
})

$('#image').change(function() {
    const files = this.files;
    const maxAllowedFiles = 5;

    $('.list-image-review').empty();

    if (files.length > 5) {
        console.log('Chỉ được up tối đa 5 ảnh');
    }

    for (let i = 0; i < Math.min(maxAllowedFiles, files.length); i++) {
        const file = files[i];
        const image = $('<img class="img-fluid" width="50" height="50">').addClass('uploaded-image');
        const reader = new FileReader();
        reader.onload = function(e) {
            image.attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
        $('.list-image-review').append(image);
    }
})

$('.submit-review').click(function(e) {
    e.preventDefault();
    let content = $('#content').val();
    let rate = $('#rate').val();
    $('.review-rating p').remove();
    $('#content').next('p').remove();
    if (rate == 0){
        $('.review-rating').append('<p class="position-absolute text-danger m-0" style="left: 150px; font-size: 14px">Vui lòng đánh giá sản phẩm.</p>');
        return false;
    }
    if (!content.trim()) {
        $('#content').focus();
        $('<p class="mb-2 text-danger">Vui lòng nhập nội dung đánh giá của bạn.</p>').insertAfter("#content");
        return false;
    }
    $(this).closest('form').submit();
})

$('.review-rating-item').hover(function() {
    toggleStar(parseInt($(this).attr('value')))
}, function() {
    toggleStar(parseInt($('#rate').val()))
})

$('.review-rating-item').click(function() {
    let value = parseInt($(this).attr('value'));
    $('#rate').val(value);
    toggleStar(value)
})

function toggleStar(value) {
    $(`.review-rating-item`).removeClass('active')
    for (let i = 1; i <= value; i++) {
        $(`.review-rating-item:eq(${i - 1})`).addClass('active')
    }
}

$('.nav-link-detail').click(function(e) {
    e.preventDefault();
    let target = $(this).attr('href');
    target = target.replace(/.+(?=#)/g, '');
    $('html, body').css('scroll-behavior', 'auto').animate({
        'scrollTop': $(target).offset().top - 120
    }, 800);
})

$('.detail-address').mouseenter(function() {
    $(this).dropdown('show');
})

$('.detail-address').mouseleave(function() {
    $(this).dropdown('hide');
})

$('.thumbnail-item').click(function() {
    let src = $(this).find('img').attr('src');
    let index = $(this).attr('data-index');

    $('.detail-thumbnail-image').attr('src', src);
    $('.detail-thumbnail-image-modal').attr('src', src);

    $('.thumbnail-item').removeClass('active');
    $('.modal-thumbnail-item').removeClass('active');
    $('.thumbnail-item-'+index).addClass('active');
    // $(this).addClass('active');
})

$('.modal-thumbnail-item').click(function() {
    let src = $(this).find('img').attr('src');
    $('.detail-thumbnail-image-modal').attr('src', src);
    $('.modal-thumbnail-item').removeClass('active');
    $(this).addClass('active');
})

$(".count-down").each(function (e) {
    countdowwn($(this));
});

$(document).on("scroll", onScroll);

function onScroll(event){
    let scrollPos = $(document).scrollTop();
    $('.nav-link-detail').each(function () {
        let currLink = $(this);
        let refElement = $(currLink.attr("href"));
        if (refElement.position().top - 140 <= scrollPos && refElement.position().top - 140 + refElement.height() > scrollPos) {
            $('.nav-link-detail').removeClass("active");
            currLink.addClass("active");
        } else {
            currLink.removeClass("active");
        }
    });
}

function countdowwn(element) {
    let e = element.attr('time-end');
    let l = new Date(e).getTime();
    let n = setInterval(function () {
        let e = new Date().getTime();
        let t = l - e;
        let a = Math.floor(t / 864e5);
        let s = Math.floor((t % 864e5) / 36e5);
        let o = Math.floor((t % 36e5) / 6e4);
        e = Math.floor((t % 6e4) / 1e3);

        element.html(`
                    <span>${a}</span>
                    :
                    <span>${s}</span>
                    :
                    <span>${o}</span>
                    :
                    <span>${e}</span>
                `);

        if (t < 0) {
            clearInterval(n), element.html("Đã hết khuyến mại")
        };

    }, 1e3);
}

$('#form_filter').submit(function () {
    $(this).find('input').each(function () {
        if ($(this).val() === '') {
            $(this).remove(); // Loại bỏ input
            // $(this).prop('disabled', true); // Vô hiệu hóa input
        }
    });
});

$('.slide-template-slick').slick({
    slidesToShow: 4,
    slidesToScroll: 4,
    arrows: true,
    dots: false,
    infinite: true,
    autoplay: true,
    responsive: [
        {
            breakpoint: 960,
            settings: {
                slidesToShow: 2.5,
                slidesToScroll: 2
            }
        }
    ]
});
window.orderProduct = function (id_prd) {
    var quantity = $("#quantity").val();
    if(quantity < 1){
        alert('Số lượng không thể ít hơn 1');
        $('#quantity-'+id_prd).val(1);
    }else{
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: window.addToCart,
            data: {
                quantity: quantity?quantity:1,
                id: id_prd,
                _token: $('meta[name="csrf-token"]').attr("content")
            },
            success: function (data) {
                $("#number-added-cart").html(data.total);
                Swal.fire(
                    'Thành công!',
                    'Thêm vào giỏ hàng thành công',
                    'success'
                )
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Có lỗi xảy ra, Không thành công',
                })
            }
        });
    }
}