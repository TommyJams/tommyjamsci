<html>
<head>
	<link rel='stylesheet' href='style/edit.css'>
	<!-- Include the JS files -->
	<script> 
		$('#signUpForm').bind('submit',function(e) 
		{
			e.preventDefault();
			launchGig();
		});
	</script>

</head>
 <body>
 	<?php 
		$do="add";
		$show=1;
		$ok="Launch Gig";
							
		$todayDate = intval(date("d"));
		$todayMonth = intval(date("m"));
		$todayYear = intval(date("Y"));
 	?>
    <div class="head">
		<h1>LAUNCH GIG</h1>
	</div>
    <div id="box" style="display:block;">
        <div id="content" class="clearfix">
            <section id="left" style=" width:100%;">
                <div class="gcontent">
                    <div id="signUp" class="sign" style="overflow-y:auto">
                        <form action="" name="signUpForm" method="POST" class="cleanForm" id="signUpForm" style="height:100%; margin-top:10px; min-width:800px;">
						<div id="launchContainer">
                            <fieldset id="details" style = "height:auto; float:left">
                                <p>
                                    <label for="gig">Name: <span class="requiredField">*</span></label>
                                    <input type="text" id="gig" name="gig" style="width:200px;" value="" pattern="^[a-zA-Z0-9. /()-_:@]{3,50}$" autofocus required />
                                    <em>Name of Gig</em>
                                </p>
								<? if($show==1){ ?>
									<p>
									  <label for="Select">Genre: <span class="requiredField">*</span></label>
										<select id="select" name="cat"  style="width:200px; padding-right:0px;" required >
											<option value="Acoustic">Acoustic</option>
											<option value="Blues">Blues</option>
											<option value="Classic Rock">Classic Rock</option>
											<option value="Classical">Classical</option>
											<option value="Comedy">Comedy</option>
											<option value="Contemporary">Contemporary</option>
											<option value="Cover Band">Cover Band</option>
											<option value="Dance/DJ">Dance/DJ</option>
											<option value="Dubstep">Dubstep</option>
											<option value="Electronic">Electronic</option>
											<option value="Folk">Folk</option>
											<option value="Funk">Funk</option>
											<option value="Goth">Goth</option>
											<option value="Jazz">Jazz</option>
											<option value="Metal">Metal</option>
											<option value="Pop">Pop</option>
											<option value="Punk">Punk</option>
											<option value="Reggae">Reggae</option>
											<option value="Rock">Rock</option>
											<option value="Solo">Solo</option>
											<option value="Soul">Soul</option>
											<option value="Other">Other</option>
										</select>
										<em>&nbsp;</em>
									</p>
									<p>
									<label for="Budget">Budget: <span class="requiredField">*</span></label>
										<select id="select" name="budget_min" style="width:145px; float:left;" required >
											<option value="0"   >Free Gig</option>
											<option value="1000">Rs. 1000</option>
											<option value="2000">Rs. 2000</option>
											<option value="5000">Rs. 5000</option>
											<option value="10000">Rs. 10000</option>
											<option value="20000">Rs. 20000</option>
											<option value="40000">Rs. 40000</option>
											<option value="100000">Rs. 100000</option>
										</select>
										<select id="select"  style="width:60px; margin-left:5px; float:left;" name="budget_max">
											<option value="0">+0%</option>
											<option value="10">+10%</option>
											<option value="20">+20%</option>
											<option value="30">+30%</option>
											<option value="40">+40%</option>
											<option value="50">+50%</option>
											<option value="60">+60%</option>
											<option value="70">+70%</option>
											<option value="80">+80%</option>
											<option value="90">+90%</option>
											<option value="90">+100%</option>
										</select>
										<em>Min(*) & Negotiable Budget</em>
									</p>
									<p>
										<label for="gig">Date: <span class="requiredField">*</span></label>
										<select id="select"  style="width:60px; float:left;" name="date">
											<?
												for($i=1;$i<=31;$i++){if($i == $todayDate) print("<option value='$i' selected='selected'>$i</option>"); else print("<option value='$i'>$i</option>");}
											?>
										</select>
										<select id="select"  style="width:80px; margin-left: 5px; float:left;" name="month">
										   <option value='1' <? if($todayMonth == '1') print("selected='selected'"); ?> >Jan</option>
										   <option value='2' <? if($todayMonth == '2') print("selected='selected'"); ?> >Feb</option>
										   <option value='3' <? if($todayMonth == '3') print("selected='selected'"); ?> >Mar</option>
										   <option value='4' <? if($todayMonth == '4') print("selected='selected'"); ?> >Apr</option>
										   <option value='5' <? if($todayMonth == '5') print("selected='selected'"); ?> >May</option>
										   <option value='6' <? if($todayMonth == '6') print("selected='selected'"); ?> >Jun</option>
										   <option value='7' <? if($todayMonth == '7') print("selected='selected'"); ?> >Jul</option>
										   <option value='8' <? if($todayMonth == '8') print("selected='selected'"); ?> >Aug</option>
										   <option value='9' <? if($todayMonth == '9') print("selected='selected'"); ?> >Sep</option>
										   <option value='10' <? if($todayMonth == '10') print("selected='selected'"); ?> >Oct</option>
										   <option value='11' <? if($todayMonth == '11') print("selected='selected'"); ?> >Nov</option>
										   <option value='12' <? if($todayMonth == '12') print("selected='selected'"); ?> >Dec</option>
										</select>
										<select id="select"  style="width:60px; margin-left: 5px; float:left;" name="year">
										<?
											for($i=2013;$i<=2015;$i++){ if($i == $todayYear) print("<option value='$i' selected='selected'>$i</option>"); else print("<option value='$i'>$i</option>"); }
										?>                  
										</select>
										<em>Date of Event</em>
									</p>
								<? } ?>
                                <p>
                                    <label for="gig">Time: <span class="requiredField">*</span></label>
                                    <select id="select"  style="width:60px; float:left;" name="hours">
                                    <?
                                        for($i=01;$i<=12;$i++){ if( ($a && $hourSaved==$i) || $i==8 ) print("<option value='$i' selected='selected'>$i</option>"); else print("<option value='$i'>$i</option>"); }
                                    ?>      
                                    </select>
                                    <select id="select"  style="width:80px; margin-left: 5px; float:left;" name="minute">
										<option value='00' <? if($a && $minSaved=='00') print("selected='selected'"); ?> >00</option>
										<option value='30' <? if($a && $minSaved=='30') print("selected='selected'"); ?> >30</option>
                                    </select>                            
                                    <select id="select" style="width:60px; margin-left: 5px; float:left;" name="am">
                                        <option value='PM' <? if($a && $amSaved=='PM') print("selected='selected'"); ?> >PM</option>
										<option value='AM' <? if($a && $amSaved=='AM') print("selected='selected'"); ?> >AM</option>
                                    </select>
                                    <em>Time of Gig</em>
                                </p>
								<p>
									<label for="gig">Duration: <span class="requiredField">*</span></label>
                                    <select id="select"  style="width:60px; float:left;" name="duration">
                                    <?
                                        for($i=0.5;$i<=24;$i = $i + 0.5){ if($a && $i == $durationSaved) print("<option value='$i' selected='selected'>$i</option>"); else print("<option value='$i'>$i</option>"); }
                                    ?>
                                    </select>
									<em>in Hours</em>
								</p>
								<? if($show==1){ ?>
									<p>
										<label for="gig">Slots:</label>
										<select id="select"  style="width:60px; float:left;" name="slotNum">
										<?
											for($i=1;$i<=10;$i++){print("<option value='$i'>$i</option>");}
										?>      
										</select>
										<em>Number of slots</em>
									</p>
								<? } ?>
                                <p>
                                    <label for="Website">Website:</label>
                                    <input type="text" id="website" name="web" style="width:200px;" value="<? if($a) echo $a['web']; ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <em>Gig's Website</em>
                                </p>
                                <p>
                                    <label for="social">Facebook:</label>
                                    <input type="text" id="fb" name="fb" style="width:200px;" value="<? if($a) echo $a['fb']; ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <em>Gig's link on Facebook.</em>
                                </p>
                                <p>
                                    <label for="social">Twitter: </label>
                                    <input type="text" id="twiter" name="twitter" style="width:200px;" value="<? if($a) echo $a['twitter']; ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <em>Gig's link on Twitter.</em>
                                </p>
                            </fieldset>
                            <fieldset id="venue">
                                <p>
                                    <label for="add">Address: <span class="requiredField">*</span></label>
                                    <input type="text" id="add" name="add" value="<? if($a) echo $a['venue_add']; ?>" pattern="^[0-9a-zA-Z !@#$%^&*()_,.\\/{}|:<>?-]{3,100}$" required/>
                                    <em>Venue Address</em>
                                </p>
								<? if($show==1){ ?>
									<p>
										<label for="city">City: <span class="requiredField">*</span></label>
										<input type="text" id="city" name="city" value="" pattern="^[a-zA-Z ]{3,20}$" required/>
										<em>Venue City</em>
									</p>
									<p>
										<label for="state">State:</label>
										<input type="text" id="state" name="state" value="" pattern="^[a-zA-Z ]{3,20}$"/>
										<em>Venue State</em>
									</p>
									
									<p>
										<label for="Country">Country: <span class="requiredField">*</span></label>
										<input type="text" id="country" name="country" value="India" pattern="^[a-zA-Z ]{3,20}$" required/>
										<em>Venue Country</em>
									</p>
									<p>
										<label for="Pincode">Pincode:</label>
										<input type="text" id="pincode" name="pincode" value="" pattern="^[0-9]{6,6}$"/>
										<em>Venue Pincode E.g. 110001</em>
									</p>
								<? } ?>
                                <p>
                                    <label for="fb">Description: <span class="requiredField">*</span></label>
                                    <textarea cols="25" rows="14"  id="about" name="desc"  pattern="^[a-zA-Z0-9:/.-_?]{25,2000}$"  required><? if($a) echo $a['desc']; ?></textarea>
                                    <em>Gig's Description</em>
                                </p>
                            </fieldset>                                                        
                            <div class="centera" style="width:500px; position:relative; margin: 0 auto; display:block;">
                                <!--I don't know why margin-left, right set to auto does not work here, hence the -50 :(-->
                                <input type="submit" value="<? echo $ok; ?>" style="height:45px; width: 100px; left:50%; margin-left:-50px; position:relative; padding: 5px 5px;"/>
                            </div>
							<div class="formExtra" style=" width:60%; position:relative; margin-top:20px; margin-left:auto; margin-right: auto;">
                                <p><strong>Note: </strong> Fields marked with <span class="requiredField">*</span> are required.</p>
                            </div>
                        </form>
                    </div>
                </div>
        </section>
	</div>
</div>

<script type="text/javascript">
	$('#loading-indicator').hide();
</script>

</body>
</html>