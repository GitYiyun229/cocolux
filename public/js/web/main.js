/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/web/main.js":
/*!**********************************!*\
  !*** ./resources/js/web/main.js ***!
  \**********************************/
/***/ (() => {

eval("$(document).ready(function () {\n  // var fixmeTop = $('.navbar-finalstyle').offset().top;\n  // console.log(fixmeTop);\n  $(window).scroll(function () {\n    var currentScroll = $(window).scrollTop();\n    if (currentScroll >= 30) {\n      $('.navbar-finalstyle').addClass('active-menu');\n    } else {\n      $('.navbar-finalstyle').removeClass('active-menu');\n    }\n  });\n  new Mmenu(document.querySelector(\"#menu-mobile\"));\n  $('#change_locale').on('change', function () {\n    window.location = $(this).val();\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvd2ViL21haW4uanMuanMiLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsIndpbmRvdyIsInNjcm9sbCIsImN1cnJlbnRTY3JvbGwiLCJzY3JvbGxUb3AiLCJhZGRDbGFzcyIsInJlbW92ZUNsYXNzIiwiTW1lbnUiLCJxdWVyeVNlbGVjdG9yIiwib24iLCJsb2NhdGlvbiIsInZhbCJdLCJzb3VyY2VSb290IjoiIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL3dlYi9tYWluLmpzPzhhNzIiXSwic291cmNlc0NvbnRlbnQiOlsiJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG4gICAgLy8gdmFyIGZpeG1lVG9wID0gJCgnLm5hdmJhci1maW5hbHN0eWxlJykub2Zmc2V0KCkudG9wO1xuICAgIC8vIGNvbnNvbGUubG9nKGZpeG1lVG9wKTtcbiAgICAkKHdpbmRvdykuc2Nyb2xsKGZ1bmN0aW9uKCkge1xuICAgICAgICB2YXIgY3VycmVudFNjcm9sbCA9ICQod2luZG93KS5zY3JvbGxUb3AoKTtcbiAgICAgICAgaWYgKGN1cnJlbnRTY3JvbGwgPj0gMzApIHtcbiAgICAgICAgICAgICQoJy5uYXZiYXItZmluYWxzdHlsZScpLmFkZENsYXNzKCdhY3RpdmUtbWVudScpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJCgnLm5hdmJhci1maW5hbHN0eWxlJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZS1tZW51Jyk7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgIG5ldyBNbWVudShkb2N1bWVudC5xdWVyeVNlbGVjdG9yKFwiI21lbnUtbW9iaWxlXCIpKTtcblxuICAgICQoJyNjaGFuZ2VfbG9jYWxlJykub24oJ2NoYW5nZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgd2luZG93LmxvY2F0aW9uID0gICQodGhpcykudmFsKCk7XG4gICAgfSlcbn0pO1xuIl0sIm1hcHBpbmdzIjoiQUFBQUEsQ0FBQyxDQUFDQyxRQUFRLENBQUMsQ0FBQ0MsS0FBSyxDQUFDLFlBQVc7RUFDekI7RUFDQTtFQUNBRixDQUFDLENBQUNHLE1BQU0sQ0FBQyxDQUFDQyxNQUFNLENBQUMsWUFBVztJQUN4QixJQUFJQyxhQUFhLEdBQUdMLENBQUMsQ0FBQ0csTUFBTSxDQUFDLENBQUNHLFNBQVMsRUFBRTtJQUN6QyxJQUFJRCxhQUFhLElBQUksRUFBRSxFQUFFO01BQ3JCTCxDQUFDLENBQUMsb0JBQW9CLENBQUMsQ0FBQ08sUUFBUSxDQUFDLGFBQWEsQ0FBQztJQUNuRCxDQUFDLE1BQU07TUFDSFAsQ0FBQyxDQUFDLG9CQUFvQixDQUFDLENBQUNRLFdBQVcsQ0FBQyxhQUFhLENBQUM7SUFDdEQ7RUFDSixDQUFDLENBQUM7RUFFRixJQUFJQyxLQUFLLENBQUNSLFFBQVEsQ0FBQ1MsYUFBYSxDQUFDLGNBQWMsQ0FBQyxDQUFDO0VBRWpEVixDQUFDLENBQUMsZ0JBQWdCLENBQUMsQ0FBQ1csRUFBRSxDQUFDLFFBQVEsRUFBRSxZQUFZO0lBQ3pDUixNQUFNLENBQUNTLFFBQVEsR0FBSVosQ0FBQyxDQUFDLElBQUksQ0FBQyxDQUFDYSxHQUFHLEVBQUU7RUFDcEMsQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDIn0=\n//# sourceURL=webpack-internal:///./resources/js/web/main.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/web/main.js"]();
/******/ 	
/******/ })()
;