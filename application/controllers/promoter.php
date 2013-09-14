<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promoter extends CI_Controller{

	public function promoterpage(){
		ob_start();

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
			session_start();
		}

		if(!isset($sessionArray['username']))
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
			exit;
		}
		
		$username=$sessionArray['username'];
		$password=md5($sessionArray['password']);

		$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
		$results = mysql_query($SQLs);
		
		// Initializing variables
		$type = "";
		$user = "";
		
		while ($a = mysql_fetch_assoc($results))
		{
			$id=$a["id"];$idaa=$id;$name=$a["name"];
			$sessionArray['name']=$name;
			$email=$a["email"];$street=$a["add"];$city=$a["city"];$state=$a["state"];$country=$a["country"];$pincode=$a["pincode"];
			$mobile=$a["mobile"];$fb=$a["fb"];$twitter=$a["twitter"];$youtube=$a["youtube"];$myspace=$a["myspace"];$rever=$a["reverbnation"];
			$gplus=$a["gplus"];$display=$a["display"];$user=$a["user"];$type=$a["type"];
			$job=$a["job"];$designation=$a["designation"];
			$artistrate=$a["artistrate"];$adminrate=$a["adminrate"];
		}

		$users = "";
		if($type=="Promoter"){     $users="images/promoter/$user";; }
 		elseif($type=="Artist"){     $users="images/artist/$user"; }
		if(!file_exists($users) && $user==""){$users="images/profile.jpg";}
		else if(!file_exists($users) && $user!=""){$users="https://graph.facebook.com/"."$user/picture&type=large";}

		// loading artist_view file
		$this->load->view('promoter_view');
	}

	public function profilepage(){

		$sessionArray = $this->session->all_userdata();

		// Initializing variables. 
		// Codeigniter throws "undefined variable" error on un-intialized variables.
		$type = "";
		$user = "";
		$nsilver = "";
		//$id = "";
		
		if(isset($sessionArray['username_artist'])  && !isset($_POST['id']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);

			$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
			$results = mysql_query($SQLs);

			while ($a = mysql_fetch_assoc($results))
			{
				$id=$a["id"];$idaa=$id;$usernam=$a["username"];$name=$a["name"];$_SESSION['name']=$name;$email=$a["email"];
				$street=$a["add"];$city=$a["city"];$state=$a["state"];$country=$a["country"];$pincode=$a["pincode"];
				$mobile=$a["mobile"]; $fb_username=$a["fb_username"];
				$fb=$a["fb"];$twitter=$a["twitter"];$youtube=$a["youtube"];$myspace=$a["myspace"];$rever=$a["reverbnation"];
				$gplus=$a["gplus"];$display=$a["display"];$user=$a["user"];$type=$a["type"];$genre=$a["genre"];
				$job=$a["job"];$designation=$a["designation"];
				$artistrate=$a["artistrate"];$adminrate=$a["adminrate"];$about=$a["about"];
				$gold=$a["gold"];$silver=$a["silver"];$nsilver=$a["nsilver"];$bronze=$a["bronze"];$link=$a["link"];

				$response=$a;
			}
		}
		else if(isset($sessionArray['username'])  && !isset($_POST["id"]))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);

			$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
			$results = mysql_query($SQLs);
			while ($a = mysql_fetch_assoc($results))
			{
				$id=$a["id"];$idaa=$id;$usernam=$a["username"];$name=$a["name"];$_SESSION['name']=$name;$email=$a["email"];
				$street=$a["add"];$city=$a["city"];$state=$a["state"];$country=$a["country"];$pincode=$a["pincode"];
				$mobile=$a["mobile"];
				$fb=$a["fb"];$twitter=$a["twitter"];$youtube=$a["youtube"];$myspace=$a["myspace"];$rever=$a["reverbnation"];$gplus=$a["gplus"];
				$display=$a["display"];$user=$a["user"];$type=$a["type"];$genre=$a["genre"];
				$job=$a["job"];$designation=$a["designation"];
				$artistrate=$a["artistrate"];$adminrate=$a["adminrate"];$about=$a["about"];
				$gold=$a["gold"];$silver=$a["silver"];$nsilver=$a["nsilver"];$bronze=$a["bronze"];$link=$a["link"];

				$response=$a;
			}
		}
		else
		{
			$link = $_POST['id'];

			$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE link='$link'";
			$results = mysql_query($SQLs);

			if (mysql_num_rows($results) == 1) 
			{
				$a = mysql_fetch_array($results);
				$id=$a["id"];$idaa=$id;$usernam=$a["username"];$name=$a["name"];$_SESSION['name']=$name;$email=$a["email"];
				$street=$a["add"];$city=$a["city"];$state=$a["state"];$country=$a["country"];$pincode=$a["pincode"];
				$mobile=$a["mobile"];
				$fb=$a["fb"];$twitter=$a["twitter"];$youtube=$a["youtube"];$myspace=$a["myspace"];$rever=$a["reverbnation"];$gplus=$a["gplus"];
				$display=$a["display"];$user=$a["user"];$type=$a["type"];$genre=$a["genre"];
				$job=$a["job"];$designation=$a["designation"];
				$artistrate=$a["artistrate"];$adminrate=$a["adminrate"];$about=$a["about"];
				$gold=$a["gold"];$silver=$a["silver"];$nsilver=$a["nsilver"];$bronze=$a["bronze"];$link=$a["link"];

				$response=$a;
			}
			else {
				error_log('No user Exist');
				exit;
			}
		}

		// Initializing variables before they are used. 
		// Codeigniter throws "undefined" error on un-intialized variables.
		$userRating = "";
		$users = "";

		if($nsilver>0)
			{$userRating=round(($gold/2+$silver/2),1);}
		else
			{$userRating=$gold;}

		if($about=="")
			{$about="Add details for this section by editing your profile";}

		if($type=="Promoter"){     $users="images/promoter/$user";$usersa="../images/promoter/$user";; }
	 	elseif($type=="Artist"){     $users="images/artist/$user";$usersa="../images/artist/$user"; }

		if(!file_exists($usersa) && $user==""){$users="images/profile.jpg";}
		else if(!file_exists($usersa) && $user!=""){$users="https://graph.facebook.com/"."$user/picture?type=large";}

		$response['userRating'] = $userRating;
		$response['about'] = $about;
		$response['users'] = $users;

	    if($type=="Promoter"){   
	        $SQLs = "SELECT * FROM `".DATABASE."`.`transaction` WHERE promoter_id=$link AND status=1 ORDER BY id DESC"; 
	    }
	    else if($type=="Artist"){   
	        $SQLs = "SELECT * FROM `".DATABASE."`.`transaction` WHERE artist_id=$link AND status=1 ORDER BY id DESC"; 
	    }
	    $results = mysql_query($SQLs);

		while ($a = mysql_fetch_assoc($results))
	    {
	        $gig_id=$a["gig_id"];$ar_name=$a["artist_name"];$pr_name=$a["promoter_name"];
	        $ar_id=$a["artist_id"];$pr_id=$a["promoter_id"];
	                               
	        $SQL = "SELECT * FROM `".DATABASE."`.`shop` WHERE link=$gig_id";
	        $result = mysql_query($SQL);
	        
	        while ($b = mysql_fetch_assoc($result))
	        {
	        	$gig_name=$b["gig"];$v_state=$b["venue_state"];$v_city=$b["venue_city"];$v_date=$b["venue_date"];
	        }
			
			$formattedDate = date('d-m-Y',strtotime($v_date));

			$gigRow = array($gig_name, $pr_id, $pr_name, $ar_id, $ar_name, $formattedDate, $v_city, $gig_id);

			$response['gigHistory'][] = $gigRow;
		}	

		$this->load->helper('functions');
		createResponse($response);

	}

	public function mygigs(){
		ob_start();

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
			session_start();
		}
		if(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);
		}
		else
		{
			$this->sessionlogout();
			exit;
		}

		$artist_id = "";
		$artist_name = "";
		$num_rows = "";
		$contact = "";

		$q2 = "SELECT link FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
	    $result_set2 = mysql_query($q2);	
	    if (mysql_num_rows($result_set2) == 1) 
	    {
	        $found = mysql_fetch_array($result_set2);
	        $promoter_id=$found["link"];
	    } 
	    $SQLs = "SELECT * FROM `".DATABASE."`.`shop`  WHERE promoter=$promoter_id ORDER BY id DESC";
	    $results = mysql_query($SQLs);                                                                

	    while ($a = mysql_fetch_assoc($results))
	    {
	        $id=$a["id"];$gig=$a["gig"];$cat=$a["category"];
	        $add=$a["venue_add"];$city=$a["venue_city"];$state=$a["venue_state"];$country=$a["venue_country"];
	        $pincode=$a["venue_pin"];
	        $date=$a["venue_date"];$vtime=$a["venue_time"]; $formattedDate = date('d-m-Y',strtotime($date));
	        $period=$a["period"];
	        $status=$a["status"];$link=$a["link"];
	    	$desc=$a["desc"];$budget_min=$a["budget_min"];$budget_max=$a["budget_max"];$time=$a["time"];   

	        $q2 = "SELECT * FROM `".DATABASE."`.`transaction` WHERE gig_id=$link AND status=1";
	        $result_set2 = mysql_query($q2);    
	        if (mysql_num_rows($result_set2) == 1) 
	        {
	        	$num_rows = 1;
	            $found = mysql_fetch_array($result_set2);
	        	$artist_id=$found["artist_id"];
	        	$artist_name=$found["artist_name"];
	        
	        	$SQLe = "SELECT mobile FROM `".DATABASE."`.`members` WHERE link=$artist_id";
	        	$resulte = mysql_query($SQLe);
				$f = mysql_fetch_assoc($resulte);
				$contact = $f['mobile'];			
	        }
	        else
	        {
	        	$num_rows = 0;
	        	$artist_id = "";
	        	$artist_name ="";	
	        	$contact = "";
	        }  		 	

			$gigRow = array($gig, $city, $formattedDate, $vtime, $artist_id, $artist_name, $contact, $link, $num_rows);

			$response['gigHistory'][] = $gigRow; 
		}
		
		$this->load->helper('functions');
		createResponse($response);
	}

	public function sessionlogout(){

		ob_start();
		$sessionArray = $this->session->all_userdata();
		
		if (!isset($sessionArray['session_id'])) {
			session_start();
		}

		$username=$sessionArray['username'];
		$this->session->sess_destroy();
		redirect('http://testcodeigniter.azurewebsites.net/index');
		exit;
	}

	public function gigProfilePage(){

		$sessionArray = $this->session->all_userdata();

		$user_id = $_POST['id']; 
		error_log($user_id);

		$SQLs = "SELECT * FROM `".DATABASE."`.`shop` WHERE link='$user_id'";
		$results = mysql_query($SQLs);
		$a = mysql_fetch_array($results);
		{
			$id=$a["id"];$gig=$a["gig"];$cat=$a["category"];
			$add=$a["venue_add"];$city=$a["venue_city"];$state=$a["venue_state"];
			$country=$a["venue_country"];$pincode=$a["venue_pin"];
			$fb=$a["fb"];$twitter=$a["twitter"];$web=$a["web"];
			$date=$a["venue_date"];$vtime=$a["venue_time"];$duration=$a["duration"];
			$formattedDate = date('d-m-Y',strtotime($date));
			$period=$a["period"];$promoter_name=$a["promoter_name"];$promoter=$a["promoter"];
		
			/*$SQLs = "SELECT mobile FROM `".DATABASE."`.`members` WHERE link='$promoter'";
			$result = mysql_query($SQLs);
			$b = mysql_fetch_array($result);
			{$mobile=$b["mobile"];}*/
		
			//if(!isset($_SESSION["username"])){$mobile=$mobile[0]." * * * * * * * *";}
				
			$status=$a["status"];$link=$a["link"];$image=$a["image"];
			$desc=$a["desc"];$budget_min=$a["budget_min"];
			$budget_max=$a["budget_min"]+$a["budget_min"]*$a["budget_max"]/100;$time=$a["time"];

			//$response = $a;
		}

		if($image=="")
		{
			$image="gigs.jpg";
		}

		$gigs="images/gig/$image";
		$response['gigs'] = $gigs;

		$todayTime = strtotime(date("Y-m-d"));
		$dated = strtotime($date); 

		$username = $sessionArray['username']; 

		$yes=0;

		$SQLsa = "SELECT link FROM `".DATABASE."`.`members` WHERE `fb_id`='$username'";
		$resultsa = mysql_query($SQLsa);
		if (!$resultsa)
			die("Database query failed: " . mysql_error());
		$pl = mysql_fetch_assoc($resultsa);
		$prolink=$pl["link"];

	    $q4 = "SELECT * FROM `".DATABASE."`.`transaction` WHERE gig_id=$link AND status=1";
	    $result_set4 = mysql_query($q4);	
		if (mysql_num_rows($result_set4) == 1) 
	    {
	        $found = mysql_fetch_array($result_set4);
	        $yes=1;
			$artist_booked_id=$found["artist_id"];
			$artist_booked_name=$found["artist_name"];

			$response['artist_booked_id'] = $artist_booked_id;
			$response['artist_booked_name'] = $artist_booked_name;

			$gigStatus = 1;
			$response['gigStatus'] = $gigStatus;	
			$yes = 1;	
	    }

	    //$promoter = $response["promoter"];
		elseif($promoter==$prolink)
		{
			$gigStatus = 2;
			$response['gigStatus'] = $gigStatus;
		}
	    
	    elseif(isset($sessionArray['username_artist']))
	    { 
	    	$gigSession = 1;
	    	$username_artist = $sessionArray['username_artist'];
	    	$q2 = "SELECT link FROM `".DATABASE."`.`members` WHERE fb_id='$username_artist'";
	        $result_set2 = mysql_query($q2);	    
	        if (mysql_num_rows($result_set2) == 1) 
	        {
	            $found = mysql_fetch_array($result_set2);
	            $artist_id = $found["link"];
	        }

	        $q4 = "SELECT * FROM `".DATABASE."`.`transaction` WHERE gig_id=$link AND artist_id=$artist_id";
	        $result_set4 = mysql_query($q4);	
	        if (mysql_num_rows($result_set4) == 1) 
	        {                    
				$found = mysql_fetch_array($result_set4);
	            $statuss=$found["status"];
	            if($statuss==1){$gigStatus = 3; $response['gigStatus'] = $gigStatus;}
	            elseif($statuss==2){$gigStatus = 4; $response['gigStatus'] = $gigStatus;}
	            elseif($statuss==4){$gigStatus = 5; $response['gigStatus'] = $gigStatus;}
	        }
		
			elseif($todayTime > $dated)
			{
				$gigStatus = 6;
				$response['gigStatus'] = $gigStatus;
			}
	        else
	        {                       
	            if($yes!=1)
	        	{   
	        		$gigStatus = 7;
	        		$response['gigStatus'] = $gigStatus;
	        	}
	        }
	    } 
	    elseif($todayTime > $dated)
		{
			$gigStatus = 8;
			$response['gigStatus'] = $gigStatus;
		}   
	    
		$response['link'] = $link;
	    $response['gig'] = $gig; 
	    $response['cat'] = $cat;   
		$response['budget_min'] = $budget_min;
		$response['budget_max'] = $budget_max;
		$response['formattedDate'] =  $date;
		$response['vtime'] = $time;
		$response['duration'] = $duration;
		$response['fb'] = $fb;
		$response['web'] = $web;
		$response['twitter'] = $twitter;
		$response['desc'] = $desc;
		$response['promoter_name'] = $promoter_name;
		$response['city'] = $city;
		$response['state'] = $state;
		$response['country'] = $country;
		$response['gigStatus'] = $gigStatus;
		$response['add'] = $add;
		$response['pincode'] = $pincode;
	                        
		$this->load->helper('functions');
		createResponse($response);

	}

	public function launchGigFunc(){

		ob_start();

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])){
			session_start();
		}

		if(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);
			$actual_type = 'venue';
		}

		elseif(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=$sessionArray['password_artist'];
			$actual_type = 'artist';
		}

		$this->load->helper('functions');

		$q1 = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
		$result_set1 = mysql_query($q1);	
		if (mysql_num_rows($result_set1) == 1) 
		{
			$founded = mysql_fetch_array($result_set1);
			$pid=$founded["link"];$name=$founded["name"];$email=$founded["email"];
		}

		$SQLs = "SELECT id FROM `".DATABASE."`.`shop`";
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
				
			$q2 = "INSERT INTO `".DATABASE."`.`shop` (`gig`, `category`, `budget_min`, `budget_max`, `venue_date`, `venue_time`, `duration`, `venue_add`, `venue_city`, `venue_state`, `venue_country`, `venue_pin`, `fb`, `web`, `twitter`, `desc`, `promoter`, `promoter_name`, `link`, `status`) 
					VALUES('$gig', '$cat', '$budget_min', '$budget_max', '$date', '$time', '$duration', '$venue_add', '$venue_city', '$venue_state', '$venue_country',  '$venue_pin',  '$fb',  '$web',  '$twitter', '$desc', '$pid', '$name', '$ida', '1')";
			$result_set2 = mysql_query($q2);
			if (!$result_set2)
			{
					die("Database query failed: " . mysql_error());
			}
		}
			
		//	if($totalSlots>1)
		//		$gig=$_POST['gig'];

		$to = $email;
		$sender = "alerts@tommyjams.com";
		$subject = "Launched Gig: $gig";
		$mess="<p style='text-align:left;'> Dear $name,<br><br>Congratulations!<br>Your gig '$gig' has been launched successfully on TommyJams.
					<br>We will keep you updated with any dibs you receive on the gig. You can also monitor them by logging onto your profile on TommyJams and going to the 'My Gigs' section.
					<br>We wish you all the very best for the gig.<br><br>Happy Jamming,<br>Team TommyJams<br><br></p>";
			
		$this->load->helper('mail');
	    send_email($to, $sender, $subject, $mess);

		$to = "alerts@tommyjams.com";
		$this->load->helper('mail');
	    send_email($to, $sender, $subject, $mess);

	    $image="gigs.jpg";
		
		$gigs="images/gig/$image";
		$response['gigs'] = $gigs;

	    $gigStatus = 2;

	    $response['gig'] = $gig; 
	    $response['cat'] = $cat;   
		$response['budget_min'] = $budget_min;
		$response['budget_max'] = $budget_max;
		$response['formattedDate'] =  $date;
		$response['vtime'] = $time;
		$response['duration'] = $duration;
		$response['fb'] = $fb;
		$response['web'] = $web;
		$response['twitter'] = $twitter;
		$response['desc'] = $desc;
		$response['promoter_name'] = $name;
		$response['city'] = $venue_city;
		$response['state'] = $venue_state;
		$response['country'] = $venue_country;
		$response['gigStatus'] = $gigStatus;
		$response['add'] = $venue_add;
		$response['pincode'] = $venue_pin;

		createResponse($response);
	}

	public function updateGigPage(){

		$sessionArray = $this->session->all_userdata();

		if(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);
		}
		else
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
			exit;
		}

		$SQLsa = "SELECT link FROM `".DATABASE."`.`members` WHERE `fb_id`='$username'";
		$resultsa = mysql_query($SQLsa);
		if (!$resultsa)
			die("Database query failed: " . mysql_error());
		
		$pl = mysql_fetch_assoc($resultsa);
		$plink=$pl["link"];
		
		// need to see this $link
		$link=$_POST["link"];

		$SQLs = "SELECT * FROM `".DATABASE."`.`shop` WHERE `link`=$link AND `promoter`=$plink";
		$results = mysql_query($SQLs);
		if (!$results)
			die("Database query failed: " . mysql_error());

		$a = mysql_fetch_assoc($results);
		{
			$gig = $a['gig'];
			
			$timeSaved = $a['venue_time'];
			$tempExplode1 = explode(":",$timeSaved);
			list($hour, $min_am) = explode(":", $timeSaved);
			$hourSaved = $hour;
			list($min, $am) = explode(" ", $min_am);

			$minSaved = $min;
			$amSaved = $am; 

		/*	$hourSaved = $tempExplode1[0];
			$tempExplode2 = explode(" ",$tempExplode1);
			$minSaved = $tempExplode2[0];
			$amSaved = $tempExplode2[1]; */
			
			$duration = $a['duration'];
			$web = $a['web'];
			$fb = $a['fb'];
			$twitter = $a['twitter'];
			$add = $a['venue_add'];
			$desc = $a['desc'];

			$response['link'] = $link;
			$response['gig'] = $gig;
			$response['hourSaved'] = $hourSaved;
			$response['minSaved'] = $minSaved;
			$response['amSaved'] = $amSaved;
			$response['durationSaved'] = $duration;
			$response['web'] = $web;
			$response['fb'] = $fb;
			$response['twitter'] = $twitter;
			$response['add'] = $add;
			$response['desc'] = $desc;
		}

		$this->load->helper('functions');
		createResponse($response);

		/*
		$do="updategig&id=$link";
		$show=0;
		$ok="Update Gig";

		$durationSaved = $a['duration'];
		$timeSaved = $a['venue_time'];
		$tempExplode1 = explode(":",$timeSaved);
		$hourSaved = $tempExplode1[0];
		$tempExplode2 = explode(" ",$tempExplode1);
		$minSaved = $tempExplode2[0];
		$amSaved = $tempExplode2[1]; */
	}

	public function updateGigProfile(){

		ob_start();
		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id()'])) {
			session_start();
		}

		if(!isset($sessionArray['username']))
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
			exit;
		}	

		$username=$sessionArray['username'];
		$password=md5($sessionArray['password']);

		$id = $_POST['gigLink'];

		$q1 = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
		$result_set1 = mysql_query($q1);
		if (mysql_num_rows($result_set1) == 1) 
		{
			$founded = mysql_fetch_array($result_set1);
			$pid=$founded["link"];$name=$founded["name"];$email=$founded["email"];
		}

		$this->load->helper('functions');
		$fb=$_POST['fb'];if($fb && !startsWith($fb,'http')){$fb='http://'.$fb;}
		$twitter=$_POST['twitter'];if($twitter && !startsWith($twitter,'http')){$twitter='http://'.$twitter;}
		$web=$_POST['web'];if($web && !startsWith($web,'http')){$web='http://'.$web;}
		$gig=$_POST['gig'];
		$venue_add=addslashes($_POST['add']);
		$desc=addslashes($_POST['desc']);

		$q2 = "UPDATE `".DATABASE."`.`shop` SET `gig`='$gig', `venue_add`='$venue_add', `fb`='$fb', `web`='$web', `twitter`='$twitter', `desc`='$desc' WHERE `link`='$id'";

		$result_set2 = mysql_query($q2);
		if (!$result_set2)
		{
			$error = 1;
		}
		else
		{
			$error = 2;
		}

		$to = $email;
		$subject = "Udpated Gig: $gig";
		$mess="<p style='text-align:left;'>Dear $name,<br><br>Your gig '$gig' has been Updated successfully on TommyJams.		<br>		We will keep you updated with any dibs you receive on the gig. You can also monitor them by logging onto your profile on TommyJams and going to the 'My Gigs' section.		<br>		We wish you all the very best for the gig.		<br><br>		Happy Jamming,		<br>		Team TommyJams		<br><br>		</p>		";
		$sender = "alerts@tommyjams.com";
				
		$this->load->helper('mail');
	    send_email($to, $sender, $subject, $mess);
				
		$to = "alerts@tommyjams.com";
		send_email($to, $sender, $subject, $mess);
		
		$response['id'] = $id;
		$response['error'] = $error;

		$this->load->helper('functions');
		createResponse($response);
	}

	public function reactionDib(){

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id()'])) 
		{
			session_start();
		}

		if(!isset($sessionArray['username']))
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
			exit;
		}	

		$username=$sessionArray['username'];
		$password=md5($sessionArray['password']);

		error_log('reactionDib: 1');

		//$link=$_POST["gig"]/15999;
		$link=$_POST['link'];
		$artistId=$_POST['artist_id'];
		$accepted=$_POST['accepted'];

		if($accepted == 1)
		{
			$SQLs = "UPDATE `".DATABASE."`.`transaction` SET status=1 WHERE gig_id='$link' AND artist_id='$artistId'";
			$results = mysql_query($SQLs);
			if(!$results)
			{
				$error = 1;
				$response['error'] = $error;
				$this->load->helper('functions');
				createResponse($response);
			}
		
			$SQLs = "SELECT * FROM `".DATABASE."`.`transaction` WHERE gig_id='$link'";
			$results = mysql_query($SQLs);
			while ($a = mysql_fetch_assoc($results))
			{
				$status=$a["status"];
				$gig=$a["gig_name"];
				$artist_id=$a["artist_id"];
				$artist_name=$a["artist_name"];
				$promoter_name=$a["promoter_name"];
			
				$q2 = "SELECT * FROM `".DATABASE."`.`members` WHERE link='$artist_id'";
				$result_set2 = mysql_query($q2);	
				if (mysql_num_rows($result_set2) == 1) 
				{
					$found = mysql_fetch_array($result_set2);
					$artist_name=$found["name"];
					$artist_email=$found["email"];
				}
				$to = $artist_email;
				$gigname=$gig;

				if($status==1)
				{
					$SQLs = "SELECT * FROM `".DATABASE."`.`shop` WHERE link='$link'";
					$result1 = mysql_query($SQLs);
					$a = mysql_fetch_array($result1);
					{
						$gig=$a["gig"];$date=$a["venue_date"];$vtime=$a["venue_time"];
						$promoter_name=$a["promoter_name"];$promoter=$a["promoter"];
					}
					$q8 = "INSERT INTO `".DATABASE."`.`rating` (`id`, `event_date`, `event_time`, `status`, `artist_id`, `artist_name`, `promoter_id`, `promoter_name`, `gig_id`, `gig_name`, `promoter_rate`, `promoter_comment`, `promoter_gig_rate`, `promoter_gig_comment`, `promoter_future`, `artist_rate`, `artist_comment`, `artist_dib_comment`, `artist_future`, `time`)
												VALUES (NULL, '$date', '$vtime', '2', '$artist_id', '$artist_name', '$promoter', '$promoter_name', '$link', '$gig', '', '', '', '', '', '', '', '', '', CURRENT_TIMESTAMP);";
					$result_set8 = mysql_query($q8);
					if (!$result_set8)
					{
						$error = 1;
						$response['error'] = $error;
						$this->load->helper('functions');
						createResponse($response);
					}
					$acceptedArtist=$artist_name;
					$subject = "Dib Accepted for $gig";

					$mess="<p style='text-align:left;'>
					Dear $artist_name,<br><br>
					Congratulations! Your dib has been accepted for the gig: '$gig' on TommyJams.
					<br>
					Please login to your profile on TommyJams and view the host details and contact number in the 'Dibs Status' section.
					<br>
					We wish you all the very best for the gig.
					<br><br>
					Happy Jamming,
					<br>
					Team TommyJams
					<br><br>
					</p>
					<center>
					<table border='1'>
						<tr>
							<td>Gig</td>
							<td>$gig</td>
						</tr>
						<tr>
							<td>Promoter</td>
							<td>$promoter_name</td>
						</tr>
						<tr>
							<td>Rate Promoter and Gig</td>
							<td><a href='/artist/feedback/$link'>RATE</a> (enabled only after the gig)</td>
						</tr>
					</table>
					</center>
					";
				}
				elseif($status==2)
				{
					continue;
				}
				elseif($status==4)
				{
					$subject = "Dib Rejected for $gig";
					$mess="<p style='text-align:left;'>
					Dear $artist_name,<br><br>
					Sorry, your dib for the gig: '$gig' has been rejected by the host.
					<br>
					However, there are a lot more gigs to be booked on TommyJams and you'll surely find the right ones for you. Please login to your profile on TommyJams and search for the latest gigs in the 'Find Gigs' section.
					<br>
					We wish you all the very best in the future.
					<br><br>
					Happy Jamming,
					<br>
					Team TommyJams
					<br><br>
					</p>
					<center>
					<table border='1'>
						<tr>
							<td>Gig</td>
							<td>$gig</td>
						</tr>
						<tr>
							<td>Promoter</td>
							<td>$promoter_name</td>
						</tr>
					</table>
					</center>
					";
				}
			
				$sender = "alerts@tommyjams.com";
				
				$this->load->helper('mail');
	            send_email($to, $sender, $subject, $mess);
				
				$to = "alerts@tommyjams.com";
				send_email($to, $sender, $subject, $mess);
			}	
		
			$SQLs = "UPDATE `".DATABASE."`.`transaction` SET status=2 WHERE gig_id='$link' AND status=4";
			$results2 = mysql_query($SQLs);

			$q2 = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
			$result_set2 = mysql_query($q2);
			if (mysql_num_rows($result_set2) == 1) 
			{
				$found = mysql_fetch_array($result_set2);
				$promoter_name=$found["name"];
				$promoter_email=$found["email"];
				$to = $promoter_email;
				$subject = "Booked Gig: $gigname";
				$mess="<p style='text-align:left;'>
					Dear $promoter_name,<br><br>
					Congratulations! Your gig: '$gigname' is now booked on TommyJams.
					<br>
					Please login to your profile on TommyJams and view the artist details and contact number in the 'My Gigs' section.
					<br>
					We wish you all the very best for the gig.
					<br><br>
					Happy Jamming,
					<br>
					Team TommyJams
					<br><br>
					</p>
					<center>
					<table border='1'>
						<tr>
							<td>Gig</td>
							<td>$gig</td>
						</tr>
						<tr>
							<td>Artist</td>
							<td>$acceptedArtist</td>
						</tr>
						<tr>
							<td>Rate Artist and Gig</td>
							<td><a href='/promoter/feedback/$link'>RATE</a> (enabled only after the gig)</td>
						</tr>
					</table>
					</center>
					";
				$sender = "alerts@tommyjams.com";
				
				$this->load->helper('mail');
	            send_email($to, $sender, $subject, $mess);
				
				$to = "alerts@tommyjams.com";
				send_email($to, $sender, $subject, $mess);
			}
			
			$response['linker'] = $link;
			$response['error'] = 0;
			$response['accept'] = 1;
			$this->load->helper('functions');
			createResponse($response);
		} 

		else
		{
			$artist_id = $artistId;
			$SQLs = "UPDATE `".DATABASE."`.`transaction` SET status=2 WHERE gig_id='$link' AND artist_id='$artist_id'";
			$results = mysql_query($SQLs);

			$SQLs = "SELECT * FROM `".DATABASE."`.`transaction` WHERE gig_id='$link' AND artist_id='$artist_id'";
			$results = mysql_query($SQLs);

			if (mysql_num_rows($results) == 1) 
			{
				$found = mysql_fetch_array($results);
				$artist_name=$found["artist_name"];
			
				$gig=$found["gig_name"];
				$promoter_name=$found["promoter_name"];
			
				$q2 = "SELECT * FROM `".DATABASE."`.`members` WHERE link='$artist_id'";
				$result_set2 = mysql_query($q2);	
				if (mysql_num_rows($result_set2) == 1) 
				{
					$found = mysql_fetch_array($result_set2);
					$artist_email=$found["email"];
				}
			
				$to = $artist_email;
				$subject = "Dib Rejected for $gig";
				$mess="<p style='text-align:left;'>
				Dear $artist_name,<br><br>
				Sorry, your dib for the gig: '$gig' has been rejected by the host.
				<br>
				However, there are a lot more gigs to be booked on TommyJams and you'll surely find the right ones for you. Please login to your profile on TommyJams and search for the latest gigs in the 'Find Gigs' section.
				<br>
				We wish you all the very best in the future.
				<br><br>
				Happy Jamming,
				<br>
				Team TommyJams
				<br><br>
				</p>
				<center>
				<table border='1'>
					<tr>
						<td>Gig</td>
						<td>$gig</td>
					</tr>
					<tr>
						<td>Promoter</td>
						<td>$promoter_name</td>
					</tr>
				</table>
				</center>
				";
				$sender = "alerts@tommyjams.com";
				
				$this->load->helper('mail');
	        	send_email($to, $sender, $subject, $mess);
				
				$to = "alerts@tommyjams.com";
				send_email($to, $sender, $subject, $mess);
			}

			$response['linker'] = $link;
			$response['error'] = 0;
			$response['accept'] = 0;
			$this->load->helper('functions');
			createResponse($response);
		}

	}

	public function recommendArtist(){

		$link = $_POST["link"]; 

		$SQLs = "SELECT * FROM `".DATABASE."`.`shop` WHERE link='$link'";
		$results = mysql_query($SQLs);
		$a = mysql_fetch_array($results);
		{
			$gig=$a["gig"];
			$date=$a["venue_date"];
			$promoter_name=$a["promoter_name"];
		}

		$to = "contact@tommyjams.com";
		$subject = "Artist recommendation wanted for $gig";
		$mess="<p style='text-align:left;'>
		Dear Admin,<br><br>
		You have received a recommendation request for $gig.
		<br>
		</p>
		<center>
		<table border='1'>
			<tr>
				<td>Gig</td>
				<td>$gig</td>
			</tr>
			<tr>
				<td>Gig ID</td>
				<td>$link</td>
			</tr>
			<tr>
				<td>Date</td>
				<td>$date</td>
			</tr>
			<tr>
				<td>Promoter</td>
				<td>$promoter_name</td>
			</tr>
		</table>
		</center>
		";
		$sender = "alerts@tommyjams.com";
			
		$this->load->helper('mail');
        send_email($to, $sender, $subject, $mess);
			
		$to = "alerts@tommyjams.com";
		send_email($to, $sender, $subject, $mess);
		
		$alertMessage = "We shall contact you within 24 hours with a recommendation from among the artists who have applied. Thank you for your patience.";
		
		$response = $alertMessage;

		$this->load->helper('functions');
		createResponse($response);
	}

	public function showDibs(){

		ob_start();
		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id()'])) {
			session_start();
		}

		if(!isset($sessionArray['username']))
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
			exit;
		}	

		$username=$sessionArray['username'];
		$password=md5($sessionArray['password']);

		//$link=$_POST["link"]/15999;
		$linker=$_POST["link"];
		$dibs_exist = 0;

		$SQL = "SELECT * FROM `".DATABASE."`.`transaction` WHERE gig_id=$linker AND status=4";
		$result = mysql_query($SQL);
		while ($b = mysql_fetch_assoc($result))
		{
			$dibs_exist = 1;
			$artist_id=$b["artist_id"];$artist_name=$b["artist_name"];

			$dibLists = array($artist_name, $artist_id);
			$response['dibLists'][] = $dibLists;	
		}

		$response['dibs_exist'] = $dibs_exist;

		$response['linker'] = $linker;

		$this->load->helper('functions');
		createResponse($response);
	}

	public function editProfilePage(){

		$sessionArray = $this->session->all_userdata();

		if(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);

			$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
			$results = mysql_query($SQLs);

			while ($a = mysql_fetch_assoc($results))
			{
				$id=$a["id"];$idaa=$id;$usernam=$a["username"];$name=$a["name"];$_SESSION['name']=$name;$email=$a["email"];
				$street=$a["add"];$city=$a["city"];$state=$a["state"];$country=$a["country"];$pincode=$a["pincode"];
				$mobile=$a["mobile"];
				$fb=$a["fb"];$twitter=$a["twitter"];$youtube=$a["youtube"];$myspace=$a["myspace"];$rever=$a["reverbnation"];
				$gplus=$a["gplus"];$display=$a["display"];$user=$a["user"];$type=$a["type"];$genre=$a["genre"];
				$job=$a["job"];$designation=$a["designation"];
				$artistrate=$a["artistrate"];$adminrate=$a["adminrate"];$about=$a["about"];
				$gold=$a["gold"];$silver=$a["silver"];$nsilver=$a["nsilver"];$bronze=$a["bronze"];$link=$a["link"];

				$response=$a;
			}
		}
		else if(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);

			$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
			$results = mysql_query($SQLs);
			while ($a = mysql_fetch_assoc($results))
			{
				$id=$a["id"];$idaa=$id;$usernam=$a["username"];$name=$a["name"];$_SESSION['name']=$name;$email=$a["email"];
				$street=$a["add"];$city=$a["city"];$state=$a["state"];$country=$a["country"];$pincode=$a["pincode"];
				$mobile=$a["mobile"];
				$fb=$a["fb"];$twitter=$a["twitter"];$youtube=$a["youtube"];$myspace=$a["myspace"];$rever=$a["reverbnation"];$gplus=$a["gplus"];
				$display=$a["display"];$user=$a["user"];$type=$a["type"];$genre=$a["genre"];
				$job=$a["job"];$designation=$a["designation"];
				$artistrate=$a["artistrate"];$adminrate=$a["adminrate"];$about=$a["about"];
				$gold=$a["gold"];$silver=$a["silver"];$nsilver=$a["nsilver"];$bronze=$a["bronze"];$link=$a["link"];

				$response=$a;
			}
		}
		else
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
		}

		if($about=="")
			$about="Add details for this section by editing your profile";

		$response['about'] = $about;

		$this->load->helper('functions');
		createResponse($response);
	}

	public function editProfile(){

		$sessionArray = $this->session->all_userdata();

		if(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);
			$actual_type = 'artist';
		}
		else if(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);
			$actual_type = 'venue';
		}
		else
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
		}

		$this->load->helper('functions');

		if(isset($_POST['type']))
			$type = $_POST['type'];

		if($type == "contactForm")
		{
			$add=$_POST["add"];
			$city=$_POST["city"];
			$state=$_POST["state"];
			$country=$_POST["country"];
			$pincode=$_POST["pincode"];
			$mobile=$_POST["phone"];
			$email=$_POST["email"];

			$query = "UPDATE `".DATABASE."`.`members` SET `mobile`='$mobile', `email`='$email', `add`='$add', `city`='$city', `state`='$state', `country`='$country', `pincode`='$pincode' WHERE fb_id='$username'";
			$ress = mysql_query($query);
			if (!$ress)
			{
				$response['error']=1;
				createResponse($response);
			}

				/************* This code is for MailChimp Integration ****************/
        		$config = array(
	    				'apikey' => '4b1d3dfd9a40c3a47861fa481d644505-us5' );

				$this->load->library('mailchimp/MCAPI', $config, 'mail_chimp');

        		// API Key: http://admin.mailchimp.com/account/api/
        		// $api = new MCAPI('4b1d3dfd9a40c3a47861fa481d644505-us5');

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

				if($this->mail_chimp->listSubscribe($list_id, $email, $merge_vars, $email_type, $double_optin, $update_existing, $replace_interests, $send_welcome) === false) 
				{
					//'Error: ' . $mcapi->errorMessage;
					// We don't want to stop registration just because mailchimp did not work.
					// Let's just send an email to alerts@tommyjams.com to notify admin.
					$errorMsg = $this->mail_chimp->errorMessage;

					$to = "alerts@tommyjams.com";
					$sender = "alerts@tommyjams.com";
					$subject = "Mailchimp TJ Profile failure: $email, Error: $errorMsg";
					$message = "$email could not be added/updated in the current mailchimp list on edit profile. Please try manually. Error being faced: $errorMsg";

					$this->load->helper('mail');
    				send_email($to, $sender, $subject, $mess);

					//'Error: ' . $api->errorMessage;
            		$response['error']=1;
            		createResponse($response);
				}
		}
	  
		elseif($type == "professionalForm")
		{
			$designation=$_POST["designation"];
			$organizationName=$_POST["organization"];
			$genre=$_POST["genre"];
			 
			$query = "UPDATE `".DATABASE."`.`members` SET `designation`='$designation', `name`='$organizationName', `genre`='$genre' WHERE fb_id='$username'";
			$ress = mysql_query($query);
			if (!$ress)
			{
				$response['error']=1;
				createResponse($response);
			}
		}

		elseif($type == "socialForm")
		{
			$fb=$_POST["fb"];	if($fb && !startsWith($fb,'http'))	{		$fb='http://'.$fb;	}
			$twitter=$_POST["twitter"];	if($twitter && !startsWith($twitter,'http'))	{		$twitter='http://'.$twitter;	}
			$myspace=$_POST["myspace"];	if($myspace && !startsWith($myspace,'http'))	{		$myspace='http://'.$myspace;	}
			$rever=$_POST["rever"];	if($rever && !startsWith($rever,'http'))	{		$rever='http://'.$rever;	}
			$youtube=$_POST["youtube"];	if($youtube && !startsWith($youtube,'http'))	{		$youtube='http://'.$youtube;	}

			$query = "UPDATE `".DATABASE."`.`members` SET `fb`='$fb', `twitter`='$twitter', `reverbnation`='$rever', `youtube`='$youtube', `myspace`='$myspace' WHERE fb_id='$username'";
			$ress = mysql_query($query);
			if (!$ress)
			{
				$response['error']=1;
				createResponse($response);
			}
		}
	 
		elseif($type == "aboutForm")
		{
			$about=$_POST["about"];
			$about=str_replace("'", " ", $about);
			
			$query = "UPDATE `".DATABASE."`.`members` SET `about`='{$about}' WHERE fb_id='$username'";
			$ress = mysql_query($query);
			if (!$ress)
			{
				$response['error']=1;
				createResponse($response);
			}
		}

		else
		{
			$response['error']=1;
			createResponse($response);
		}

		$response['error']=0;
		createResponse($response);
	}

	public function feedback(){

		$sessionArray = $this->session->all_userdata();
		
		if (!isset($sessionArray['session_id'])) {
		session_start();
		}

		if(!isset($sessionArray['username']))
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
			exit;
		}

		$username=$sessionArray['username'];
		$password=md5($sessionArray['password']);

		$data['gig_id'] = $this->uri->segment(3);

		error_log("Gig Id: ".$data['gig_id']);

		$this->load->view('promoter_view', $data);
	}

	public function showGigFeedback()
	{
		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
			session_start();
		}

		if(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);

			$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
			$results = mysql_query($SQLs);
			while ($a = mysql_fetch_assoc($results))
			{
				$loggedInID=$a["link"];
			}

			$gigLink = $_POST['gigLink'];
			$q2 = "SELECT * FROM `".DATABASE."`.`rating` WHERE gig_id=$gigLink";
			$result_set2 = mysql_query($q2);
			if (mysql_num_rows($result_set2) == 1)
			{
				$found = mysql_fetch_array($result_set2);
				$status=$found["status"];
				$prate=$found["promoter_rate"];
				$arate=$found["artist_rate"];
				$edate=$found["event_date"];
				$date=date("Y-m-d");
				$today = strtotime($date);
				$event_date = strtotime($edate);
				if($event_date > $today)
				{
					$response['error'] = 1;
					$response['reason'] = 'premature';
					$response['eventDate'] = $edate;

					$this->load->helper('functions');
					createResponse($response);
				}

				if($prate!=0)	//Change for promoter
				{
					$response['error'] = 1;
					$response['reason'] = 'already';
					$response['eventDate'] = $edate;

					$this->load->helper('functions');
					createResponse($response);	
				}

				$artist_id=$found["artist_id"];$artist_name=$found["artist_name"];
				$promoter_id=$found["promoter_id"];$promoter_name=$found["promoter_name"];
				$gig_id=$found["gig_id"];$gig_name=$found["gig_name"];
				$p_rate=$found["promoter_rate"];$p_comment=$found["promoter_comment"];$p_gig_rate=$found["promoter_gig_rate"];$p_gig_comment=$found["promoter_gig_comment"];$p_future=$found["promoter_future"];
				$a_rate=$found["artist_rate"];$a_comment=$found["artist_comment"];$a_dib_rate=$found["artist_dib_rate"];$a_dib_comment=$found["artist_dib_comment"];$a_future=$found["artist_future"];
			}
			else 
			{
				$response['error'] = 1;
				$response['reason'] = 'gignotfound';

				$this->load->helper('functions');
				createResponse($response);
			}

			if($loggedInID != $promoter_id)	//Change for promoter
			{
				$response['error'] = 1;
				$response['reason'] = 'ineligible';
				$response['gig_name'] = $gig_name;
				$response['eventDate'] = $edate;

				$this->load->helper('functions');
				createResponse($response);
			}					
		}
		else
		{
			$response['error'] = 1;
			$response['reason'] = 'nologin';

			$this->load->helper('functions');
			createResponse($response);
		}

		$response['error'] = 0;
		$response['reason'] = 'fine';
		$response['gig_id'] = $gig_id;
		$response['gig_name'] = $gig_name;
		$response['role'] = 'p';
		$response['eventDate'] = $edate;
		$response['promoter_name'] = $promoter_name;
		$response['artist_name'] = $artist_name;


		$this->load->helper('functions');
		createResponse($response);		
	}

	public function enterGigFeedback()
	{
		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id']))
		{
			session_start();
		}

		if(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);

			$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
			$results = mysql_query($SQLs);
			while ($a = mysql_fetch_assoc($results))
			{
				$loggedInID=$a["link"];
			}

			if(isset($_POST["gig"]) && isset($_POST["prate"]))	//Change for promoter
			{
				$gigLink = $_POST['gigLink'];
				$prate=$_POST['prate'];							//Change for promoter
				$pcomment=$_POST['pcomment'];					//Change for promoter
				$gig=$_POST['gig'];
				$gigc=$_POST['gigc'];
				$future=$_POST['future'];

				$q2 = "UPDATE `".DATABASE."`.`rating` SET `status` = '1', `promoter_rate` = '$prate',`promoter_comment` = '$pcomment', `promoter_gig_rate` = '$gig', `promoter_gig_comment` = '$gigc', `promoter_future` = '$future' WHERE `gig_id` = '$gigLink' AND `promoter_id` = '$loggedInID' "; //Change for promoter
				$result_set2 = mysql_query($q2);
				if (!$result_set2)
				{
					$response['error'] = 1;
					$response['reason'] = 'queryfailed';

					$this->load->helper('functions');
					createResponse($response);
				}

				$q3 = "SELECT * FROM `".DATABASE."`.`rating` WHERE `gig_id` = '$gigLink' AND `promoter_id` = '$loggedInID' "; //Change for promoter
				$result_set3 = mysql_query($q3);
				if (!$result_set3)
				{
					$response['error'] = 1;
					$response['reason'] = 'queryfailed';

					$this->load->helper('functions');
					createResponse($response);
				}

				while ($a = mysql_fetch_assoc($result_set3))
				{
					$gigName=$a['gig_name'];
					$promoter_id = $a['promoter_id'];
				}

				$to = "alerts@tommyjams.com";
				$sender = "alerts@tommyjams.com";
				$subject = "Gig has been rated by Promoter";
				$mess="Gig: $gigName<br>Rating: $gig<br>Comment: $gigc";

				$this->load->helper('mail');
    			send_email($to, $sender, $subject, $mess);

				$q1 = "SELECT * FROM `".DATABASE."`.`members` WHERE link=$promoter_id";
				$result_set1 = mysql_query($q1);
				if (mysql_num_rows($result_set1) == 1)
				{
					$a = mysql_fetch_array($result_set1);
					$silver = $a["silver"];
					$nsilver = $a["nsilver"];
					$nsilver++;
					$avgsilver = ((($nsilver-1) * $silver) + $prate)/($nsilver);
					
					$q3 = "UPDATE `".DATABASE."`.`members` SET `silver` = '$avgsilver',`nsilver` = '$nsilver' WHERE link=$promoter_id";
					$result_set3 = mysql_query($q3);
					if (!$result_set3)
					{
						$response['error'] = 1;
						$response['reason'] = 'queryfailed';

						$this->load->helper('functions');
						createResponse($response);
					}
				}
			}
			else
			{
				$response['error'] = 1;
				$response['reason'] = 'norating';

				$this->load->helper('functions');
				createResponse($response);
			}
		}
		else
		{
			$response['error'] = 1;
			$response['reason'] = 'nologin';

			$this->load->helper('functions');
			createResponse($response);
		}

		$response['error'] = 0;
		$response['reason'] = 'rated';

		$this->load->helper('functions');
		createResponse($response);
	}
}
?>	
