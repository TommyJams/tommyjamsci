<html>
    <head>
    	<link rel='stylesheet' href='style/edit.css'>
    	<!-- Include the JS files -->

    	<script type="text/JavaScript">
    	function show(d)
    	{ document.getElementById('frameprofessional').style.display="none";
    		document.getElementById('frameabout').style.display="none";
    		document.getElementById('framecontact').style.display="none";
    		document.getElementById('framesocial').style.display="none";	
    		document.getElementById(d).style.display="block";	
    	}

        $('#professionalForm').bind('submit',function(e) 
        {
            e.preventDefault();

            var obj = {
                    designation:    document.getElementById('full-name').value,
                    organization:   document.getElementById('username').value,
                    genre:          document.getElementById('genrename').value
                };

            editProfile("professionalForm",obj);
        });


        $('#socialForm').bind('submit',function(e) 
        {
            e.preventDefault();

            var obj = {
                    fb:             document.getElementById('fb').value,
                    twitter:        document.getElementById('twitter').value,
                    reverbnation:   document.getElementById('reverbnation').value,
                    youtube:        document.getElementById('youtube').value,
                    myspace:        document.getElementById('myspace').value,
                    gplus:          document.getElementById('gplus').value
                };

            editProfile("socialForm",obj);
        });

        $('#contactForm').bind('submit',function(e) 
        {
            e.preventDefault();

            var obj = {
                    phone:      document.getElementById('phone').value,
                    email:      document.getElementById('email').value,
                    add:        document.getElementById('add').value,
                    city:       document.getElementById('city').value,
                    state:      document.getElementById('state').value,
                    country:    document.getElementById('country').value,
                    pincode:    document.getElementById('pincode').value
                };

            editProfile("contactForm",obj);
        });

        $('#aboutForm').bind('submit',function(e) 
        {
            e.preventDefault();

            var obj = {
                    about:    document.getElementById('about').value
                };

            editProfile("aboutForm",obj);
        });
        </script>

    </head>
    <body>
        <section id="left" >
            <div id="pageContainer" style = "width:100%; height:100%;">
                <?                                 
                /*if(isset($_GET['success']) && $_GET['success']==1)
                {
                    print("Change Done Successfullly");
                }
                else
                {
                    if(isset($_GET['error']) && $_GET['error']==1)
                    {print("Error!!! Fields left blank");}
                    elseif(isset($_GET['error']) && $_GET['error']==2)
                    {print("Error!!! Username or email already exist");}*/
                ?>
                    <table id="framemenu" >
                            <tr>
                            <td width="25%"><center><a href="javascript:;" onClick="show('frameprofessional');"><h1>Professional</h1></a></td>
                            <td width="25%"><center><a href="javascript:;" onClick="show('framesocial');"><h1>Social</h1></a></center></td>
                            <td width="25%"><center><a href="javascript:;" onClick="show('framecontact');"><h1>Contact</h1></a></center></td>
                            <td width="25%"><center><a href="javascript:;" onClick="show('frameabout');"><h1>About</h1></a></center></td>
                            <tr>
                    </table>
                    <div id="frameprofessional">
                        <form action="" method="POST" class="cleanForm" id="professionalForm" >
                            <fieldset>
                                <p>
                                    <? if(json_decode($_POST['json'])->type == 'Artist') { print("<label for='designation'>Your Role:</label>");}
                                       elseif(json_decode($_POST['json'])->type == 'Promoter')    { print("<label for='designation'>Designation:</label>");}
                                    ?>
                                    
                                    <input type="text" id="full-name" name="designation" value="<? print(json_decode($_POST['json'])->designation); ?>"  pattern="^[a-zA-Z0-9/ ,-_.:;?]{3,50}$" autofocus />
                                    <br>
                                    <? if(json_decode($_POST['json'])->type == 'Artist') { print("<em>e.g. Guitar, Vocals</em>");}
                                       elseif(json_decode($_POST['json'])->type == 'Promoter')    { print("<em>e.g. Manager</em>");}
                                    ?>
                                </p>
                                <p>
                                    <? if(json_decode($_POST['json'])->type == 'Artist') { print("<label for='organization'>Band Name: <span class='requiredField'>*</span></label>");}
                                       elseif(json_decode($_POST['json'])->type == 'Promoter')    { print("<label for='organization'>Organization: <span class='requiredField'>*</span></label>");}
                                    ?>
                                    <input type="text" id="username" name="organization" pattern="^[a-zA-Z0-9/ ,-_.:;?]{3,50}$" value="<? print (json_decode($_POST['json'])->name); ?>" required />
                                    <br>
                                    <em></em>
                                </p>
                                <p>
                                    <? if(json_decode($_POST['json'])->type == 'Artist') { print("<label for='genre'>Genre: </label>");}
                                       elseif(json_decode($_POST['json'])->type == 'Promoter')    { print("<label for='genre'>Style: </label>");}
                                    ?>
                                    <input type="text" id="genrename" name="genre" pattern="^[a-zA-Z0-9/ ,-_.:;?]{3,50}$" value="<? print (json_decode($_POST['json'])->genre); ?>"/>
                                    <br>
                                    <? if(json_decode($_POST['json'])->type == 'Artist') { print("<em>e.g. Acoustic, Progressive Rock</em>");}
                                       elseif(json_decode($_POST['json'])->type == 'Promoter')    { print("<em>e.g. Cafe, Lounge or Rock, Electronic</em>");}
                                    ?>
                                </p>
                                <center>
                                    <div class="centera" style=" width:500px; position:relative; margin-top:10px; ">
                                        <input type="submit" value="Save Changes" style = "height: 45px; width: auto padding: 5px 5px;"/>
                                    </div>
                                    <div class="formExtra" style="margin-left:60px; margin-right:60px;">
                                        <p><strong>Note: </strong> Fields marked with <span class="requiredField">*</span> are required.</p>
                                    </div>
                                </center>
                            </fieldset>
                        </form>
                    </div>
                    <div id="framesocial">
                        <form action="" method="POST" class="cleanForm" id="socialForm">
                            <fieldset>
                                <p>
                                    <label for="social">Facebook: <span class="requiredField">*</span></label>
                                    <input type="text" id="fb" name="fb" value="<? print (json_decode($_POST['json'])->fb); ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" required />
                                    <br>                                <em>Profile link on Facebook.</em>
                                </p>
                                <p>
                                    <label for="social">Twitter: </label>
                                    <input type="text" id="twitter" name="twitter" value="<? print (json_decode($_POST['json'])->twitter); ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <br>                                <em>Profile link on Twitter.</em>
                                </p>
                                <p>
                                    <label for="social">Reverbnation:</label>
                                    <input type="text" id="reverbnation" name="rever" value="<? print (json_decode($_POST['json'])->reverbnation); ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <br>                                <em>Profile link on Reverbnation.</em>
                                </p>
                                <p>
                                    <label for="social">Youtube:</label>
                                    <input type="text" id="youtube" name="youtube" value="<? print (json_decode($_POST['json'])->youtube); ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <br>                                <em>Profile link on youtube.</em>
                                </p>
                                <p>
                                    <label for="social">MySpace:</label>
                                    <input type="text" id="myspace" name="myspace" value="<? print (json_decode($_POST['json'])->myspace); ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <br>                                <em>Profile link on MySpace.</em>
                                </p>
                                <p>
                                    <label for="social">Google plus:</label>
                                    <input type="text" id="gplus" name="gplus" value="<? print (json_decode($_POST['json'])->gplus); ?>" pattern="^[a-zA-Z0-9/ ,-_.:;&?]{20,150}$" />
                                    <br>                                <em>Profile link on Google+.</em>
                                </p>
                                <center>
                                    <div class="centera" style=" width:500px; position:relative; margin-top:20px;">
                                        <input type="submit" value="Save Changes" style = "height: 45px; width: auto padding: 5px 5px;"/>
                                    </div>
                                    <div class="formExtra" style="margin-left:60px; margin-right:60px;">
                                        <p><strong>Note: </strong> Fields marked with <span class="requiredField">*</span> are required.</p>
                                    </div>
                                </center>
                            </fieldset>
                        </form>
                    </div>
                    <div id="framecontact">
                        <form action="" method="POST" class="cleanForm" id="contactForm">
                            <fieldset>
                                <p>
                                    <label for="phone">Mobile Number: <span class="requiredField">*</span></label>
                                    <input type="tel" id="phone" name="mobile" value="<? print (json_decode($_POST['json'])->mobile); ?>" pattern="^[0-9]{10,10}$" required/>
                                    <br>
                                    <em>10 digits</em>
                                </p>

                                <p>
                                    <label for="email">Email: <span class="requiredField">*</span></label>
                                    <input type="email" id="email" name="email" value="<? print (json_decode($_POST['json'])->email); ?>" pattern="^[0-9a-zA-Z-,/@_.: ]{3,100}$" required/>
                                    <br>
                                    <em></em>
                                </p>

                                <p>
                                    <label for="add">Address:</label>
                                    <input type="text" id="add" name="add" value="<? print (json_decode($_POST['json'])->add); ?>" pattern="^[0-9a-zA-Z-,/ ]{3,100}$"/>
                                    <br>                                <em>Number, Street, Locality</em>
                                </p>
                                
                                <p>
                                    <label for="city">City: <span class="requiredField">*</span></label>
                                    <input type="text" id="city" name="city" value="<? print (json_decode($_POST['json'])->city); ?>" pattern="^[a-zA-Z ]{3,20}$" required/>
                                    <br>                                <em></em>
                                </p>
                                <p>
                                    <label for="state">State:</label>
                                    <input type="text" id="state" name="state" value="<? print (json_decode($_POST['json'])->state); ?>" pattern="^[a-zA-Z ]{3,20}$"/>
                                    <br>                                <em></em>
                                </p>
                                
                                <p>
                                    <label for="Country">Country: <span class="requiredField">*</span></label>
                                    <input type="text" id="country" name="country" value="<? print (json_decode($_POST['json'])->country); ?>" pattern="^[a-zA-Z ]{3,20}$" required/>
                                    <input type="text" id="pincode" name="pincode" value="<? if(json_decode($_POST['json'])->pincode!=0){print (json_decode($_POST['json'])->pincode);} ?>" pattern="^[0-9]{6,6}$"/>
                                    <br>                                <em>Country & PinCode</em>
                                </p>
                                <center>
                                    <div class="centera" style=" width:500px; position:relative; margin-top:20px;">
                                        <input type="submit" value="Save Changes" style = "height: 45px; width: auto padding: 5px 5px;"/>
                                    </div>
                                    <div class="formExtra" style="margin-left:60px; margin-right:60px;">
                                        <p><strong>Note: </strong> Fields marked with <span class="requiredField">*</span> are required.</p>
                                    </div>
                                <center>
                            </fieldset>
                        </form>
                    </div>
                    <div id="frameabout">
                        <form action="" method="POST" class="cleanForm" id="aboutForm">
                            <fieldset>
                                <p>
                                    <label for="fb">About: <span class="requiredField">*</span></label>
                                    <textarea cols="60" rows="14"  id="about" name="about"  pattern="^[a-zA-Z0-9/ ,-_.:;&?']{25,20000}$"  required><? print (json_decode($_POST['json'])->about); ?></textarea>
                                    <br>
                                    <em>About yourself</em>
                                </p>
                                <center>
                                    <div class="centera" style=" width:500px; position:relative; margin-top:20px;">
                                        <input type="submit" value="Save Changes" style = "height: 45px; width: auto padding: 5px 5px;"/>
                                    </div>
                                    <div class="formExtra" style="margin-left:60px; margin-right:60px;">
                                        <p><strong>Note: </strong> Fields marked with <span class="requiredField">*</span> are required.</p>
                                    </div>
                                </center>
                            </fieldset>
                        </form>
                    </div>
                <? /*}*/ ?>
            </div> <!-- end pageContainer -->
        </section> 

	<script type="text/javascript">
		$('#loading-indicator').hide();
	</script>

    </body>
</html>