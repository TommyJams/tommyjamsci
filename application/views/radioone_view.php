<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <meta property="og:title" content=<?print("One Bengaluru One Music: ".$name);?>/>

  <meta property="og:type" content="website" />

  <meta property="og:image" content=<?print("http://tommyjams.com/images/radioone/artists/".$image);?>/>

  <meta property="og:url" content="http://tommyjams.com/radioone" />

  <meta property="og:site_name" content="TommyJams" />

  <meta property="og:description" content="TommyJams & Radio One 94.3: One Bengaluru One Music" />

  <meta property="fb:app_id" content="566516890030362" />

  <title>TommyJams & Radio One 94.3: One Bengaluru One Music</title>

  <link href="/style/style.css" rel="stylesheet" type="text/css" />

  <link href="/style/supersized/supersized.css" rel="stylesheet" type="text/css" />
  
  <link href="/style/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
  
  <link href="/style/videoTiles.css" rel="stylesheet" type="text/css"/>

  <script type="text/javascript" src="/script/jquery.min.js" ></script>

  <script type="text/javascript" src="/script/jquery.supersized.min.js"></script>
  
  <script type="text/javascript" src="/script/jquery.fancybox.js"></script>

  <script type="text/javascript" src="/script/main.js"></script> <!--contains document ready function-->

  <script type="text/javascript" src="/script/videoTiles.js"></script> <!--contains document ready function-->

  <script language="javascript"> 

    function loadTilesCallback(a) 
    {
      console.log(JSON.stringify(a));
      $('#videoTilesContainer').load("/include/videoTiles.php", {json: JSON.stringify(a)});
    }

    function loadTiles(year,month,day) 
    {
      $("#loading-indicator").show();
      $.post('/radioone/loadTiles', {'year': year, 'month': month, 'day': day}, loadTilesCallback, 'json');
    }

  </script>

</head>

<body>

  <?
  include("include/leftCommon.php");
  ?>

  <div id="main-container">

        <div id="inner-container">

            <div class="head">

                <h1>One Bangalore One Music</h1>

            </div>

            <div id="lefty">

              <div id="videoTilesContainer" style="height: 100%; width: 100%; overflow-y: auto; position:relative;">

              </div>

            </div>

        </div>

  </div> <!--main-container-->

  <?
  include("include/rightCommon.php");
  ?>

</body>

<script language="javascript">    
<?
  if($urlyear && $urlmonth && $urlday)
    print("loadTiles($urlyear,$urlmonth,$urlday);");
  else
    print("loadTiles();");
?>
</script>

</html>