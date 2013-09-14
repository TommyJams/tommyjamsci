
$(document).ready(function() 
{
	
	/**************************************************************************/
	/*	Template options													  */
	/**************************************************************************/
	
	var options=
	{
		supersized		:
		{
			slide		: 
			[
				{image	: 'image/background/05.jpg'},
				{image	: 'image/background/07.jpg'}
			]		
		}
	}

	/**************************************************************************/
	/*	Supersized															  */
	/**************************************************************************/

	$.supersized(
	{
		slides					: options.supersized.slide,
		autoplay				: true,
		thumb_links				: false,
		start_slide				: 1,
		thumbnail_navigation	: false
	});	

	$('#voting-form').bind('submit',function(e) 
	{
		e.preventDefault();
		submitVotingForm();
	});

	$('textarea').elastic();
	$('form label').inFieldLabels();

	/**************************************************************************/
	/*	Image preloader														  */
	/**************************************************************************/

	$('.preloader img').each(function() 
	{
		$(this).attr('src',$(this).attr('src') + '?i='+getRandom(1,100000));
		$(this).bind('load',function() 
		{ 
			$(this).parent().first().css('background-image','none'); 
			$(this).animate({opacity:1},1000); 
		});
	});

});

