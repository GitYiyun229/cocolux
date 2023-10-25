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

eval("$(document).ready(function () {\n  $('.item-parent, .item-child').on('click', function () {\n    var selectedItem = $(this).data('value');\n    $('#cat_product').val(selectedItem);\n  });\n  $('#search_product').submit(function () {\n    $(this).find('input').each(function () {\n      if ($(this).val() === '') {\n        $(this).remove();\n      }\n    });\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsIm9uIiwic2VsZWN0ZWRJdGVtIiwiZGF0YSIsInZhbCIsInN1Ym1pdCIsImZpbmQiLCJlYWNoIiwicmVtb3ZlIl0sInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9qcy93ZWIvbWFpbi5qcz84YTcyIl0sInNvdXJjZXNDb250ZW50IjpbIiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xyXG4gICAgJCgnLml0ZW0tcGFyZW50LCAuaXRlbS1jaGlsZCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgIHZhciBzZWxlY3RlZEl0ZW0gPSAkKHRoaXMpLmRhdGEoJ3ZhbHVlJyk7XHJcbiAgICAgICAgJCgnI2NhdF9wcm9kdWN0JykudmFsKHNlbGVjdGVkSXRlbSk7XHJcbiAgICB9KTtcclxuICAgICQoJyNzZWFyY2hfcHJvZHVjdCcpLnN1Ym1pdChmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgJCh0aGlzKS5maW5kKCdpbnB1dCcpLmVhY2goZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICBpZiAoJCh0aGlzKS52YWwoKSA9PT0gJycpIHtcclxuICAgICAgICAgICAgICAgICQodGhpcykucmVtb3ZlKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KTtcclxuICAgIH0pO1xyXG59KTtcclxuIl0sIm1hcHBpbmdzIjoiQUFBQUEsQ0FBQyxDQUFDQyxRQUFRLENBQUMsQ0FBQ0MsS0FBSyxDQUFDLFlBQVc7RUFDekJGLENBQUMsQ0FBQywyQkFBMkIsQ0FBQyxDQUFDRyxFQUFFLENBQUMsT0FBTyxFQUFFLFlBQVc7SUFDbEQsSUFBSUMsWUFBWSxHQUFHSixDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNLLElBQUksQ0FBQyxPQUFPLENBQUM7SUFDeENMLENBQUMsQ0FBQyxjQUFjLENBQUMsQ0FBQ00sR0FBRyxDQUFDRixZQUFZLENBQUM7RUFDdkMsQ0FBQyxDQUFDO0VBQ0ZKLENBQUMsQ0FBQyxpQkFBaUIsQ0FBQyxDQUFDTyxNQUFNLENBQUMsWUFBWTtJQUNwQ1AsQ0FBQyxDQUFDLElBQUksQ0FBQyxDQUFDUSxJQUFJLENBQUMsT0FBTyxDQUFDLENBQUNDLElBQUksQ0FBQyxZQUFZO01BQ25DLElBQUlULENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ00sR0FBRyxDQUFDLENBQUMsS0FBSyxFQUFFLEVBQUU7UUFDdEJOLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ1UsTUFBTSxDQUFDLENBQUM7TUFDcEI7SUFDSixDQUFDLENBQUM7RUFDTixDQUFDLENBQUM7QUFDTixDQUFDLENBQUMiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvd2ViL21haW4uanMiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/web/main.js\n");

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