require("./bootstrap");
import $ from "jquery";
window.$ = $;
import "bootstrap";
import swal from "sweetalert2";
window.Swal = swal;

require("./web/template");
require("./web/main");

$(".btn-value-order").click(function () {
    let value = $(this).data("value-order-nhanh");
    $(".modal-body #Id_nhanh").text(value.id);
    $(".modal-body #CreatedDateTime").text(value.createdDateTime);
    $(".modal-body #Name_MemberOrder").text(value.customerName);
    $(".modal-body #Phone_MemberPhone").text(value.customerMobile);
    $(".modal-body #Status_Name").text(value.statusName);
    let total_tamtinh = 0;
    let voucherText = "";
    if (value.couponCode !== null && value.moneyDiscount !== 0) {
        voucherText =value.couponCode +"/" + value.moneyDiscount.toLocaleString("vi-VN") +"đ";
    } else if (value.couponCode !== null) {
        voucherText = value.couponCode;
    }

    $(".modal-body #id_voucher").text(voucherText);
    $(".modal-body #id_price_vanchuyen").text(
        value.shipFee.toLocaleString("vi-VN") + "đ"
    );
    $(".modal-body #id_price_total").text(
        value.calcTotalMoney.toLocaleString("vi-VN") + "đ"
    );

    value.products.forEach(function (product) {
        // Ví dụ: thêm sản phẩm vào danh sách trong modal
        let productTotal = product.price * product.quantity;
        total_tamtinh += productTotal;
        $(".modal-body #products-list-order").append(
            `<tr><td class="overflow-hidden text-start py-2">${product.productName}</td>
            <td class="py-2">${product.price.toLocaleString("vi-VN")}đ</td>
            <td class="py-2">${product.quantity}</td>
            <td class="py-2">${(product.price * product.quantity).toLocaleString("vi-VN")}đ</td>
            </tr>`
        );
    });

    $(".modal-body #price_tamtinh").text(
        total_tamtinh.toLocaleString("vi-VN") + "đ"
    );
});
