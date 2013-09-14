<?php
ob_start();
function startsWith($haystack, $needle){    return !strncmp($haystack, $needle, strlen($needle));}
if (!isset($_SESSION)) {
session_start();
}
include('connect.php');
if(isset($_SESSION['username'])){
$username=$_SESSION['username'];
$password=$_SESSION['password'];
$actual_type = 'venue';
}
elseif(isset($_SESSION['username_artist'])){
$username=$_SESSION['username_artist'];
$password=$_SESSION['password_artist'];
$actual_type = 'artist';
}

 
 

	if(isset($_FILES['file']['name']) && $_FILES['file']['name']!="" && $_POST["submit"]=="Upload Picture")
	{
		$a=rand(1,10);
		$usernam=md5($username.$a);

		$allowed_filetypes = array('.jpg','.gif','.bmp','.png'); 
		$max_filesize = 524288; 
		if(isset($_SESSION['username_artist'])){     $upload_path = 'images/artist/'; }
		elseif(isset($_SESSION['username'])){     $upload_path = 'images/promoter/'; }
	 
		$filename = $_FILES['file']['name']; 
		$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);  
		$new="$usernam"."$ext";
	   
		if(!in_array($ext,$allowed_filetypes))
			die('The file you attempted to upload is not allowed.');
	 
		if(filesize($_FILES['file']['tmp_name']) > $max_filesize)
			die('The file you attempted to upload is too large.');
	 
		if(!is_writable($upload_path))
			die('You cannot upload to the specified directory, please CHMOD it to 777.');

		if(move_uploaded_file($_FILES['file']['tmp_name'],$upload_path . $new))
		{
			$query = "UPDATE `$database`.`members` SET `user`='$new' WHERE fb_id='$username'";
			$ress = mysql_query($query);
			if (!$ress)
			{die("Database query failed: " . mysql_error());}
			else
			{header('Location: ' . $_SERVER['HTTP_REFERER']);exit;}
			//*****************************
		}

		else
			echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
	}

	elseif($_POST["submit"]=="Use Facebook Picture" && !isset($_GET['gig']))
	{
		$query = "UPDATE `$database`.`members` SET `user`='$username' WHERE fb_id='$username'";
		$ress = mysql_query($query);
		if (!$ress)
		{
			die("Database query failed: " . mysql_error());
		}
		else
		{
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit;
		}
	}

	elseif((isset($_POST['mobile']) && $_POST['mobile']!=""))
	{
		$add=$_POST["add"];
		$city=$_POST["city"];
		$state=$_POST["state"];
		$country=$_POST["country"];
		$pincode=$_POST["pincode"];
		$mobile=$_POST["mobile"];
		$email=$_POST["email"];

		include("connect.php");
		//**********************************************************

		//**************************
		$query = "UPDATE `$database`.`members` SET `mobile`='$mobile', `email`='$email', `add`='$add', `city`='$city', `state`='$state', `country`='$country', `pincode`='$pincode' WHERE fb_id='$username'";
		$ress = mysql_query($query);
		if (!$ress)
		{die("Database query failed: " . mysql_error());}
		//*****************************
		else{
			header("Location: update.php?success=1");

			/************* This code is for MailChimp Integration ****************/
			require_once('../plugin/newsletter-form/MCAPI.class.php');

			// API Key: http://admin.mailchimp.com/account/api/
			$mcapi = new MCAPI('4b1d3dfd9a40c3a47861fa481d644505-us5');

			// List's Id: http://admin.mailchimp.com/lists/
			$list_id = "a29827c7a6";

			// List Parameters
			$email_type = 'html';
			$double_optin=true;
			$update_existing=true;
			$replace_interests=true;
			$send_welcome=false;
			switch($city)
			{
				case 'Delhi':
				case 'Bangalore':
				case 'Goa':
				case 'Mumbai':
					$listCity = $city;
					break;
				default:
					$listCity = 'Others';
					break;
			}
			switch($actual_type)
			{
				case 'artist':
					$listType = 'Artist';
					break;
				case 'venue':
					$listType = 'Venue';
					break;
				case 'promoter':
					$listType = 'Promoter';
					break;
				default:
					$listType = 'Artist';
					break;
			}
			$merge_vars = array('NAME'=>'',
								'GROUPINGS'=>array(
									array('name'=>'User Type', 'groups'=>$listType),
									array('name'=>'Location', 'groups'=>$listCity),
									)
								);

			if($mcapi->listSubscribe($list_id, $email, $merge_vars, $email_type, $double_optin, $update_existing, $replace_interests, $send_welcome) === false)
			{
				//'Error: ' . $mcapi->errorMessage;
				// We don't want to stop registration just because mailchimp did not work.
				// Let's just send an email to alerts@tommyjams.com to notify admin.
				$errorMsg = $mcapi->errorMessage;

				$to = "alerts@tommyjams.com";
				$subject = "Mailchimp TJ Profile failure: $email, Error: $errorMsg";
				$message = "$email could not be added/updated in the current mailchimp list on edit profile. Please try manually. Error being faced: $errorMsg";
				include("include/mail.php");
			}
			
			
			
			
			exit;
		}
	}
  
	elseif((isset($_POST['organization']) && $_POST['organization']!=""))
	{
		$designation=$_POST["designation"];
		$organizationName=$_POST["organization"];$genre=$_POST["genre"];
		 
		include("connect.php");
		//**********************************************************

		//**************************
		$query = "UPDATE `$database`.`members` SET `designation`='$designation', `name`='$organizationName', `genre`='$genre' WHERE fb_id='$username'";
		$ress = mysql_query($query);
		if (!$ress)
		{die("Database query failed: " . mysql_error());}
		//*****************************
		else{
			header("Location: update.php?success=1");
			exit;
		}
	}

	elseif((isset($_POST['fb']) && $_POST['fb']!="" && !isset($_GET["gig"])))
	{
		$fb=$_POST["fb"];	if($fb && !startsWith($fb,'http'))	{		$fb='http://'.$fb;	}
		$twitter=$_POST["twitter"];	if($twitter && !startsWith($twitter,'http'))	{		$twitter='http://'.$twitter;	}
		$myspace=$_POST["myspace"];	if($myspace && !startsWith($myspace,'http'))	{		$myspace='http://'.$myspace;	}
		$rever=$_POST["rever"];	if($rever && !startsWith($rever,'http'))	{		$rever='http://'.$rever;	}
		$youtube=$_POST["youtube"];	if($youtube && !startsWith($youtube,'http'))	{		$youtube='http://'.$youtube;	}

		include("connect.php");
		//**********************************************************

		//**************************
		$query = "UPDATE `$database`.`members` SET `fb`='$fb', `twitter`='$twitter', `reverbnation`='$rever', `youtube`='$youtube', `myspace`='$myspace' WHERE fb_id='$username'";
		$ress = mysql_query($query);
		if (!$ress)
		{die("Database query failed: " . mysql_error());}
		//*****************************
		else{
			header("Location: update.php?success=1");
			exit;
		}
	}
 
	elseif((isset($_POST['about']) && $_POST['about']!=""))
	{
		$about=$_POST["about"];
		$about=str_replace("'", " ", $about);
		include("connect.php");
		//**********************************************************

		//**************************
		$query = "UPDATE `$database`.`members` SET `about`='{$about}' WHERE fb_id='$username'";
		$ress = mysql_query($query);
		if (!$ress)
		{die("Database query failed: " . mysql_error());}
		//*****************************
		else{
			header("Location: update.php?success=1");
			exit;
		}
	}

	elseif(isset($_GET['link']) && $_GET['link']=="activation" && isset($_GET['activate']))
	{
		$link=$_GET['activate'];
		include("connect.php");
		//**********************************************************

		$query = "UPDATE `$database`.`members` SET `status`='1' WHERE link='$link'";
		$ress = mysql_query($query);
		if (!$ress)
		{die("Database query failed: " . mysql_error());}
		//*****************************
		else{
			header("Location: index.php?success=1&set=Account Activated");
			exit;
		}
	}
 
	elseif(isset($_GET['gig']) && $_GET['gig']=="confirm" && isset($_GET['confirm']))
	{
		$link=$_GET['confirm'];
		include("connect.php");
		//**********************************************************

		$query = "UPDATE `$database`.`shop` SET `status`='1' WHERE link='$link'";
		$ress = mysql_query($query);
		if (!$ress)
		{die("Database query failed: " . mysql_error());}
		//*****************************
		else{
			header("Location: index.php?success=1&set=Gig Confirm");
			exit;
		}
	}

	elseif(isset($_GET['change']) && $_GET['change']==1 && (isset($_SESSION['username']) || isset($_SESSION['username_seller'])))
	{
		$old=md5($_POST['old']);
		$new=md5($_POST['new']);
		$renew=md5($_POST['renew']);

		$q1 = "SELECT * FROM `$database`.`members` WHERE username = '{$username}' AND password = '{$password}'";
		$result_set1 = mysql_query($q1);	
		if (mysql_num_rows($result_set1) == 1) 
		{
				$found_admin = mysql_fetch_array($result_set1);
				$pass=$found_admin["password"];
		}
		if($new!=$renew)
		{
			print("New Passwords do not match<br><br><a href='javascript: history.go(-1)'>Back</a>");
			exit;
		}
		if($old!=$pass)
		{
			print("$old<br>$pass<br>OLD Password do not match<br><br><a href='javascript: history.go(-1)'>Back</a>");
			exit;
		}

		//**********************************************************

		$query = "UPDATE `$database`.`members` SET `password`='$new' WHERE fb_id='$username'";
		$ress = mysql_query($query);
		if (!$ress)
		{die("Database query failed: " . mysql_error());}
		//*****************************
		else{
			header("Location: index.php?success=3&set=Password Changed");
			exit;
		}
	}
 
	elseif(isset($_GET['forgot']) && $_GET['forgot']==1 )
	{
		$email=$_POST['email'];
		$pass=rand(10000,999999)."az";
		$passw=md5($pass);
		$q1 = "SELECT * FROM `$database`.`members` WHERE email = '{$email}'";
		$result_set1 = mysql_query($q1);	
		if (mysql_num_rows($result_set1) == 1) 
		{
			$q2 = "UPDATE `$database`.`members` SET password='$passw' WHERE email = '{$email}'";
			$result_set2 = mysql_query($q2);	
			include("files/reset.php");
			header("Location: index.php?success=4&set=Password Reset Successfully");
			exit;
		}
		else{
			header("Location: index.php?error=3&set=No User with given email exist");
			exit;
		}
	}

	elseif(isset($_GET['gig']) && $_GET['gig']=="add" &&  isset($_POST['add']))
	{ 
		$q1 = "SELECT * FROM `$database`.`members` WHERE fb_id='$username'";
		$result_set1 = mysql_query($q1);	
		if (mysql_num_rows($result_set1) == 1) 
		{
				$founded = mysql_fetch_array($result_set1);
				$pid=$founded["link"];$name=$founded["name"];$email=$founded["email"];
		}

		$SQLs = "SELECT id FROM `$database`.`shop`";
		$results = mysql_query($SQLs);
		while ($a = mysql_fetch_assoc($results))
		{
			$id=$a["id"];
		}

		$totalSlots=$_POST["slotNum"];
		for($iSlot=1;$iSlot<=$totalSlots;$iSlot++)
		{
			$id=$id+1;
			$ida=$id*16993; /*changed to 16993 wiz. prime number so that profile id should never match gig id*/

			$fb=$_POST['fb'];if($fb && !startsWith($fb,'http')){	$fb='http://'.$fb;}
			$twitter=$_POST['twitter'];if($twitter && !startsWith($twitter,'http')){	$twitter='http://'.$twitter;}
			$web=$_POST['web'];if($web && !startsWith($web,'http')){	$web='http://'.$web;}
			if($totalSlots>1)
				$gig=$_POST['gig'].': Slot '.$iSlot;
			else
				$gig=$_POST['gig'];
			$cat=$_POST['cat'];
			$budget_min=$_POST['budget_min'];
			$budget_max=$_POST['budget_max'];
			$date=$_POST['year'].'-'.$_POST['month'].'-'.$_POST['date'];
			$time=$_POST['hours'].':'.$_POST['minute'].' '.$_POST['am'];
			$duration=$_POST['duration'];
			$venue_add=$_POST['add'];
			$venue_city=$_POST['city'];
			$venue_state=$_POST['state'];
			$venue_country=$_POST['country'];
			$venue_pin=$_POST['pincode'];
			$desc=$_POST['desc'];
			$q2 = "INSERT INTO `$database`.`shop` (`gig`, `category`, `budget_min`, `budget_max`, `venue_date`, `venue_time`, `duration`, `venue_add`, `venue_city`, `venue_state`, `venue_country`, `venue_pin`, `fb`, `web`, `twitter`, `desc`, `promoter`, `promoter_name`, `link`, `status`) VALUES('$gig', '$cat', '$budget_min', '$budget_max', '$date', '$time', '$duration', '$venue_add', '$venue_city', '$venue_state', '$venue_country',  '$venue_pin',  '$fb',  '$web',  '$twitter', '$desc', '$pid', '$name', '$ida', '1')";
			$result_set2 = mysql_query($q2);
			if (!$result_set2)
			{die("Database query failed: " . mysql_error());}
		}
		if($totalSlots>1)
			$gig=$_POST['gig'];

		$to = $email;
		$subject = "Launched Gig: $gig";
		$mess="<p style='text-align:left;'>		Dear $name,<br><br>		Congratulations!		<br>		Your gig '$gig' has been launched successfully on TommyJams.		<br>		We will keep you updated with any dibs you receive on the gig. You can also monitor them by logging onto your profile on TommyJams and going to the 'My Gigs' section.		<br>		We wish you all the very best for the gig.		<br><br>		Happy Jamming,		<br>		Team TommyJams		<br><br>		</p>		";
		include("include/mail.php");

		$to = "alerts@tommyjams.com";
		include("include/mail.php");

		header("Location:promoter.php?gig=$ida&added=new");
		exit;
	}

	elseif(isset($_GET['gig']) && $_GET['gig']=="updategig" && isset($_GET['id']))
	{
		$id=$_GET['id'];
		$q1 = "SELECT * FROM `$database`.`members` WHERE fb_id='$username'";
		$result_set1 = mysql_query($q1);
		if (mysql_num_rows($result_set1) == 1) 
		{
			$founded = mysql_fetch_array($result_set1);
			$pid=$founded["link"];$name=$founded["name"];$email=$founded["email"];
		}

		$fb=$_POST['fb'];if($fb && !startsWith($fb,'http')){$fb='http://'.$fb;}
		$twitter=$_POST['twitter'];if($twitter && !startsWith($twitter,'http')){$twitter='http://'.$twitter;}
		$web=$_POST['web'];if($web && !startsWith($web,'http')){$web='http://'.$web;}
		$gig=$_POST['gig'];
		$venue_add=addslashes($_POST['add']);
		$desc=addslashes($_POST['desc']);

		$q2 = "UPDATE `$database`.`shop` SET `gig`='$gig', `venue_add`='$venue_add', `fb`='$fb', `web`='$web', `twitter`='$twitter', `desc`='$desc' WHERE `link`='$id'";

		$result_set2 = mysql_query($q2);
		if (!$result_set2)
			{die("Database query failed: " . mysql_error());}

		$to = $email;
		$subject = "Udpated Gig: $gig";

		$mess="<p style='text-align:left;'>		Dear $name,<br><br>		Your gig '$gig' has been Updated successfully on TommyJams.		<br>		We will keep you updated with any dibs you receive on the gig. You can also monitor them by logging onto your profile on TommyJams and going to the 'My Gigs' section.		<br>		We wish you all the very best for the gig.		<br><br>		Happy Jamming,		<br>		Team TommyJams		<br><br>		</p>		";
		include("include/mail.php");

		$to = "alerts@tommyjams.com";
		include("include/mail.php");

		header("Location:promoter.php?gig=$id&edited=new");
		exit;
	}
	
	elseif(isset($_FILES['gigs']['name']) && $_FILES['gigs']['name']!="" && isset($_GET['gig']) && isset($_GET['pic']))
	{
		$a=rand(1,10);
		$usernam=md5($_GET["pic"].'$a');

        $allowed_filetypes = array('.jpg','.gif','.bmp','.png','.PNG','.JPEG'); 
		$max_filesize = 924288; 
		$upload_path = 'images/gig/';
 
		$filename = $_FILES['gigs']['name']; 
		$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);  
		$new="$usernam"."$ext";

		if(!in_array($ext,$allowed_filetypes))
			die('The file you attempted to upload is not allowed.');

		if(filesize($_FILES['gigs']['tmp_name']) > $max_filesize)
			die('The file you attempted to upload is too large.');

		if(!is_writable($upload_path))
			die('You cannot upload to the specified directory, please CHMOD it to 777.');

		if(move_uploaded_file($_FILES['gigs']['tmp_name'],$upload_path . $new))
		{
			$query = "UPDATE `$database`.`shop` SET `image`='$new' WHERE link='$_GET[pic]'";
			$ress = mysql_query($query);
			if (!$ress)
			{die("Database query failed: " . mysql_error());}
			else
			{header('Location: ' . $_SERVER['HTTP_REFERER']);
				exit;}
			//*****************************
		}
		else
			echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
	}

	else
	{
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;	
	}
 
	ob_end_flush();
?>