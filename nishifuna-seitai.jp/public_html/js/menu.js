$(function(){
	$(".type2 #nav li").hover(
		function(){
			$(this).find('ul:first').css({visibility: "visible",display: "block"});
		},
		function(){
			$(this).find('ul:first').css({visibility: "hidden"});
		});
});

