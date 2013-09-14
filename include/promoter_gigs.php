<html>
<head>
	<link rel='stylesheet' href='style/edit.css'>
	<!-- Include the JS files -->
    <script>
        function loadslide(a) 
        {
            console.log("Value: ", a);
            toggleSlide(a);
            showDib(a);
        }
    </script>

</head>
<body>
    <div id="box" style="display:block; height:100%;">
        <div id="content" class="clearfix">
            <section id="left" style=" width:100%;">
                <div class="gcontent" >
                    <div class="head"><h1>My GIGs</h1></div>
                        <div class="boxy" id="boxy" style="overflow-y:auto;">
							<table width='100%' style='padding: 10px 10px; text-align:center;'>
								<tr bgcolor='#ffcc00' height='30px'>
									<td width="25%"><h1>Name</h1></td>
									<td width="25%"><h1>City</h1></td>
									<td width="10%"><h1>Date</h1></td>
									<td width="10%"><h1>Time</h1></td>
									<td width="30%"><h1>Status</h1></td>
								</tr>
							</table>					
                                    <span class="gigs" style="padding:10px;" >
                                    <?php 
                                    $gigsHistory = (json_decode($_POST['json'])->gigHistory);
                                    foreach($gigsHistory as $row){ ?>
                                    <?
                                        $gig=$row[0];
                                        $city=$row[1];
                                        $formattedDate=$row[2];
                                        $vtime=$row[3];
                                        $artist_id=$row[4];
                                        $artist_name=$row[5];
                                        $contact=$row[6]; 
                                        $link=$row[7];  
                                        $num_rows=$row[8];          
                                      
                                        print("<div class='gigsTableItemContainer'>
											<table width=100% style='text-align:center;'>
												<tr>
													<td width=25%><a href='javascript:;' onClick=gigProfile('$link'); class='highlightRef'><h3>$gig</h3></a></td>
													<td width=25%>$city</td> 
													<td width=10%>$formattedDate </td>
													<td width=10%>$vtime </td>
                                            ");   
                                        if ($num_rows == 1) 
                                        {
										  print("<td>");
										  print("<a href='javascript:;' onClick=showProfile('$artist_id'); class ='greenRef'>$artist_name</a><br>Contact: $contact");
										  print("</td></tr></table></div>");
                                        }
                                        else
                                        {
                                            print("<td><a href='javascript:;' onClick=loadslide('$link'); class ='highlightRef'><img src='images/plus.gif' align='right'></a></td></tr></table></div>
                                                <center><div id='$link' name='$link' style='display:none; height:200px; width:50%; background:#ffcc00; overflow-y: auto;'></div></center>");
                                        }                                    
                                    }
                                    ?>
                                    </span>
                        </div> <!--boxy--> </div> <!--gcontent--><!--
                 <script>
                    document.getElementById('boxy').style.height=self.innerHeight-200+'px';
                </script>-->
            </section>
        </div> <!--content-->
    </div> <!--box-->

	<script type="text/javascript">
		$('#loading-indicator').hide();
	</script>

</body>
</html>