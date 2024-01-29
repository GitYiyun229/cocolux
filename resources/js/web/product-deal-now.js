require('../bootstrap');
import $ from "jquery";
window.$ = $;
import 'bootstrap';
import swal from 'sweetalert2';
window.Swal = swal;

require('./template');
require('./main');

$(".count-down").each(function (e) {
    countdowwn($(this));
});

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
            <span>Còn ${a} ngày</span>

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
