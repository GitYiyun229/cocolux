/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    //Define changes to default configuration here. For example:
    config.language = 'vi';
    //config.uiColor = '#AADC6E';
	//config.extraPlugins = ‘locationmap’;
	config.locationMapPath = '/ckeditor/plugins/locationmap/';
	config.filebrowserBrowseUrl      = '/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl      = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

    config.htmlEncodeOutput = false;
    config.entities = false;
    config.allowedContent=true;
    config.pasteFromWordRemoveStyle = true;
    config.removeFormatAttributes = '';
	config.extraPlugins = 'youtube,wordcount';
    config.height = 400;
	config.allowedContent = false; // khử hết định dạng word
	config.removeButtons = 'Underline,Subscript,Superscript';
	config.format_tags = 'div;p;h1;h2;h3;pre'; //cho phép các thẻ trong ckeditor
	config.disallowedContent = '*[id]'; // ko chấp nhận các thuộc tính này trong style
	config.filebrowserUploadMethod = 'form';
	config.removeDialogTabs = 'image:advanced;link:advanced';
    config.ignoreEmptyParagraph = false;

};
