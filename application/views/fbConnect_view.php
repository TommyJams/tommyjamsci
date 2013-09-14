<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TommyJams - Facebook Registration</title>
    <link href="<?php echo base_url();?>style/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>style/supersized/supersized.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url();?>script/jquery.min.js" ></script>
    <script type="text/javascript" src="<?php echo base_url();?>script/jquery.supersized.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>script/main.js"></script>
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
	<!-- Background overlay -->
        <div id="background-overlay"></div>
    <!-- /Background overlay -->    
    
        <?	include("include/leftCommon.php");	?>       

        <div id="main-container">
            <div id="inner-container">
                <div class="head">
                    <h1>REGISTRATION</h1>
                </div>

				<div id="textContainer">

                    <?php if ($val == 1): ?> 
					<?php echo $iframe;?>

                    <?php elseif ($val == 2): ?> 
                    <?php echo $mess;?> 

                    <?php elseif ($val == 3): ?> 
                    <?php echo $mess;?> 

                    <?php elseif ($val == 4): ?>  
                    <?php echo $mess;?> 

                    <? endif; ?>

				</div>
			</div>
		</div>
	</body>
</html>