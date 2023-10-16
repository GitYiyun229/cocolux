/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    //Define changes to default configuration here. For example:
    config.language = 'vi';
    //config.uiColor = '#AADC6E';
	//config.extraPlugins = ‘locationmap’;
	config.locationMapPath = '../libraries/ckeditor/plugins/locationmap/';
	config.filebrowserBrowseUrl      = 'http://cocoluxfs.local/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = 'http://cocoluxfs.local/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = 'http://cocoluxfs.local/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl      = 'http://cocoluxfs.local/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = 'http://cocoluxfs.local/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = 'http://cocoluxfs.local/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

    config.htmlEncodeOutput = false;
    config.entities = false;
    config.allowedContent=true;
    config.pasteFromWordRemoveStyle = true;
    config.removeFormatAttributes = '';
	config.extraPlugins = 'youtube,wordcount';
    config.height = 400

};
