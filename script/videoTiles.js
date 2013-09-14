function initMonthWidget() {
	$("#monthWidgetContainer").hide();

	$("#monthWidgetBox").mouseover(function(){
		$("#monthWidgetContainer").fadeIn("500");
	});
	
	$("#monthWidgetContainer").mouseleave(function() {
		$("#monthWidgetContainer").fadeOut("500");
	});
	
	$("#monthWidgetContainer ul li").click(function() {
		listIndex = $(this).index() + 1;
		loadTiles('2013',listIndex,undefined);
	});
}

function initCaptions() {
	$(".imageBoxCaption").mouseover(function(){
		$(this).next().animate({top: "50%"}, 200);
	});
	$(".imageDetails").mouseleave(function(){
		$(this).animate({top: "100%"}, 200);
	});
}

function initFancyBox() {
$('.fancybox-audio-mixcloud').bind('click',function() 
	{
		$.fancybox(
		{
			'padding'		: 10,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'width'			: '80%',
			'height'		: '35%',
			'href'			: this.href,
			'type'			: 'iframe'
		});

		return false;
	});
}