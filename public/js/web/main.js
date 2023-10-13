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

eval("$(document).ready(function () {\n  $('.item-parent, .item-child').on('click', function () {\n    var selectedItem = $(this).data('value');\n    $('#cat_product').val(selectedItem);\n  });\n  $('#search_product').submit(function () {\n    $(this).find('input').each(function () {\n      if ($(this).val() === '') {\n        $(this).remove();\n      }\n    });\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvd2ViL21haW4uanMuanMiLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsIm9uIiwic2VsZWN0ZWRJdGVtIiwiZGF0YSIsInZhbCIsInN1Ym1pdCIsImZpbmQiLCJlYWNoIiwicmVtb3ZlIl0sInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvd2ViL21haW4uanM/OGE3MiJdLCJzb3VyY2VzQ29udGVudCI6WyIkKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICAkKCcuaXRlbS1wYXJlbnQsIC5pdGVtLWNoaWxkJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciBzZWxlY3RlZEl0ZW0gPSAkKHRoaXMpLmRhdGEoJ3ZhbHVlJyk7XG4gICAgICAgICQoJyNjYXRfcHJvZHVjdCcpLnZhbChzZWxlY3RlZEl0ZW0pO1xuICAgIH0pO1xuICAgICQoJyNzZWFyY2hfcHJvZHVjdCcpLnN1Ym1pdChmdW5jdGlvbiAoKSB7XG4gICAgICAgICQodGhpcykuZmluZCgnaW5wdXQnKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIGlmICgkKHRoaXMpLnZhbCgpID09PSAnJykge1xuICAgICAgICAgICAgICAgICQodGhpcykucmVtb3ZlKCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgIH0pO1xufSk7XG4iXSwibWFwcGluZ3MiOiJBQUFBQSxDQUFDLENBQUNDLFFBQVEsQ0FBQyxDQUFDQyxLQUFLLENBQUMsWUFBVztFQUN6QkYsQ0FBQyxDQUFDLDJCQUEyQixDQUFDLENBQUNHLEVBQUUsQ0FBQyxPQUFPLEVBQUUsWUFBVztJQUNsRCxJQUFJQyxZQUFZLEdBQUdKLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ0ssSUFBSSxDQUFDLE9BQU8sQ0FBQztJQUN4Q0wsQ0FBQyxDQUFDLGNBQWMsQ0FBQyxDQUFDTSxHQUFHLENBQUNGLFlBQVksQ0FBQztFQUN2QyxDQUFDLENBQUM7RUFDRkosQ0FBQyxDQUFDLGlCQUFpQixDQUFDLENBQUNPLE1BQU0sQ0FBQyxZQUFZO0lBQ3BDUCxDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNRLElBQUksQ0FBQyxPQUFPLENBQUMsQ0FBQ0MsSUFBSSxDQUFDLFlBQVk7TUFDbkMsSUFBSVQsQ0FBQyxDQUFDLElBQUksQ0FBQyxDQUFDTSxHQUFHLEVBQUUsS0FBSyxFQUFFLEVBQUU7UUFDdEJOLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ1UsTUFBTSxFQUFFO01BQ3BCO0lBQ0osQ0FBQyxDQUFDO0VBQ04sQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDIn0=\n//# sourceURL=webpack-internal:///./resources/js/web/main.js\n");

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