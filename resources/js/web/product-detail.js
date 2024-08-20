import $ from "jquery";
window.$ = $;
import "bootstrap";
import "owl.carousel";

import swal from "sweetalert2";
window.Swal = swal;
import "slick-carousel";
require("./template");
require("./main");

$(".btn-slide-next").click(function (e) {
    changeSlide(e, 1);
});

$(".btn-slide-prev").click(function (e) {
    changeSlide(e, -1);
});

function changeSlide(e, type) {
    e.preventDefault();

    let currentElement = $(".modal-thumbnail-item.active");
    let index = parseInt(currentElement.attr("data-index"));
    let total = $(".modal-thumbnail-item").length;
    let changeIndex;

    if (type > 0) {
        changeIndex = index + 1 >= total ? 0 : index + 1;
    } else {
        changeIndex = index == 0 ? total - 1 : index - 1;
    }

    $(".modal-thumbnail-item.thumbnail-item-" + changeIndex).click();
}

$(".submit-image").click(function (e) {
    e.preventDefault();
    $("#image").click();
});

$("#image").change(function () {
    const files = this.files;
    const maxAllowedFiles = 5;

    $(".list-image-review").empty();

    if (files.length > 5) {
        console.log("Chỉ được up tối đa 5 ảnh");
    }

    for (let i = 0; i < Math.min(maxAllowedFiles, files.length); i++) {
        const file = files[i];
        const image = $(
            '<img class="img-fluid" width="50" height="50">'
        ).addClass("uploaded-image");
        const reader = new FileReader();
        reader.onload = function (e) {
            image.attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
        $(".list-image-review").append(image);
    }
});

$(".submit-review").click(function (e) {
    // e.preventDefault();
    let content = $("#content").val();
    let rate = $("#rate").val();
    let phone = $("#phone").val();
    let name = $("#name").val();
    const regexTel = /^0\d{9}$/;

    $(".review-rating p").remove();
    $("#content").next("p").remove();
    $(".phone p").remove();
    $("#name").next("p").remove();
    if (rate == 0) {
        $(".review-rating").append(
            '<p class="position-absolute text-danger m-0" style="left: 150px; font-size: 14px">Vui lòng đánh giá sản phẩm.</p>'
        );
        return false;
    }
    if (!content.trim()) {
        $("#content").focus();
        $(
            '<p class="mb-2 text-danger">Vui lòng nhập nội dung đánh giá của bạn.</p>'
        ).insertAfter("#content");
        return false;
    }
    if (!name.trim()) {
        $("#name").focus();
        $(
            '<p class="mb-2 text-danger">Vui lòng nhập tên của bạn.</p>'
        ).insertAfter("#name");
        return false;
    }
    if (!phone.trim()) {
        $("#phone").focus();
        $(
            '<p class="mb-2 text-danger">Vui lòng nhập số điện thoại của bạn.</p>'
        ).insertAfter("#phone");
        return false;
    }

    // if(regexTel.test(phone.value) == false) {
    //     $('<p class="mb-2 text-danger">Số điện thoại gồm 10 số, nhập lại số điện thoại.</p>').insertAfter("#phone");
    //     return false;
    // }

    // $(this).closest('form').submit();
});

$("#content").on("click", function () {
    // Hiển thị các ô input name và phone khi click vào textarea
    $(".name-field, .phone-field").show();
});

$(".review-rating-item").hover(
    function () {
        toggleStar(parseInt($(this).attr("value")));
    },
    function () {
        toggleStar(parseInt($("#rate").val()));
    }
);

$(".review-rating-item").click(function () {
    let value = parseInt($(this).attr("value"));
    $("#rate").val(value);
    toggleStar(value);
});

function toggleStar(value) {
    $(`.review-rating-item`).removeClass("active");
    for (let i = 1; i <= value; i++) {
        $(`.review-rating-item:eq(${i - 1})`).addClass("active");
    }
}

$(".nav-link-detail").click(function (e) {
    e.preventDefault();
    let target = $(this).attr("href");
    target = target.replace(/.+(?=#)/g, "");
    $("html, body")
        .css("scroll-behavior", "auto")
        .animate(
            {
                scrollTop: $(target).offset().top - 120,
            },
            800
        );
});

$(".detail-address").mouseenter(function () {
    $(this).dropdown("show");
});

$(".detail-address").mouseleave(function () {
    $(this).dropdown("hide");
});

$(".thumbnail-item").click(function () {
    let src = $(this).find("img").attr("src");
    let index = $(this).attr("data-index");

    $(".detail-thumbnail-image").attr("src", src);
    $(".detail-thumbnail-image-modal").attr("src", src);
    $(".detail-thumbnail-image-modal-webp").attr("srcset", src);

    $(".thumbnail-item").removeClass("active");
    $(".modal-thumbnail-item").removeClass("active");
    $(".thumbnail-item-" + index).addClass("active");
    // $(this).addClass('active');
});

$(".modal-thumbnail-item").click(function () {
    let src = $(this).find("img").attr("src");
    $(".detail-thumbnail-image-modal").attr("src", src);
    $(".detail-thumbnail-image-modal-webp").attr("srcset", src);
    $(".modal-thumbnail-item").removeClass("active");
    $(this).addClass("active");
});

$(".count-down").each(function (e) {
    countdowwn($(this));
});

$(document).on("scroll", onScroll);

function onScroll(event) {
    let scrollPos = $(document).scrollTop();
    $(".nav-link-detail").each(function () {
        let currLink = $(this);
        let refElement = $(currLink.attr("href"));
        if (
            refElement.position().top - 140 <= scrollPos &&
            refElement.position().top - 140 + refElement.height() > scrollPos
        ) {
            $(".nav-link-detail").removeClass("active");
            currLink.addClass("active");
        } else {
            currLink.removeClass("active");
        }
    });
}

function countdowwn(element) {
    let e = element.attr("time-end");
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
            clearInterval(n), element.html("Đã hết khuyến mại");
        }
    }, 1e3);
}

$("#form_filter").submit(function () {
    $(this)
        .find("input")
        .each(function () {
            if ($(this).val() === "") {
                $(this).remove(); // Loại bỏ input
                // $(this).prop('disabled', true); // Vô hiệu hóa input
            }
        });
});

$(".slide-template-slick").slick({
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
                slidesToScroll: 2,
            },
        },
    ],
});
window.orderProduct = function (id_prd) {
    var quantity = $("#quantity").val();
    if (quantity < 1) {
        alert("Số lượng không thể ít hơn 1");
        $("#quantity-" + id_prd).val(1);
    } else {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: window.addToCart,
            data: {
                quantity: quantity ? quantity : 1,
                id: id_prd,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                $("#number-added-cart").html(data.total);
                Swal.fire(
                    "Thành công!",
                    "Thêm vào giỏ hàng thành công",
                    "success"
                );
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Có lỗi xảy ra, Không thành công",
                });
            },
        });
    }
};
$(".btn-copy").click(function () {
    let value = $(this).data("coupon");
    let temp = $("<input>");
    $("body").append(temp);
    temp.val(value).select();
    try {
        document.execCommand("copy");
        console.log("Text copied to clipboard successfully");
        Swal.fire("Thành công!", "Copy thành công", "success");
    } catch (err) {
        console.error("Error copying text to clipboard:", err);
    } finally {
        temp.remove();
    }
});
$(".modal-footer #coupon-end, .modal-body #coupon-here").click(function () {
    const coupon_here = document.querySelector(
        ".modal-body #coupon-here #coupon-modal"
    );

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

        Swal.fire("Thành công!", "Copy thành công", "success");
    } catch (err) {
        console.error("Error copying text to clipboard:", err);
    } finally {
        // Xóa lựa chọn
        selection.removeAllRanges();
    }
});

$(".btn-value").click(function () {
    let value = $(this).data("value-coupon");
    $(".modal-body #name-coupon").text("Giảm " + value.value);
    $(".modal-body #des-coupon").text(value.name);
    $(".modal-body #coupon-modal").text(value.items.code);
    $(".modal-body #coupon-here").data("coupon", value.items.code);
    $(".modal-footer #coupon-end").data("coupon", value.items.code);
    $(".modal-body #startDate").text(value.start_date);
    $(".modal-body #endDate").text(value.end_date);
    $(".modal-body #show_date").text(value.start_date + "- " + value.end_date);
    $(".modal-body #description-coupon").text(value.description);
    if (value.options === 1) {
        $(".modal-body .infomotion-coupon-option").show();
    } else {
        $(".modal-body .infomotion-coupon-option").hide();
    }
});
$(".slide-template-slide-coupon-pc").owlCarousel({
    loop: false,
    rewind: true,
    dots: false,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
            nav: true,
        },
        600: {
            items: 2,
            nav: false,
        },
        1000: {
            items: 4,
            nav: true,
            loop: false,
        },
    },
});
