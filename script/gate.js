
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

	$('#radio-form').bind('submit',function(e) 
	{
		e.preventDefault();
		submitRadioForm();
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
	/****************************************************************************/
	/* Onclick function to hide the div                                          */
	/*****************************************************************************/
			//*	function myFunction()
		//*	{
			//*document.getElementById("demo");
			//*}
			
		
	/****************************************************************************/
	/*  To get call back from like button                                       */
	/****************************************************************************/
	window.fbAsyncInit = function() 
	{
		// init the FB JS SDK
		FB.init({
		  //appId      : '484562291630345', // App ID from the App Dashboard
		  appId      : '217493645081899', 
		  //channelUrl : '//WWW.TOMMYJAMS.COM/BETA/channel.html', // Channel File for x-domain communication
		  channelUrl : '//www.testcodeigniter.azurewebsites.net/channel.html',
		  status     : true, // check the login status upon init?
		  cookie     : true, // set sessions cookies to allow your server to access the session?
		  oauth		 : true, // enable OAuth 2.0
		  xfbml      : true  // parse XFBML tags on this page?
		});

		/*FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				var user_id = response.authResponse.userID;
				var page_id = "128804727178554";//OBOM
				var page_id1 = "330212257067460"; //Tommyjams.live
				var fql_query = "SELECT page_id FROM page_fan WHERE uid=me() and (page_id = " + page_id1 + " or page_id = " + page_id + ") ";
				var the_query = FB.Data.query(fql_query);

				the_query.wait(function(rows) {
					if (rows.length == 2) {
						$("#likeButtonsContainer").hide();
					}
				});
			}
		});*/

        // Check if pages are already liked. We need to login into the app here first and only then can access the user info.
		FB.login(function(response) {
			if (response.authResponse) {
				var page_id = "128804727178554";//OBOM
				var page_id1 = "330212257067460"; //Tommyjams.live
				var fql_query = "SELECT page_id FROM page_fan WHERE uid=me() and (page_id = " + page_id1 + " or page_id = " + page_id + ") ";
				var the_query = FB.Data.query(fql_query);

				the_query.wait(function(rows) {
					if (rows.length == 1) {
						//Only 1 page liked
					}
					else if (rows.length == 2) {
						$("#likeButtonsContainer").hide();
					}
					else {
						//Some error
					}
				});
			}
			else {
				//alert('User not logged in.');
			}
		});
		
		
		// Additional initialization code such as adding Event Listeners goes here
		FB.Event.subscribe('edge.create',function(href,widget){

			FB.getLoginStatus(function(response) {
					if (response.status === 'connected') {
					var user_id = response.authResponse.userID;
					var page_id = "128804727178554";//OBOM
					var page_id1 = "330212257067460"; //Tommyjams.live
					var fql_query = "SELECT page_id FROM page_fan WHERE uid=me() and (page_id = " + page_id1 + " or page_id = " + page_id + ") ";
					var the_query = FB.Data.query(fql_query);

					the_query.wait(function(rows) {
						if (rows.length == 1) {
							//Only 1 page liked
						} 
						else if (rows.length == 2) {
							$("#likeButtonsContainer").hide();
						}
						else {
							//Some error
						}
					});
				}
				else if (response.status === 'not_authorized') {
					// the user is logged in to Facebook, 
					// but has not authenticated your app
					FB.login(function(response) {
						if (response.authResponse) {
							var page_id = "128804727178554";//OBOM
							var page_id1 = "330212257067460"; //Tommyjams.live
							var fql_query = "SELECT page_id FROM page_fan WHERE uid=me() and (page_id = " + page_id1 + " or page_id = " + page_id + ") ";
							var the_query = FB.Data.query(fql_query);

							the_query.wait(function(rows) {
								if (rows.length == 1) {
									//Only 1 page liked
								}
								else if (rows.length == 2) {
									$("#likeButtonsContainer").hide();
								}
								else {
									//Some error
								}
							});
						}
						else {
							//alert('User cancelled login or did not fully authorize.');
						}
					});
				}
				else {
					// user is not logged in
					alert("Oops! Please refresh the page.");
				}
			});
		});
	};

	(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

});

