
$(document).ready(function() 
{
	
	/**************************************************************************/
	/*	Template options													  */
	/**************************************************************************/
	
	var options=
	{
		twitter:
		{
			name		:	'tommyjams',
			count		:	10
		},
		supersized		:
		{
			slide		: 
			[
				{image	: 'image/background/05.jpg'},
				{image	: 'image/background/07.jpg'}
			]		
		},
		googleMap		:
		{
			coordinates	:	[53.276698,-6.12562]
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
	
	/**************************************************************************/
	/*	Accordion															  */
	/**************************************************************************/

	$('.nostalgia-accordion').accordion(
	{
		icons		: '',
		active		: 0,
		animated	: 'easeOutExpo',
		autoHeight	: false,
		collapsible	: true
	});
	
	/**************************************************************************/
	/*	Google Maps															  */
	/**************************************************************************/
	/*
	try
	{
		var coordinate=new google.maps.LatLng(options.googleMap.coordinates[0],options.googleMap.coordinates[1]);

		var mapOptions= 
		{
			zoom				: 15,
			center				: coordinate,
			streetViewControl	: false,
			mapTypeControl		: false,
			zoomControlOptions	: 
			{
				position		: google.maps.ControlPosition.RIGHT_CENTER
			},
			panControlOptions: 
			{
				position		: google.maps.ControlPosition.LEFT_CENTER
			},
			mapTypeId			: google.maps.MapTypeId.ROADMAP
		};

		var googleMap=new google.maps.Map(document.getElementById('map'),mapOptions);
		
		var markerOptions=
		{
			map:googleMap,
			position:coordinate,
			icon:'image/map_pointer.png'
		}

		var googleMarker=new google.maps.Marker(markerOptions);
		
	}
	catch(e) {}	
	*/
	/**************************************************************************/
	/*	Forms																  */
	/**************************************************************************/
	
	$('#contact-form').bind('submit',function(e) 
	{
		e.preventDefault();
		submitContactForm();
	});
	
	$('#newsletter-form').bind('submit',function(e) 
	{
		e.preventDefault();
		submitNewsletterForm();
	});
	
	$('textarea').elastic();
	$('form label').inFieldLabels();
	
	/**************************************************************************/
	/*	Contact details button												  */
	/**************************************************************************/
	
	$('#contact-details-button').bind('click',function(e) 
	{
		e.preventDefault();
		
		var contactDetails=$(this).parent('.contact-details');
		
		var top=parseInt(contactDetails.css('top'));
		var newTop=(top==0 ? parseInt(contactDetails.height()) : 0);

		contactDetails.animate({top:-1*newTop},{duration:100,complete:function() 
		{
			
		}});
	});
	
	/**************************************************************************/
	/*	Twitter																  */
	/**************************************************************************/
	
	//$.getJSON('http://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='+options.twitter.name+'&count='+options.twitter.count+'&callback=?', function(data) 
	$.getJSON('twitterproxy/twitterhandle', function(data) 
    {
		if(data.length)
		{
			var list=$('<ul>');
			$(data).each(function(index,value)
			{
				list.append($('<li>').append($('<p>').html(linkify(value.text))));
			});

			$('#latest-tweets').append(list);

			$('#latest-tweets ul').carouFredSel(
			{
				circular		:	true,
				direction		:	'up',
				items: 
				{
					visible		: 1,
					minimum		: 1
				},
				scroll: 
				{
					items		: 1,
					duration	: 750,
					fx			: 'cover'
				}
			});	
			
			setTwitterDimension();
		}
	});		
		
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
	
	/**************************************************************************/
	/*	Image carousel														  */
	/**************************************************************************/
	
	$('.image-list.image-list-carousel').carouFredSel(
	{
		circular		:	true,
		direction		:	'left',
		items: 
		{
			visible		: 4,
			minimum		: 1
		},
		scroll: 
		{
			items		: 1,
			duration	: 750
		},
		prev			: $('.image-list.image-list-carousel').nextAll('.image-list-carousel-navigation-prev'),
		next			: $('.image-list.image-list-carousel').nextAll('.image-list-carousel-navigation-next')
	});	
	
	setImageListDimension();
	
	/**************************************************************************/
	/*	Fancybox for images													  */
	/**************************************************************************/
	
	$('.fancybox-image').fancybox({});

	/**************************************************************************/
	/*	Fancybox for youtube videos											  */
	/**************************************************************************/

	$('.fancybox-video-youtube').bind('click',function() 
	{
		$.fancybox(
		{
			'padding'		: 10,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'width'			: '90%',
			'height'		: '90%',
			'href'			: this.href,
			'type'			: 'iframe'
		});

		return false;
	});

	/**************************************************************************/
	/*	Fancybox for vimeo videos											  */
	/**************************************************************************/

	$('.fancybox-video-vimeo').bind('click',function() 
	{
		$.fancybox(
		{
			'margin'		: 0,
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'width'			: '90%',
			'height'		: '90%',
			'href'			: this.href,
			'type'			: 'iframe'
		});

		return false;
	});
	
	/**************************************************************************/
	/*	Fancybox for soundcloud audio										  */
	/**************************************************************************/

	$('.fancybox-audio-soundcloud').bind('click',function() 
	{
		$.fancybox(
		{
			'padding'		: 10,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'width'			: '90%',
			'height'		: '33%',
			'href'			: this.href,
			'type'			: 'iframe'
		});

		return false;
	});
	
	/**************************************************************************/
	/*	Fancybox for mixcloud audio											  */
	/**************************************************************************/

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
	
	/**************************************************************************/
	/*	"Clik here" caption													  */
	/**************************************************************************/
	
	blink($('.click-here'));
	
	/**************************************************************************/
	/*	Window resize														  */
	/**************************************************************************/
	
	$(window).resize(function() 
	{
		setTwitterDimension();
		setImageListDimension();
		//googleMap.setCenter(googleMarker.getPosition());
	});
	
	/**************************************************************************/
	
	initLeftSidebar();
});

function initLeftSidebar() {
	$("#leftSidebarBox").hide();

	$("#leftSidebarSmall").mouseover(function(){
		$("#leftSidebarBox").show();
		$("#leftSidebarSmall").animate({left: "-40px"}, 0 );
		$("#leftSidebarBox").animate({left: "0px"}, 500 );
	});

	$("#leftSidebarBox").mouseleave(function() {
		$("#leftSidebarBox").animate({left: "-40px"}, 500 );
		$("#leftSidebarSmall").animate({left: "0px"}, 500 );
	});
}