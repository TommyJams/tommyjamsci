<html>
<head>
	<link rel='stylesheet' href='style/edit.css'>
	<!-- Include the JS files --> 
</head>
 <body>
    <div id="blanket" style="display:none;
                            background-color:#111;
                            opacity: 0.65;
                            position:absolute;
                            z-index: 9001;
                            top:0px;
                            left:0px;
                            width:100%;
                            height:100%;
                            "/>

	<div id="profil" style="display:none; ">
        <a id="loginBoxClose" href="#" onClick="popup('profil')">
		</a>
        <center><h2>Upload gig logo</h2></center>
        <?php $link = (json_decode($_POST['json'])->link); ?>
        
        <form action="update.php?gig=pic&pic=<? print("$link"); ?>" method="post" enctype="multipart/form-data">
            <table style="margin-top: 30px; width: 100%;">
                <tbody>
                    <tr>
                        <td>
                            <input name="gigs" id="image" type="file" size="50" />
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <span class="hint" style="line-height:10px;">
                                    Valid Image File (.jpg, .png, .bmp)
                                    <br>
                                    Max Size: 150KB
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <input name="submit" id="upload" type="submit" value="Upload" style="background: #000; color: #ffcc00; margin: 10px auto;"/>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

    <div id="box" style="display:block; height:100%;">	
        <section id="left" style="width:100%; height:100%;">
			<div id="userStats" class="clearfix">
                <div id="userPic" class="pic">

                    <?php $gigs = (json_decode($_POST['json'])->gigs);?>
                    <?php $gigSession = (json_decode($_POST['json'])->gigSession); ?>
					<? 
                        if($gigSession != 1)
                        {
                            print("<a href='#'  onclick=popup('profil')>");
                        }
					    else 
                        { 
                            print("<a href='#'>");
                        }
                        print ("<img src='$gigs' class='userStatsPic' />"); 
                    ?>
					
                    </a>
				</div>
				<div class="data">
                    <div style=" width:35%; height:100%; float:left;">
                        <div id="userName">
                            <?php $gig = (json_decode($_POST['json'])->gig);?>
							<h1 style="display:inline-block;"><? print ("$gig"); ?></h1>
						</div>
                        <?php   $promoter_name = (json_decode($_POST['json'])->promoter_name);
                                $promoter = (json_decode($_POST['json'])->promoter);
                        ?>
                        <h2 id='gigHostName'>Hosted by: <? print ("<a href='javascript:;' onClick=showProfile('$promoter');>$promoter_name</a>"); ?></h2>
                        <h2><?php $city = (json_decode($_POST['json'])->city); ?>
                            <?php $state = (json_decode($_POST['json'])->state); ?>
                            <?php $country = (json_decode($_POST['json'])->country); ?>
                            <?
                            if($city!="")
                            {
                                print("$city");
                            }
                            if($state!="")
                            {
                                if($city!="")
                                print(", ");

                                print("$state");
                            }
                            if($country!="")
                            {
                                if($city!="" || $state!="")
                                print(", ");

                                print("$country");
                            }
                            ?>
                        </h2>
                    </div>
					<div class="socialInfo">
						<div class="socialMediaLinks">
                            <?php $fb = (json_decode($_POST['json'])->fb); ?>
                            <?php $twitter = (json_decode($_POST['json'])->twitter); ?>
                            <?php $web = (json_decode($_POST['json'])->web); ?>
                            
							<? if($fb!="")
                                { print("<a href='$fb' rel='me' target='_blank'><img src='img/facebook.png' /></a>"); }?>						
							<? if($twitter!="")
                                { print("<a href='$twitter' rel='me' target='_blank'><img src='img/twitter.png' /></a>"); }?>						
							<? if($web!="")
                                { print("<a href='$web' rel='me' target='_blank'><img src='img/web.png' /></a>"); }?>
						</div>
					</div>
                    <div class="medals" style="width:35%; height: auto; float:right; position:relative; top:30%; margin-top:-35px;">
                        <div id="gigStatus" style="width:auto; height:auto; margin:20px auto; position:relative;">
						<center>
                        <?php   $gigStatus = (json_decode($_POST['json'])->gigStatus); ?>
                        <?	
                        if ($gigStatus == 1) // Gig is booked
                        {
                            $artist_booked_id = (json_decode($_POST['json'])->artist_booked_id);
                            $artist_booked_name = (json_decode($_POST['json'])->artist_booked_name);

							print("<h2>Artist:</h2>");
                            print("<a href='javascript:;' onClick=showProfile('$artist_booked_id'); class='whiteHoverRef'>$artist_booked_name</a>");
                        }
						elseif($gigStatus == 2)
						{    
							print("<a  href='javascript:;' onClick=showUpdateGig('$link'); class='whiteHoverRef'>Edit Gig</a>");
						}
                        elseif($gigSession == 1)
                        { 
                            $statuss=$found["status"];
                            if($gigStatus == 3){print("<a href='#' id='addnew' style='background: #0a0;'>Accepted</a>");}
                            elseif($gigStatus == 4){print("<a href='#' id='addnew' style='background: #a00'>Rejected</a>");}
                            elseif($gigStatus == 5){print("<a href='#' id='addnew' style='background: #282828;'>Pending</a>");}
                        
					        elseif($gigStatus == 6)
						    {
							    print("<a href='javascript:;' class='dibStatusRef' style='background:#666;'>Closed</a>");
						    }
                            elseif($gigStatus == 7)
                            {                       
                            ?>
                                <?php $link = (json_decode($_POST['json'])->link); ?>
                                <form  action=""  method="post">
                                    <input type="hidden" name="gig" value="<? print($link);?>">
                                    <input id="dibStatusButton" name="dib" type="submit" value="DIB" onClick="confirmSubmit('$link')">
                                </form>
                            <?
                            }
                        }
                        
                        elseif($gigStatus == 8)
                        {
                            print("<a href='javascript:;' class='dibStatusRef' style='background:#666;'>Closed</a>");
                        }
                    
                        /*
                        print("<p"); if(isset($_SESSION["username_artist"])){ print(" style='margin-top:25px;' ");}
                        print("><b>Description:-</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  $desc</p>");
                        */
                        ?>
						</center>
                        </div>
                    </div>
				</div> <!--data-->
			</div> <!--userStats-->
            <div id = "blank" style = "display: block; height: 4%; width: 100%" />
			<div class="about">
                <div class="gcontent" style="height:100%; background: #000; padding: 0px 20px; overflow-y:auto;">                    
                    <div class="boxy" style = "height:auto; margin:20px 0px;">
                        <table width="100%" style="text-align:left;">
                            <tr>
                                <?php $formattedDate = (json_decode($_POST['json'])->formattedDate); ?>
                                <td style="width:10%; background: #ffcc00;"><h2>Date<h2></td>
                                <td style="color: #000; background: #fff; padding:5px;"><?  print ("$formattedDate"); ?><td>
                            </tr>
                            <tr style="color: #000; width:10%" >
                                <?php $vtime = (json_decode($_POST['json'])->vtime); ?>
                                <td style="width:10%; background: #ffcc00;"><h2>Time<h2></td>
                                <td style="color: #000; background: #fff; padding:5px;"><?  print ("$vtime"); ?></td>
                            </tr>
							<tr style="color: #000; width:10%" >
                                <?php $duration = (json_decode($_POST['json'])->duration); ?>
                                <td style="width:10%; background: #ffcc00;"><h2>Duration<h2></td>
                                <td style="color: #000; background: #fff; padding:5px;"><?  print ("$duration"); ?></td>
                            </tr>
                            <tr style="color: #000; width:10%" >
                                <?php $cat = (json_decode($_POST['json'])->cat); ?>
                                <td style="width:10%; background: #ffcc00;"><h2>Genre<h2></td>
                                <td style="color: #000; background: #fff; padding:5px;"><?  print ("$cat"); ?></td>
                            </tr>
                            <tr style="color: #000; width:10%" >
                                <?php $budget_min = (json_decode($_POST['json'])->budget_min); ?>
                                <?php $budget_max = (json_decode($_POST['json'])->budget_max); ?>
                                <td style="width:10%; background: #ffcc00;"><h2>Budget<h2></td>
                                <td style="color: #000; background: #fff; padding:5px;"><?  if($budget_min == -1){print("Undefined");}else{print("INR $budget_min - $budget_max");} ?></td>
                            </tr>
                            <tr style="color: #000; width:10%" >
                                <?php $add = (json_decode($_POST['json'])->add); ?>
                                <?php $city = (json_decode($_POST['json'])->city); ?>
                                <?php $state = (json_decode($_POST['json'])->state); ?>
                                <?php $country = (json_decode($_POST['json'])->country); ?>
                                <?php $pincode = (json_decode($_POST['json'])->pincode); ?>
        
                                <td style="width:10%; background: #ffcc00;"><h2>Venue</h2></td>
                                <td style="color: #000; background: #fff; padding:5px;"><?  print ("$add, $city, $state, $country, $pincode"); ?></td>
                            </tr>
                            <tr style="color: #000; width:10%" >
                                <td style="width:10%; background: #ffcc00;"><h2>Description</h2></td>
                                <td style="color: #000; background: #fff; padding:5px;">
                                    <?
                                        $desc = (json_decode($_POST['json'])->desc); 
										/*convert to URL*/
										$descStr = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" style='color:#000;'>\\0</a>", $desc);
										/*format newlines*/
										$descStr = nl2br("$descStr");
										print ("$descStr"); 
									?>
								</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

	<script type="text/javascript">
		$('#loading-indicator').hide();
	</script>

	<script LANGUAGE="JavaScript">
	function confirmSubmit(link)
	{
		var agree=confirm("Are you sure you wish to call dibs for this gig? The host will receive the dibs and choose an artist. Please note, these dibs are not cancellable.");
		if (agree)
			dibAction(link);
		else
			return false ;
	}
	</script>

</body>
</html>