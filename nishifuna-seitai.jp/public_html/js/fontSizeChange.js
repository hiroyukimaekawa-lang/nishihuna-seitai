(function(){window.setting={styling:"#wrapper.small {font-size:100%;}"}; if(setting.styling){var a=document.createElement("style"),b=document.getElementsByTagName("head")[0];a.type="text/css";try{a.appendChild(document.createTextNode(setting.styling))}catch(c){if(a.styleSheet)a.styleSheet.cssText=setting.styling}b.insertBefore(a, b.firstChild)}})();
(function(){window.setting={styling:"#wrapper.middle {font-size:120%;}"}; if(setting.styling){var a=document.createElement("style"),b=document.getElementsByTagName("head")[0];a.type="text/css";try{a.appendChild(document.createTextNode(setting.styling))}catch(c){if(a.styleSheet)a.styleSheet.cssText=setting.styling}b.insertBefore(a, b.firstChild)}})();
(function(){window.setting={styling:"#wrapper.large {font-size:140%;}"}; if(setting.styling){var a=document.createElement("style"),b=document.getElementsByTagName("head")[0];a.type="text/css";try{a.appendChild(document.createTextNode(setting.styling))}catch(c){if(a.styleSheet)a.styleSheet.cssText=setting.styling}b.insertBefore(a, b.firstChild)}})();


jQuery(function($){
	var history = $.cookie('fontSize');
	var elm = $('#wrapper');
	(!history)? elm.addClass('middle'):elm.addClass(history);
	$('a','#fontSizeChange').click(function(){
		var setFontSize = this.id;
		$.cookie('fontSize', setFontSize , { path: '/'});
		elm.removeClass('small').removeClass('middle').removeClass('large').addClass(setFontSize);
	});
	
	$('a','.fontSizeChangeWidget').click(function(){
		var setFontSize = this.id;
		$.cookie('fontSize', setFontSize , { path: '/'});
		elm.removeClass('small').removeClass('middle').removeClass('large').addClass(setFontSize);
	});

});


