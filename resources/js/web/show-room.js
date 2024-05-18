$(document).ready(function () {
    $("#myTab-cat li").click(function (e) {
        $("#myTab-cat li").removeClass("active");
        $(this).addClass("active");
        var id = $(this).attr("data-id");
        $(".tab-content-cat .tab-pane-cat").removeClass("active");
        $("#" + id).addClass("active");
        e.preventDefault();
    });
    $("#province").change(function () {
        $("option").removeClass("selected");
        $("option:selected").addClass("selected");
    });

    $("#search-showroom").on("input", function () {
        var keyword = $(this).val().trim().toLowerCase();

        // Lặp qua các showroom và lọc dựa trên từ khóa
        $("#myTab-cat li").each(function () {
            var name = $(this)
                .find(".name-showroom")
                .text()
                .trim()
                .toLowerCase();
            var address = $(this)
                .find(".address span")
                .text()
                .trim()
                .toLowerCase();

            // Hiển thị/ẩn showroom dựa trên từ khóa
            if (name.includes(keyword) || address.includes(keyword)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Hiển thị thông báo khi không có showroom phù hợp
        if ($("#myTab-cat li:visible").length === 0) {
            $("#myTab-cat").append(
                '<li class="no-showroom">Không tìm thấy showroom phù hợp</li>'
            );
        } else {
            $(".no-showroom").remove();
        }
    });
});

$("#province").change(function () {
    var selectedCityId = $(this).val(); // Lấy giá trị đã chọn trong select

    var anyDisplayed = false; // Biến kiểm tra xem có phần tử nào được hiển thị hay không

    // Hiển thị/ẩn các phần tử <li> dựa trên giá trị đã chọn
    $("#myTab-cat li").each(function () {
        var dataId = $(this).attr("data-id");
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

    // Hiển thị thông báo khi không có phần tử nào được hiển thị
    if (!anyDisplayed) {
        $("#myTab-cat").append(
            '<li class="no-showroom">Không có cửa hàng ở tỉnh thành này</li>'
        );
    } else {
        $(".no-showroom").remove(); // Xóa thông báo nếu có
    }
});
