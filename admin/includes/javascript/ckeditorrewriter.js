
var FCKeditor = function(textarea_name, width, height) {
	this.textarea_name = textarea_name;
	this.width = width;
	this.height = height;
	this.Config	= new Object() ;  
}

FCKeditor.prototype.ReplaceTextarea = function () {
	CKEDITOR.replace(this.textarea_name, {
						language: this.Config["DefaultLanguage"],
						filebrowserBrowseUrl : this.Config["LinkBrowserURL"],
						filebrowserImageBrowseUrl : this.Config["ImageBrowserURL"],
						filebrowserFlashBrowseUrl : this.Config["FlashBrowserURL"],
						filebrowserWindowWidth : this.width,
						filebrowserWindowHeight : this.height
					});
}