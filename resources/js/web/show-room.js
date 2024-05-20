$(document).ready(function () {
    $("#myTab-cat li").click(function (e) {
        $("#myTab-cat li").removeClass("active");
        $(this).addClass("active");
        var id = $(this).attr("data-code");
        var id1 = $(this).attr("data-id");
        $(".tab-content-cat .tab-pane-cat").removeClass("active");
        $("#" + id1).addClass("active");
        e.preventDefault();
    });
    $("#province").change(function () {
        $("option").removeClass("selected");
        $("option:selected").addClass("selected");
    });
    $("#district").change(function () {
        $("option").removeClass("selected");
        $("option:selected").addClass("selected");
    });
});

$("#province").change(function () {
    var selectedCityId = $(this).val(); // Lấy giá trị đã chọn trong select

    var anyDisplayed = false; // Biến kiểm tra xem có phần tử nào được hiển thị hay không

    // Hiển thị/ẩn các phần tử <li> dựa trên giá trị đã chọn
    $("#myTab-cat li").each(function () {
        var dataId = $(this).attr("data-code");
        if (
            selectedCityId === "0" ||
            dataId === "profile-cat-" + selectedCityId
        ) {
            $(this).show();
            anyDisplayed = true;
        } else {
            $(this).hide();
        }
    });
    $("#district option").each(function () {
        var dataId = $(this).attr("data-city");
        if (
            selectedCityId === "0" ||
            dataId === "profile-cat-" + selectedCityId
        ) {
            $(this).show();
            anyDisplayed = true;
        } else {
            $(this).hide();
        }
    });
    $("#district").val("");
    // Hiển thị thông báo khi không có phần tử nào được hiển thị
    if (!anyDisplayed) {
        $("#myTab-cat").append(
            '<li class="no-showroom">Không có cửa hàng ở tỉnh thành này</li>'
        );
    } else {
        $(".no-showroom").remove(); // Xóa thông báo nếu có
    }
});
$("#district").change(function () {
    var selectedDistrictId = $(this).val(); // Lấy giá trị đã chọn trong select

    var anyDisplayed = false; // Biến kiểm tra xem có phần tử nào được hiển thị hay không

    // Hiển thị/ẩn các phần tử <li> dựa trên giá trị đã chọn
    $("#myTab-cat li").each(function () {
        var dataId = $(this).attr("data-district");
        if (
            selectedDistrictId === "0" ||
            dataId === "profile-cat-" + selectedDistrictId
        ) {
            $(this).show();
            anyDisplayed = true;
        } else {
            $(this).hide();
        }
    });
    // Hiển thị thông báo khi không có phần tử nào được hiển thị
    if (!anyDisplayed) {
        $("#myTab-cat").append(
            '<li class="no-showroom">Không có cửa hàng ở tỉnh thành này</li>'
        );
    } else {
        $(".no-showroom").remove(); // Xóa thông báo nếu có
    }
});
