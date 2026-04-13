jQuery(function(){
	var groups = new Array();
	jQuery('a[rel^=lightbox]').each(function(){
		var rel = jQuery(this).attr('rel');
		if(!groups[rel]){
			jQuery('a[rel=' + rel + ']').lightBox();
			groups[rel] = 1;
		}
	});
});
