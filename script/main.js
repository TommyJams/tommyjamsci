
	$(document).ready(function(){

		/*$("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);*/
        
        var options=
        {
            supersized		:
            {
                slide		: 
                [
                    {
                        image	: '/images/background/OneNiteStand_resize.jpg',
                        title   : 'One Nite Stand',
                        details : 'Dance Rock',
						link	: '/blog/'
                    },
					{
                        image	: '/images/background/CrossLegacy_resize.jpg',
                        title   : 'Cross Legacy',
                        details : 'Christian Rock',
						link	: '/blog/'
                    },
                    {
                        image	: '/images/background/Solder2_resize.jpg',
                        title   : 'Solder',
                        details : '\'Feel Good\' Rock',
						link	: '/blog/'
                    },
					{
                        image	: '/images/background/parvaaz_resize.jpg',
                        title   : 'Parvaaz',
                        details : 'Kashmiri Rock',
						link	: '/blog/'
                    }
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
            slide_links             : 'name',
            thumbnail_navigation	: false
        });

		initHeader();
		initFooter();
		initMainTiles();
        initLeftSidebar();
		initRightSidebar();
	});
	
	onload=function()
	{
		var mainContainer = document.getElementById('main-container');

		var slideTextLeftMargin = 20;
		var headerLeftMargin = 20;
		var footerMargin = 35;
		var scrollBarWidth = 20;

		var footerHeight = 60;
		var totalHeight  = self.innerHeight;
		var totalWidth   = self.innerWidth;
		var mainContainerHeight = 0.95 * totalHeight;
		var mainContainerWidth  = 0.65 * totalWidth ;

		var leftyContainerHeight = mainContainerHeight - (footerMargin + footerHeight);
		var leftyContainerWidth  = mainContainerWidth;

		var footerContainerPosition = mainContainerHeight - (footerMargin + footerHeight);

		document.getElementById('main-container').style.height = mainContainerHeight+'px';
		document.getElementById('main-container').style.width  = mainContainerWidth +'px';
		document.getElementById('main-container').style.left   = (totalWidth - mainContainerWidth)/2 +'px';

		document.getElementById('logoContainer').style.width  = (totalWidth - mainContainerWidth)/2 + 'px';

		document.getElementById('slideText').style.width  = (totalWidth - mainContainerWidth)/2 - (2 * slideTextLeftMargin) + 'px';
		document.getElementById('slideText').style.height = footerHeight + 7 + 'px'; /*7: table border*/

		document.getElementById('headerBox').style.width  = (totalWidth - mainContainerWidth)/2 - (2 * headerLeftMargin) + 'px';
		document.getElementById('headerBox').style.left   = (totalWidth + mainContainerWidth)/2 + 'px';

		//document.getElementById('footerTable').style.top = footerContainerPosition+'px';

		document.getElementById('lefty').style.height = leftyContainerHeight+'px';
		document.getElementById('lefty').style.width  = leftyContainerWidth +'px';

		//document.getElementById('left').style.width = leftyContainerWidth +'px';
		
		//Google Analytics Code
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-37583663-1']);
		_gaq.push(['_trackPageview']);

		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		
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

	    $('#searchProfilesForm').bind('submit',function(e) 
	    {
	        e.preventDefault();
	        searchProfilesPage(document.getElementById('searchTextBox').value,1);
	    });

	}

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

	function initRightSidebar() {
        $("#rightSidebarBox").hide();

        $("#rightSidebarSmall").mouseover(function(){
			$("#rightSidebarSmall").fadeOut(500);
			$("#rightSidebarBox").fadeIn(500);
        });

        $("#rightSidebarBox").mouseleave(function() {
			$("#rightSidebarBox").fadeOut(500);
			$("#rightSidebarSmall").fadeIn(500);
        });
    }

	function initMainTiles()
	{
		//To switch directions up/down and left/right just place a "-" in front of the top/left attribute
		//Full Caption Sliding (Hidden to Visible)
		$('.boxgrid.captionfull').hover(function(){
			$(".cover", this).stop().animate({top:'50%'},{queue:false,duration:160});
			$(".titleSlider", this).stop().animate({left:'0px'},{queue:false,duration:160});
		}, function() {
			$(".cover", this).stop().animate({top:'100%'},{queue:false,duration:160});
			$(".titleSlider", this).stop().animate({left:'-100px'},{queue:false,duration:160});
		});
	}	

    function initHeader()
    {
		//Get all the LI from the #tabMenu UL
		$('#tabMenu li').click(function(){

		//perform the actions when it's not selected
		if (!$(this).hasClass('selected')) {    
			   
			//remove the selected class from all LI    
			$('#tabMenu li').removeClass('selected');
			
			//Reassign the LI
			$(this).addClass('selected');
			
			//Hide all the DIV in .boxBody
			$('.boxBody div.parent').slideUp('1500');
			
			//Look for the right DIV in boxBody according to the Navigation UL index, therefore, the arrangement is very important.
			$('.boxBody div.parent:eq(' + $('#tabMenu > li').index(this) + ')').slideDown('1500');
			
		 }
		else {
			//Hide all the DIV in .boxBody
			$('.boxBody div.parent').slideUp('1500');
			//remove the selected class from all LI    
			$('#tabMenu li').removeClass('selected');
			//Reassign the LI
			$(this).removeClass('selected');
		 }

		}).mouseover(function() {

		//Add and remove class, Personally I dont think this is the right way to do it, anyone please suggest    
		$(this).addClass('mouseover');
		$(this).removeClass('mouseout');   

		}).mouseout(function() {

		//Add and remove class
		$(this).addClass('mouseout');
		$(this).removeClass('mouseover');    

		});

		//Mouseover with animate Effect for Category menu list
		$('.boxBody #category li').click(function(){

		//Get the Anchor tag href under the LI
		window.location = $(this).children().attr('href');
		}).mouseover(function() {

		//Change background color and animate the padding
		$(this).css('backgroundColor','#888');
		$(this).children().animate({paddingLeft:"20px"}, {queue:false, duration:300});
		}).mouseout(function() {

		//Change background color and animate the padding
		$(this).css('backgroundColor','');
		$(this).children().animate({paddingLeft:"0"}, {queue:false, duration:300});
		});  

		//Mouseover effect for Posts, Comments, Famous Posts and Random Posts menu list.
		$('#.boxBody li').click(function(){
		window.location = $(this).children().attr('href');
		}).mouseover(function() {
		$(this).css('backgroundColor','#888');
		}).mouseout(function() {
		$(this).css('backgroundColor','');
		}); 
		
		
		
		window.fbAsyncInit = function() 
		{
			// init the FB JS SDK
			FB.init({
			  appId      : '204029036428158', // App ID from the App Dashboard
			  channelUrl : '//testcodeigniter.azurewebsites.net/channel.html', // Channel File for x-domain communication
			  status     : true, // check the login status upon init?
			  cookie     : true, // set sessions cookies to allow your server to access the session?
			  oauth		 : true, // enable OAuth 2.0
			  xfbml      : true  // parse XFBML tags on this page?
			});

			// Additional initialization code such as adding Event Listeners goes here

		};

		// Load the SDK's source Asynchronously
		(function(d, debug){

			var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement('script'); js.id = id; js.async = true;
			js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
			ref.parentNode.insertBefore(js, ref);

		}(document, /*debug*/ false));
	}
	
	function initFooter()
		{
			/*define easing you can omit this if 
			you don't want to use the easing plugin*/
				//jQuery.easing.def = "easeInOutBack";	

			/* create the span tht will be animated across the menu*/
			/* declare our many variables for easy ref*/
				var $span = $('<span class="colourful"></span>');
				$span.insertBefore($("#menuFooter ul"));
				//var $span = document.getElementById('colourfulSpan');
				
				var $menu_link = $('#menuFooter li a'),
				$hovered =  $('#menuFooter a.hovered'),/**/
				$hovered_pos = $hovered.position('#menuFooter');/*position of hovered menu item*/
				
				/* declare our many colors that can confuse a chameleon*/
				var $colour_arr = ['#fbb92e','#f8d52f','#b4f62f','#54f7a8','#3ff7f3','#3a97fa','#6835f9','#d544f6','#f650ab'];
				
				/*iterate through all menu links and apply colors to border top */
				$menu_link.each(function(index){
					
							$menu_link.eq(index).css('border-color',$colour_arr[index]);
						
					});	
					
			/* all the magic happens here*/
			function init () {
				
				if($hovered_pos) {
						$span.css('left',$hovered_pos);
						var index = 0;
						/* search for the selected menu item*/
						for(i=0; i<$menu_link.length; i++) {
							if($($menu_link[i]).hasClass('hovered')) {
								index = i;
							}
						}
						$span.css('background',$colour_arr[index]);
						
				}
				
				/*mouseenter funtion*/
				$menu_link.each(
					function( intIndex ){
						$(this).on (
							"mouseenter",
								function(event){
									
									var x = $(this).position('#menuFooter');
									x = x.left;
									
										$span.css('background',$colour_arr[intIndex]);
									
									$span.stop();
									$span.animate({
										
										left: x
									  },600);
								}
							);
				 
						}
				 );
				 
				/* mouseout function*/
				$menu_link.each(
					function( intIndex ){
						$(this).on (
							"mouseleave",
								function(event){
									$span.stop();
								var x = -100;
								if($hovered_pos) {
									x = $hovered_pos;
									var index = 0;
									for(i=0; i<$menu_link.length; i++) {
										if($($menu_link[i]).hasClass('hovered')) {
											index = i;
										}
									}
										$span.css('background',colour_arr[index]);
									
								} 
								
								$span.animate({
										
										left: x
									  },600);
								}
							);
						}
				 );
			}
			/* call init our function*/
			init();
		}
    
    function toggle(d)
    {
        var o=document.getElementById(d);var n=document.getElementById('left');var m=document.getElementById('lefty');
        var right=document.getElementById('right');

        if(d!="menu_login")        
        {
            if(d!="left")
            {	
                o.style.display=(o.style.display=='block')?'none':'block';	
            }

            else
            {	
                n.style.display=(n.style.display=='none')?'block':'none';
                m.style.display=(m.style.display=='block')?'none':'block';
                right.style.display=(right.style.display=='none')?'block':'none';
            }
        }

        if(d=="menu_login")
        {

            if(document.getElementById('menu_login').style.display=="block")
            {
                document.getElementById('menu_login').style.display="none";
                document.getElementById('signupmenu').style.right='20%';
                document.getElementById('loginmenu').style.right='15%';
            }

            else
            {
                document.getElementById('menu_login').style.display="block";
                document.getElementById('signupmenu').style.right="20%";
                document.getElementById('loginmenu').style.right="15%";
            }
        }
    }
    
    function scroll(d)
    {  
        var mov=document.getElementById('list');
        var t=parseInt(mov.style.top);var h=parseInt(mov.style.height);

        if(d=="up")
        {   
            if(t<-100)
            {t=t;}
            else
            {mov.style.top=(t-113)+'px';}
        }
        else if(d=="down")
        {
            if(t>4)
            {t=t;}
            else
            {mov.style.top=(t+113)+'px';}
        }
    }

    function blank(a)
    { 
        if(a.value == a.defaultValue) a.value = ""; 
    }

    function unblank(a)
    {
        if(a.value == "") a.value = a.defaultValue; 
    }

	function radioClicked(a)
	{
		switch(a) {
			case 2 :
				document.getElementById('fbLink').href="fbconnect.php?what=2";
				break;
			case 1 :
				document.getElementById('fbLink').href="fbconnect.php?what=1";
				break;
			}
	}
    
    function jsMsgBox(message)
	{
		alert(message);
	}

	function verify_login(link)
    {
        if(link == null)
			alert("Sorry, you need to login first. Please login with your facebook id.");
		else
			showProfile(link);
    }

	function facebookLoginCallback()
	{
		window.location = "/fbconnect/registerMethod/preregistered";
	}
