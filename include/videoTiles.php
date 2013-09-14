<?

	$numTiles = (json_decode($_POST['json'])->numTiles);
	$thisYear = (json_decode($_POST['json'])->year);
	$thisMonth = (json_decode($_POST['json'])->month);

	if($numTiles > 0 )
		$streams = (json_decode($_POST['json'])->streams);

	switch($thisMonth) {
			case '01': $thisMonthName = "January"; break;
			case '02': $thisMonthName = "February"; break;
			case '03': $thisMonthName = "March"; break;
			case '04': $thisMonthName = "April"; break;
			case '05': $thisMonthName = "May"; break;
			case '06': $thisMonthName = "June"; break;
			case '07': $thisMonthName = "July"; break;
			case '08': $thisMonthName = "August"; break;
			case '09': $thisMonthName = "Sept"; break;
			case '10': $thisMonthName = "October"; break;
			case '11': $thisMonthName = "November"; break;
			case '12': $thisMonthName = "December"; break;
			default:   $thisMonthName = "January"; break;
	}

?>

<!-- Month -->
<div id="monthWidgetBox">
	<?print("<h1>$thisMonthName</h1>");?>
</div>

<div id="monthWidgetContainer">
	<ul>
		<li><h1>January</h1></li>
		<li><h1>February</h1></li>
		<li><h1>March</h1></li>
		<li><h1>April</h1></li>
		<li><h1>May</h1></li>
        <li><h1>June</h1></li>
        <li><h1>July</h1></li>
        <li><h1>August</h1></li>
        <li><h1>September</h1></li>
	</ul>
</div>

<!-- Video list -->
<div id="imageBoxContainer">

	<ul class="no-list image-list image-list-carousel">

	<?	
		if($numTiles)
		{
			foreach($streams as $row)
			{
				$epName = $row[0]; $epImage = $row[1]; $epAudio = $row[2]; $epDate = $row[3]; $epDesc = $row[4];
				if($numTiles <= 4)
				{
					print("
					<li class='bigListSize'>
						<div id='imageBox'>
							<a href='$epAudio' class='preloader overlay-video fancybox-audio-mixcloud'>
								<img src='/image/radioone/artists/$epImage' alt=''/>
								<span></span>
							</a>
							<p class='imageBoxCaption'>$epName</p>
							<div class='imageDetails'>$epDate<br>$epDesc</div>
						</div>
					</li>");
				}
				else
				{
					print("
					<li class='smallListSize'>
						<div id='imageBox'>
							<a href='$epAudio' class='preloader overlay-video fancybox-audio-mixcloud'>
								<img src='/image/radioone/artists/$epImage' alt=''/>
								<span></span>
							</a>
							<p class='imageBoxCaption'>$epName</p>
							<div class='imageDetails'>$epDate<br>$epDesc</div>
						</div>
					</li>");
				}
			}
		}
		else
		{
			print("
			<li class='bigListSize'>
				<div id='imageBox' style='padding-bottom: 10px'>Sorry, no listing found!</div>
			</li>");
		}

	?>

	</ul>

</div>

<!-- Radio One Logo-->
<a href="http://www.facebook.com/pages/ONE-Bengaluru-ONE-Music/128804727178554" target="_blank" id="radioOneLogo">

	<img src="/image/icon/radioonelogo.png" width="100%">

</a>

<script type="text/javascript">

	initMonthWidget();
	initCaptions();
	initFancyBox();
	$("#loading-indicator").hide();
	
</script>
