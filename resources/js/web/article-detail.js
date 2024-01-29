require('../bootstrap');
import $ from "jquery";
window.$ = $;
import 'bootstrap';
import swal from 'sweetalert2';
window.Swal = swal;
import 'slick-carousel';
// import 'jquery.toc';

require('./template');
require('./main');

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
// $(document).ready(function() {
//     $("#toc").toc({content: ".layout-main .detail-content", headings: "h1,h2,h3,h4"});
// })

