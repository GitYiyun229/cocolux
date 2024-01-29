require('../bootstrap');
import $ from "jquery";
window.$ = $;
import 'bootstrap';
import swal from 'sweetalert2';
window.Swal = swal;
import 'slick-carousel';
import LazyLoad from "vanilla-lazyload";

require('./template');
require('./main');

var lazyLoadInstance = new LazyLoad({
    // Your custom settings go here
});
$('.banner-slick').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: true,
    infinite: true,
    autoplay: true,

});

$('.section-store-main').slick({
    slidesToShow: 6,
    slidesToScroll: 6,
    dots: false,
    arrows: false,
    infinite: true,
    autoplay: true,
    speed: 500,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 6,
                slidesToScroll: 6,
            }
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
            }
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
            }
        }
    ]

});

$('.slide-template-slick').slick({
    slidesToShow: 5,
    slidesToScroll: 5,
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

$('.slide-template-slick-coupon').slick({
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
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        }
    ]
});

$(".count-down").each(function (e) {
    countdowwn($(this));
});

function countdowwn(element) {
    let is_title = element.attr('is-title');
    let e = element.attr('time-end');
    let l = new Date(e).getTime();
    let n = setInterval(function () {
        let e = new Date().getTime();
        let t = l - e;
        let a = Math.floor(t / 864e5);
        let s = Math.floor((t % 864e5) / 36e5);
        let o = Math.floor((t % 36e5) / 6e4);
        e = Math.floor((t % 6e4) / 1e3);

        if (is_title) {
            element.html(`
                        <span>${a}</span>
                        :
                        <span>${s}</span>
                        :
                        <span>${o}</span>
                        :
                        <span>${e}</span>
                    `);
        } else {
            element.html(`
                        <span>Còn ${a} ngày</span>

                        <span>${s}</span>
                        :
                        <span>${o}</span>
                        :
                        <span>${e}</span>
                    `);
        }

        if (t < 0) {
            clearInterval(n), element.html("Đã hết khuyến mại")
        };

    }, 1e3);
}

$('.btn-copy').click(function(){
    let value = $(this).data('coupon');
    let temp = $("<input>");
    $("body").append(temp);
    temp.val(value).select();
    try {
        document.execCommand("copy");
        console.log('Text copied to clipboard successfully');
        Swal.fire(
            'Thành công!',
            'Copy thành công',
            'success'
        );
    } catch (err) {
        console.error('Error copying text to clipboard:', err);
    } finally {
        temp.remove();
    }
})

$('.modal-footer #coupon-end, .modal-body #coupon-here').click(function() {
    const coupon_here = document.querySelector(".modal-body #coupon-here #coupon-modal");

    // Tạo một đối tượng Range để chọn nội dung của phần tử
    const range = document.createRange();
    range.selectNode(coupon_here);

    // Lựa chọn nội dung của phần tử
    const selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);

    try {
        document.execCommand("copy");

        // Kiểm tra xem nếu có clipboardData
        if (event.clipboardData) {
            event.clipboardData.setData("text/plain", coupon_here.textContent);
        }

        Swal.fire(
            'Thành công!',
            'Copy thành công',
            'success'
        );
    } catch (err) {
        console.error('Error copying text to clipboard:', err);
    } finally {
        // Xóa lựa chọn
        selection.removeAllRanges();
    }
});

$('.btn-value').click(function(){
    let value = $(this).data('value-coupon');
    $(".modal-body #name-coupon").text( 'Giảm ' + value.value );
    $(".modal-body #des-coupon").text( value.name );
    $(".modal-body #coupon-modal").text( value.items.code );
    $(".modal-body #coupon-here").data('coupon',value.items.code );
    $(".modal-footer #coupon-end").data('coupon',value.items.code );
    $(".modal-body #startDate").text( value.start_date );
    $(".modal-body #endDate").text( value.end_date );
    $(".modal-body #show_date").text( value.start_date + '- '+ value.end_date );
    $(".modal-body #description-coupon").text( value.description );
})
