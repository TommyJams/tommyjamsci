<html>
<head>
	<link rel='stylesheet' href='style/edit.css'>
	<!-- Include the JS files -->
	<script> 
		$('#UpdateGigForm').bind('submit',function(e) 
        {
            e.preventDefault();

            var obj = {
                    gig:   		document.getElementById('gig').value,
                    web:   		document.getElementById('website').value,
                    fb:    		document.getElementById('fb').value,
                    twitter:    document.getElementById('twitter').value,
                    add:    	document.getElementById('add').value,
                    desc:    	document.getElementById('about').value,
                    gigLink:       document.getElementById('gigLink').value
                };

            updateGigProfile(obj);
        });
	</script>

</head>
 <body>
 	<?php $ok="Update Gig"; ?>
    <div class="head">
		<h1>LAUNCH GIG</h1>
	</div>
    <div id="box" style="display:block;">
        <div id="content" class="clearfix">
            <section id="left" style=" width:100%;">
                <div class="gcontent">
                    <div id="signUp" class="sign" style="overflow-y:auto">
                        <form action="" name="UpdateGigForm" method="POST" class="cleanForm" id="UpdateGigForm" style="height:100%; margin-top:10px; min-width:800px;">
						<div id="launchContainer">
                            <fieldset id="details" style = "height:auto; float:left">
                                <p>
                                    <label for="gig">Name: <span class="requiredField">*</span></label>
                                    <input type="text" id="gig" name="gig" style="width:200px;" 
                                    value="<? print(json_decode($_POST['json'])->gig); ?>" pattern="^[a-zA-Z0-9. /()-_:@]{3,50}$" autofocus required />
                                    <em>Name of Gig</em>
                                </p> 
                                <p>
                                    <label for="gig">Time:</label>
                                    <select id="select"  disabled="disabled" style="width:60px; float:left;" name="hours">
                                    <?
                                        $hourSaved = (json_decode($_POST['json'])->hourSaved);
                                        for($i=01;$i<=12;$i++){ if( ($a && $hourSaved==$i) || $i==8 ) print("<option value='$i' selected='selected'>$i</option>"); else print("<option value='$i'>$i</option>"); }
                                    ?>      
                                    </select>
                                    <?
                                        $minSaved = (json_decode($_POST['json'])->minSaved);
                                        $amSaved = (json_decode($_POST['json'])->amSaved);
                                    ?>
                                    <select id="select" disabled="disabled" style="width:80px; margin-left: 5px; float:left;" name="minute">
										<option value='00' <? if($a && $minSaved=='00') print("selected='selected'"); ?> >00</option>
										<option value='30' <? if($a && $minSaved=='30') print("selected='selected'"); ?> >30</option>
                                    </select>                            
                                    <select id="select" disabled="disabled" style="width:60px; margin-left: 5px; float:left;" name="am">
                                        <option value='PM' <? if($a && $amSaved=='PM') print("selected='selected'"); ?> >PM</option>
										<option value='AM' <? if($a && $amSaved=='AM') print("selected='selected'"); ?> >AM</option>
                                    </select>
                                    <em>Time of Gig</em>
                                </p>
								<p>
									<label for="gig">Duration:</span></label>
                                    <select id="select"  disabled="disabled" style="width:60px; float:left;" name="duration">
                                    <?
                                        $durationSaved = (json_decode($_POST['json'])->durationSaved);
                                        for($i=0.5;$i<=24;$i = $i + 0.5){ if($a && $i == $durationSaved) print("<option value='$i' selected='selected'>$i</option>"); else print("<option value='$i'>$i</option>"); }
                                    ?>
                                    </select>
									<em>in Hours</em>
								</p>
                                <p>
                                    <label for="Website">Website:</label>
                                    <input type="text" id="website" name="web" style="width:200px;" value="<? print(json_decode($_POST['json'])->web); ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <em>Gig's Website</em>
                                </p>
                                <p>
                                    <label for="social">Facebook:</label>
                                    <input type="text" id="fb" name="fb" style="width:200px;" value="<? print(json_decode($_POST['json'])->fb); ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <em>Gig's link on Facebook.</em>
                                </p>
                                <p>
                                    <label for="social">Twitter: </label>
                                    <input type="text" id="twitter" name="twitter" style="width:200px;" value="<? print(json_decode($_POST['json'])->twitter); ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <em>Gig's link on Twitter.</em>
                                </p>
                            </fieldset>
                            <fieldset id="venue">
                                <p>
                                    <label for="add">Address: <span class="requiredField">*</span></label>
                                    <input type="text" id="add" name="add" value="<? print(json_decode($_POST['json'])->add); ?>" pattern="^[0-9a-zA-Z !@#$%^&*()_,.\\/{}|:<>?-]{3,100}$" required/>
                                    <em>Venue Address</em>
                                </p>
                                <p>
                                    <label for="fb">Description: <span class="requiredField">*</span></label>
                                    <textarea cols="25" rows="14"  id="about" name="desc"  pattern="^[a-zA-Z0-9:/.-_?]{25,2000}$"  required><? print(json_decode($_POST['json'])->desc); ?></textarea>
                                    <em>Gig's Description</em>
                                </p>
                            </fieldset>                                                        
                            <div class="centera" style="width:500px; position:relative; margin: 0 auto; display:block;">
                                <!--I don't know why margin-left, right set to auto does not work here, hence the -50 :(-->
                                <input type="submit" value="<? echo $ok; ?>" style="height:45px; width: 100px; left:50%; margin-left:-50px; position:relative; padding: 5px 5px;"/>
                            </div>
                            <div>
                                <?php $link = (json_decode($_POST['json'])->link); ?>
                                <input type="hidden" name="gigLink" id="gigLink" value="<? print($link);?>">
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