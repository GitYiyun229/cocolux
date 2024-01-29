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

eval("$(document).ready(function () {\n  $('.item-parent, .item-child').on('click', function () {\n    var selectedItem = $(this).data('value');\n    $('#cat_product').val(selectedItem);\n  });\n  $('#search_product').submit(function () {\n    $(this).find('input').each(function () {\n      if ($(this).val() === '') {\n        $(this).remove();\n      }\n    });\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsIm9uIiwic2VsZWN0ZWRJdGVtIiwiZGF0YSIsInZhbCIsInN1Ym1pdCIsImZpbmQiLCJlYWNoIiwicmVtb3ZlIl0sInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9qcy93ZWIvbWFpbi5qcz84YTcyIl0sInNvdXJjZXNDb250ZW50IjpbIiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuICAgICQoJy5pdGVtLXBhcmVudCwgLml0ZW0tY2hpbGQnKS5vbignY2xpY2snLCBmdW5jdGlvbigpIHtcbiAgICAgICAgdmFyIHNlbGVjdGVkSXRlbSA9ICQodGhpcykuZGF0YSgndmFsdWUnKTtcbiAgICAgICAgJCgnI2NhdF9wcm9kdWN0JykudmFsKHNlbGVjdGVkSXRlbSk7XG4gICAgfSk7XG4gICAgJCgnI3NlYXJjaF9wcm9kdWN0Jykuc3VibWl0KGZ1bmN0aW9uICgpIHtcbiAgICAgICAgJCh0aGlzKS5maW5kKCdpbnB1dCcpLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgaWYgKCQodGhpcykudmFsKCkgPT09ICcnKSB7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5yZW1vdmUoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfSk7XG59KTtcbiJdLCJtYXBwaW5ncyI6IkFBQUFBLENBQUMsQ0FBQ0MsUUFBUSxDQUFDLENBQUNDLEtBQUssQ0FBQyxZQUFXO0VBQ3pCRixDQUFDLENBQUMsMkJBQTJCLENBQUMsQ0FBQ0csRUFBRSxDQUFDLE9BQU8sRUFBRSxZQUFXO0lBQ2xELElBQUlDLFlBQVksR0FBR0osQ0FBQyxDQUFDLElBQUksQ0FBQyxDQUFDSyxJQUFJLENBQUMsT0FBTyxDQUFDO0lBQ3hDTCxDQUFDLENBQUMsY0FBYyxDQUFDLENBQUNNLEdBQUcsQ0FBQ0YsWUFBWSxDQUFDO0VBQ3ZDLENBQUMsQ0FBQztFQUNGSixDQUFDLENBQUMsaUJBQWlCLENBQUMsQ0FBQ08sTUFBTSxDQUFDLFlBQVk7SUFDcENQLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ1EsSUFBSSxDQUFDLE9BQU8sQ0FBQyxDQUFDQyxJQUFJLENBQUMsWUFBWTtNQUNuQyxJQUFJVCxDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNNLEdBQUcsQ0FBQyxDQUFDLEtBQUssRUFBRSxFQUFFO1FBQ3RCTixDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNVLE1BQU0sQ0FBQyxDQUFDO01BQ3BCO0lBQ0osQ0FBQyxDQUFDO0VBQ04sQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL3dlYi9tYWluLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/web/main.js\n");

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