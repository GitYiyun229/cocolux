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

eval("$(document).ready(function () {\n  $('.item-parent, .item-child').on('click', function () {\n    var selectedItem = $(this).data('value');\n    $('#cat_product').val(selectedItem);\n  });\n  $('#search_product').submit(function () {\n    $(this).find('input').each(function () {\n      if ($(this).val() === '') {\n        $(this).remove();\n      }\n    });\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvd2ViL21haW4uanMuanMiLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsIm9uIiwic2VsZWN0ZWRJdGVtIiwiZGF0YSIsInZhbCIsInN1Ym1pdCIsImZpbmQiLCJlYWNoIiwicmVtb3ZlIl0sInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvd2ViL21haW4uanM/OGE3MiJdLCJzb3VyY2VzQ29udGVudCI6WyIkKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcclxuICAgICQoJy5pdGVtLXBhcmVudCwgLml0ZW0tY2hpbGQnKS5vbignY2xpY2snLCBmdW5jdGlvbigpIHtcclxuICAgICAgICB2YXIgc2VsZWN0ZWRJdGVtID0gJCh0aGlzKS5kYXRhKCd2YWx1ZScpO1xyXG4gICAgICAgICQoJyNjYXRfcHJvZHVjdCcpLnZhbChzZWxlY3RlZEl0ZW0pO1xyXG4gICAgfSk7XHJcbiAgICAkKCcjc2VhcmNoX3Byb2R1Y3QnKS5zdWJtaXQoZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICQodGhpcykuZmluZCgnaW5wdXQnKS5lYWNoKGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgICAgaWYgKCQodGhpcykudmFsKCkgPT09ICcnKSB7XHJcbiAgICAgICAgICAgICAgICAkKHRoaXMpLnJlbW92ZSgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxufSk7XHJcbiJdLCJtYXBwaW5ncyI6IkFBQUFBLENBQUMsQ0FBQ0MsUUFBUSxDQUFDLENBQUNDLEtBQUssQ0FBQyxZQUFXO0VBQ3pCRixDQUFDLENBQUMsMkJBQTJCLENBQUMsQ0FBQ0csRUFBRSxDQUFDLE9BQU8sRUFBRSxZQUFXO0lBQ2xELElBQUlDLFlBQVksR0FBR0osQ0FBQyxDQUFDLElBQUksQ0FBQyxDQUFDSyxJQUFJLENBQUMsT0FBTyxDQUFDO0lBQ3hDTCxDQUFDLENBQUMsY0FBYyxDQUFDLENBQUNNLEdBQUcsQ0FBQ0YsWUFBWSxDQUFDO0VBQ3ZDLENBQUMsQ0FBQztFQUNGSixDQUFDLENBQUMsaUJBQWlCLENBQUMsQ0FBQ08sTUFBTSxDQUFDLFlBQVk7SUFDcENQLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ1EsSUFBSSxDQUFDLE9BQU8sQ0FBQyxDQUFDQyxJQUFJLENBQUMsWUFBWTtNQUNuQyxJQUFJVCxDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNNLEdBQUcsRUFBRSxLQUFLLEVBQUUsRUFBRTtRQUN0Qk4sQ0FBQyxDQUFDLElBQUksQ0FBQyxDQUFDVSxNQUFNLEVBQUU7TUFDcEI7SUFDSixDQUFDLENBQUM7RUFDTixDQUFDLENBQUM7QUFDTixDQUFDLENBQUMifQ==\n//# sourceURL=webpack-internal:///./resources/js/web/main.js\n");

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