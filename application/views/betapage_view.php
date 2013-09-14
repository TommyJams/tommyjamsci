<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>TommyJams</title>

    <link href="<?php echo base_url();?>style/style.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>style/supersized/supersized.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url();?>style/mainTiles.css" rel="stylesheet" type="text/css" />

    <!--

    <script type="text/javascript" src="js/jquery.aviaSlider.js"></script>

    <script type="text/javascript" src="js/aviaInit.js"></script>    

    -->

    <style type="text/css">

        #pscroller2{

        width: 800px;

        height: 15px;

        }

        #pscroller2 a{

        text-decoration: none;

        }

        .someclass { //class to apply to your scroller(s) if desired

        }
		
    </style>

    <script type="text/javascript" src="<?php echo base_url();?>script/jquery.min.js" ></script>

    <script type="text/javascript" src="<?php echo base_url();?>script/jquery.supersized.min.js"></script>
	
    <script type="text/javascript" src="<?php echo base_url();?>script/main.js"></script> <!--contains document ready function-->
	
	<script type="text/javascript" src="<?php echo base_url();?>script/csspopup.js"></script>

    <script language="javascript"> 

        function loadframe(a) 
        {
            link = a+".php?include="+a; 
            parent.leftframe.location.href=link;
        } 

    </script>

    <script language="javascript"> 

        function loadblog(a) 

        {

            /*document.getElementById('left').style.display="none";

            document.getElementById('lefty').style.display="block";

            link = 'include/blog/index.php';

            parent.leftframe.location.href=link; */

        } 

    </script>


    <script language="javascript" type="application/javascript">

        /*
        window.onresize = function(event)
        {
            var mainContainer = document.getElementById('main-container');
            var marginHeight = 35;
            var headerHeight = 60;
            var innerContainerHeight = mainContainer.clientHeight - 2 * (marginHeight + headerHeight);
            var innerContainerWidth =  ( innerContainerHeight * 16 ) / 9;

            document.getElementById('left').style.height = innerContainerHeight+'px';
            document.getElementById('left').style.width  = innerContainerWidth+'px';

            document.getElementById('right').style.height=self.innerHeight-100+'px';

            document.getElementById('rightframe').style.height=self.innerHeight-170+'px';

            document.getElementById('lefty').style.width=self.innerWidth-220+'px';

            document.getElementById('lefty').style.height=self.innerHeight-110+'px';

            document.getElementById('left').style.height=self.innerHeight-100+'px';

            document.getElementById('featured').style.height=self.innerHeight-110+'px';



            if(self.innerWidth<900)

            {document.getElementById('right').style.display="none";

            document.getElementById('left').style.width="100%";

            document.getElementById('lefty').style.width="98%";

            }

            else

            {document.getElementById('right').style.display="block";

            document.getElementById('left').style.width="86%";

            }

        }*/

    </script>
	
	<script type="text/javascript">
          var _gaq = _gaq || [];
		  var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js'; 
		  _gaq.push(['_require', 'inpage_linkid', pluginUrl]);
          _gaq.push(['_setAccount', 'UA-34924795-1']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
	</script>

</head>

<body>

    <?
	include("include/leftCommon.php");
	?>

	<div id="loginPopupBox" style="display:none;">
        <a id="loginBoxClose" href="#" onClick="popupClose('loginPopupBox')">
        </a>
        <center>
            <h3 id="loginBoxTitle">
                Login With Facebook
            </h3>
			<div id="loginBoxDetails">
				<div class='fb-login-button'  fb_only='true' fb_register='true' size='xlarge' onlogin=facebookLoginCallback(); registration-url='http://testcodeigniter.azurewebsites.net/fbconnect/registerMethod/noregister'></div>
			</div>
        </center>
    </div>

	<div id="main-container">
	
        <!--
        <div id="header">

            <div class="logo"><a href="index.php"><img src="images/logo.png" width="205" height="34" /></a></div>
            
            <div id="headerTabsContainer">
                <div class="menu"><a href="#">Artists</a></div>
                <div class="menu"><a href="#" >Promoters</a></div>
                <div class="menu"><a href="javascript:;" onClick="loadblog('blog');">Blog</a></div>

                <div id="loginContainer">
                    <div class="menu" id="signupmenu">
                        <a href="fbconnect.php?what=1">
                            <div style="height:25px; font-size:0px; width:90px;  cursor:pointer; background:url(images/fbpro.png) no-repeat;" onClick="fbstuff('Promoter')">
                            Promoter
                            </div>
                        </a>
                    </div>
                    <div class="menu" id="signupmenu">
                        <a href="fbconnect.php?what=2">
                            <div style="height:25px;  font-size:0px; width:70px; cursor:pointer; background:url(images/fbart.png) no-repeat;" onClick="fbstuff('Artist')">
                            Artist
                            </div>
                        </a>
                    </div>
                </div>

            </div>

            <div id="menu_search">
                <form action="index.php?profile=search" method="post" style="height:26px;">
                    <input type="text1" size="20" name="profile" value="Profile" id="search"   onfocus="blank(this)" onblur="unblank(this)"  />
                </form>
            </div>
        </div>

        <div id="left">
                <div id="featured">
                    <div id="fragment-1" class="ui-tabs-panel" style="">
                        <img src="images/gig1.jpg" alt="" class="img" />
                        <div class="info" >
                            <h2><a href="#" >Indian Ocean @ DTU</a></h2>
                            <p>INDIAN OCEAN concert in DTU<a href="#" > read more</a></p>
                        </div>
                    </div>
                    <div id="fragment-2" class="ui-tabs-panel ui-tabs-hide" style="">
                        <img src="images/gig2.jpg" alt="" class="img"  />
                        <div class="info" >
                            <h2><a href="#" >JAL@ IIT Delhi</a></h2>
                            <p>JAL Band performed @ IIT Delhi<a href="#" >read more</a></p>
                        </div>
                    </div>
                    <div id="fragment-3" class="ui-tabs-panel ui-tabs-hide" style="">
                        <img src="images/gig3.jpg" alt=""  class="img" />
                        <div class="info" >
                            <h2><a href="#" >Band @ BITS</a></h2>
                            <p>Rock band @ BITS<a href="#" >read more</a></p>
                        </div>
                    </div>
                    <div id="fragment-4" class="ui-tabs-panel ui-tabs-hide" style="">
                        <img src="images/gig4.jpg" alt=""  class="img" />
                        <div class="info" >
                            <h2><a href="#" >Rocking @ NIT</a></h2>
                            <p>NIT allahabad rock night...<a href="#" >read more</a></p>
                        </div>
                    </div>
                    <div id="fragment-5" class="ui-tabs-panel ui-tabs-hide" style="">
                        <img src="images/gig5.jpg" alt=""  class="img" />
                        <div class="info" >
                            <h2><a href="#" >Rocking @ VIT</a></h2>
                            <p>VIT rocking fest night...<a href="#" >read more</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="right">
                <div class="scroll" style=" background:url('images/scrollup.png') no-repeat; background-position:center;">
                    <a href="javascript:;" onClick="scroll('down');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>

                <div id="rightframe" >
                    <div id="list">
                        <div id="featured" >
                            <ul class="ui-tabs-nav">
                                <li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-1"><a href="#fragment-1"><img src="images/gig1.jpg" alt="" /></a></li>
                                <li class="ui-tabs-nav-item" id="nav-fragment-2"><a href="#fragment-2"><img src="images/gig2.jpg" alt="" /></a></li>
                                <li class="ui-tabs-nav-item" id="nav-fragment-3"><a href="#fragment-3"><img src="images/gig3.jpg" alt="" /></a></li>
                                <li class="ui-tabs-nav-item" id="nav-fragment-4"><a href="#fragment-4"><img src="images/gig4.jpg" alt="" /></a></li>
                                <li class="ui-tabs-nav-item" id="nav-fragment-5"><a href="#fragment-5"><img src="images/gig5.jpg" alt="" /></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="scroll" style=" background:url('images/scrolldown.png') no-repeat; background-position:center;">
                    <a href="javascript:;" onClick="scroll('up');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
            </div>
            -->

        <div id="inner-container">
                <?
                include("include/mainTiles.php");
                ?>
        </div>

        <!--<div id="lefty" style="overflow:hidden; overflow-y:scroll;">
            <iframe name="leftframe" width="100%" height="100%" frameborder="0"></iframe>
        </div>-->

        <script>
            /*document.getElementById('lefty').style.width=self.innerWidth-220+'px';*/
            <? if(isset($_GET["profile"]) && $_GET["profile"]=="search")
                { 
                    if(isset($_GET["pages"])){$_SESSION["pages"]=$_GET["pages"];}
                    else{$_SESSION["pages"]=1;}
                    if(isset($_POST["profile"])){$_SESSION["profile"]=$_POST["profile"];}
                    print("$('#inner-container').load('include/profile_search.php?page=$_SESSION[pages]');");
                }
            ?>
        </script>
        
    </div> <!--main-container-->

	<?
	include("include/rightCommon.php");
	?>

<!--</div> right-->

</body>

</html>