<div class="register">

<center>
<div id="pageContainer">
	<? if(isset($_GET['success']) && $_GET['success']==1)
	{print("Account Created Successfully<br><br>Verify your email<br>We will personally verify your identity then your account will get activated<br><br>It will take about 24-48hrs for personal verification<br><br><a href='index.php' target='_top'>Home</a>");}
	else{
		if(isset($_GET['error']) && $_GET['error']==1)
	{print("Error!!! Fields left blank");}
	elseif(isset($_GET['error']) && $_GET['error']==2)
	{print("Error!!! Username or email already exist");}
		 ?>
		<!-- Tabs -->
		<ul id="tabs" class="clearfix">
			<li class="activeTab" id="signUpTab">
				<div class="signUpTabContent">
					<span>Create new account</span>
					<h1>Account</h1>
				</div>
				
				<span class="activeTabArrow"><!-- --></span>
			</li>
			
		</ul>
		
		<!-- Sign Up Tab Content -->
		<div id="signUp" class="toggleTab" style="display:block; height:1250px;">
		
			<form action="new.php" method="POST" class="cleanForm" id="signUpForm">
			
				<fieldset>
				
					<p>
						<label for="Select">You are: <span class="requiredField">*</span></label>
						<select id="select" name="you" required />
                        <option value="Artist">Artist</option>
                        <option value="Promoter">Promoter</option>
                        </select>
						<em>Promoter/ Artist</em>
					</p>
                    
                    <p>
						<label for="full-name">Full Name: <span class="requiredField">*</span></label>
						<input type="text" id="full-name" name="name" value=""  pattern="^[a-zA-Z0-9 ]{6,20}$" autofocus required />
						<em>Enter your full name.</em>
					</p>

					<p>
						<label for="username">Username: <span class="requiredField">*</span></label>
						<input type="text" id="username" name="username" pattern="^[a-z0-9_-]{6,20}$" value="" required />
						<em>Between 6 and 20 characters, letters or numbers.</em>
					</p>
					
					<p>
						<label for="password">Password: <span class="requiredField">*</span></label>
						<input type="password" id="password" name="password" value="" pattern="^[a-zA-Z0-9]{6,12}$" required />
						<em>Between 6 and 12 characters, alphanumeric only.</em>
					</p>

					<p>
						<label for="email">Email Address: <span class="requiredField">*</span></label>
						<input type="email" id="email" name="email" value="" required />
						<em>Must be a valid email address(It will be verified). E.g. abc@email.com</em>
					</p>

					<p>
						<label for="phone">Mobile Number:</label>
						<input type="tel" id="phone" name="phone" value="" pattern="^[0-9]{10,10}$" required/>
						<em>10 digits only. E.g. 9876543210</em>
					</p>
					
                    <p>
						<label for="add">Address:</label>
						<input type="text" id="add" name="add" value="" pattern="^[0-9a-zA-Z-,/ ]{8,50}$" required/>
						<em>House number and street</em>
					</p>
                    
                    <p>
						<label for="city">City:</label>
						<input type="text" id="city" name="city" value="" pattern="^[a-zA-Z ]{3,15}$" required/>
						<em>Your city name. E.g. Delhi</em>
					</p>
                    <p>
						<label for="state">State:</label>
						<input type="text" id="state" name="state" value="" pattern="^[a-zA-Z ]{3,15}$" required/>
						<em>Your State. E.g. UP</em>
					</p>
					
					<p>
						<label for="fb">Facebook Profile:</label>
						<input type="text" id="username" name="facebook" value="http://facebook.com/" pattern="^[a-zA-Z0-9:/.-_?]{25,55}$"  required/>
						<em>Your Facebook Profile Link for validation.</em>
					</p>
					
					<div class="distanceLeft">
						<input type="checkbox" id="terms" name="terms" />
						<label for="terms">I have read and agree to the <a href="#">Terms of Service</a>.</label>
					</div>
				
					<input type="submit" value="Register" />

					<div class="formExtra">
						<p><strong>Note: </strong> Fields marked with <span class="requiredField">*</span> are required.</p>
					</div>

				</fieldset>
			
			</form>
			
			<!-- Sidebar -->
			<div id="sidebar">
				<h3>Benefits for signing up</h3>
				
		    <ul>
					<li>To be a part of GIG n DIB</li>
					<li>Be informed of latest GIGs</li>
					<li>Earn as an artist</li>
				</ul>
			</div> <!-- end sidebar -->
		
		</div> <!-- end signUp -->
	<? } ?>
</div> <!-- end pageContainer -->
</center>
<br>

</div>