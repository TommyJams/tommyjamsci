<?
	$error     = (json_decode($_POST['json'])->error);
	$reason    = (json_decode($_POST['json'])->reason);
	$eDate     = (json_decode($_POST['json'])->eventDate);
	$gig_id    = (json_decode($_POST['json'])->gig_id);
	$gig_name  = (json_decode($_POST['json'])->gig_name);
	$role	   = (json_decode($_POST['json'])->role);
	$artist_name  	= (json_decode($_POST['json'])->artist_name);
	$promoter_name  = (json_decode($_POST['json'])->promoter_name);
?>
<html>
<head>
	<link rel='stylesheet' href='/style/edit.css'>
	<!-- Include the JS files -->
	<script type="text/javascript">
		<?
		if(!$error)
		{
		?>
		$('#ratingForm').bind('submit',function(e) 
	        {
	            e.preventDefault();
				
				var gigRateElem = document.getElementById("gigRating");
				var rateElem 	= document.getElementById("rateElem");
				
	            var obj = {
                    gigLink:    <?print("$gig_id");?>,
                    gigRate:    gigRateElem.options[gigRateElem.selectedIndex].value,
                    gigComment: document.getElementById('gigComment').value,
                    rate:   	rateElem.options[rateElem.selectedIndex].value,
                    comment:    document.getElementById('comment').value,
                    future:    	document.getElementById('future').checked
                };

	            enterGigFeedback(obj);
	        });
		<?}?>
	</script>
</head>
<body>
	<div id="box" style="display:block;">
		<div id="content" class="clearfix">
			<section id="left" style=" width:100%;">

				<?
					error_log('error'.$error.'reason'.$reason);
					if($error)
					{
						if($reason == 'premature')
						{
							print("<div class='gcontent' style='margin-bottom:6px; margin-top:10px;'>
							<div class='head'><h1>You may rate after the gig is over on: $eDate</h1></div></div>");
						}
						elseif($reason == 'already')
						{
							print("<div class='gcontent' style='margin-bottom:6px; margin-top:10px;'>
							<div class='head'><h1>Sorry, Already Rated!</h1></div></div>");
						}
						elseif($reason == 'gignotfound')
	 					{
							print("<div class='gcontent' style='margin-bottom:6px; margin-top:10px;'>
									<div class='head'><h1>No such gig to rate</h1></div></div>");
						}
						elseif($reason == 'ineligible')
						{
							print("<div class='gcontent' style='margin-bottom:6px; margin-top:10px;'>
								<div class='head'><h1>Ineligible for rating '$gig_name'</h1></div></div>");
 						}
					}
					else
					{
				?>
						<div class="gcontent" style="margin-bottom:6px; margin-top:10px;">
							<div class="head">
								<h1>RATING & FEEDBACK</h1>
							</div>
							<div id="signUp" class="sign" style="">
								<form action="" method="POST" class="cleanForm" id="ratingForm" style="height:100%; overflow-y:auto;">
									<div id="maindetails" style="width:100%; height:300px;">
										<div id="details" style=" width:45%; float:left;">
											<center>
												<a href="#" class="greenRef">
													<h1><? print("$gig_name");?></h1>
												</a>
											</center>
											<table style="padding:20px; width:80%;">
												<tr>
													<td width="50%">
														<p><label for="Select" style="float:right;">Gig Rating: <span class="requiredField">*</span></label></p>
													</td>
													<td width="50%">
														<select id="gigRating" name="gigRating" style="width:50px; height:25px; font-size:18px;" required >
														<?
															for($i=5;$i>0;$i--){ print("<option value=$i>$i</option>");}
														?>
														</select>
													</td>
												</tr>
												<tr>
													<td width="50%">
														<p><label for="fb" style="float:right;">Comments on Gig:</label></p>
													</td>
													<td width="50%">
														<textarea cols="20" rows="7"  id="gigComment" name="gigComment" maxlength="100"></textarea>
														<em>(less than 100 characters)</em>
													</td>
												</tr>
											</table>
										</div>
										<div id="details"  style=" width:45%; float:right;">
											<center>
												<a href="#" class="greenRef">
													<h1>
													<?
														if($role=="p"){ print("$artist_name"); }
														elseif($role=="a"){ print("$promoter_name"); }
													?>
													</h1>
												</a>
											</center>
											<table style="padding:20px; width:80%;">
												<tr>
													<td width="50%">
														<p>
															<label for="Select" style="float:right;">
															<?
																if($role=="p"){ print("Artist Rating:"); }
																elseif($role=="a"){ print("Promoter Rating:"); }
															?>
																<span class="requiredField">*</span>
															</label>
														</p>
													</td>
													<td width="50%">
														<select id="rateElem" name="<?if($role=="p"){ print("prate"); }elseif($role=="a"){ print("arate"); }?>" style=" width:50px; height:25px; font-size:18px;" required >
															<?
																for($i=5;$i>0;$i--){ print("<option value=$i>$i</option>");}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td width="50%">
														<p>
															<label for="fb" style="float:right;">
															<?
																if($role=="p"){ print("Comments on Artist:"); }
																elseif($role=="a"){ print("Comments on Host:"); }
															?>
															</label>
														</p>
													</td>
													<td width="50%">
														<textarea cols="20" rows="7"  id="comment" name="<?if($role=="p"){ print("pcomment"); }elseif($role=="a"){ print("acomment"); }?>" maxlength="100"></textarea>
														<em>(less than 100 characters)</em>
													</td>
												</tr>
												<tr>
													<td width="50%">
														<input type="checkbox" value="1" id="future" name="future" style="float:right; margin-right:5px;" />
													</td>
													<td width="50%">
														<p>Would you conduct gigs with this <?if($role=="p"){ print("Artist"); }elseif($role=="a"){ print("Host"); }?> again?</p>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<div class="centera" style="width:100%; position:relative; margin-top:10px; ">
										<input type="submit" value="Rate" style="height:45px; width: 50px; left:50%; margin-left:-50px; position:relative; padding: 5px 5px;"/>
									</div>
								</form>
							</div>
						</div>
				<?  
					}
				?>
			</section>
		</div>
	</div>

	<script type="text/javascript">
		$('#loading-indicator').hide();
	</script>

</body>
</html>