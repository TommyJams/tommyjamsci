<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Artist extends CI_Controller{

	public function artistpage(){
		ob_start();

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
		session_start();
		}

		if(!isset($sessionArray['username_artist']))
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
			exit;
		}
		
		$username=$sessionArray['username_artist'];
		$password=md5($sessionArray['password_artist']);

		$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
		$results = mysql_query($SQLs);
		$type = "";
		$user = "";
		while ($a = mysql_fetch_assoc($results))
		{
			$id=$a["id"];$idaa=$id;$name=$a["name"];
			//$_SESSION['name']=$name;
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
		$this->load->view('artist_view');
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
		/*else if(isset($sessionArray['username'])  && !isset($_POST["id"]))
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
		}*/
		else
		{
			$link = $_POST['id'];
			error_log("Post ID: ".$link);

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

		//$this->load->view('profile_subview');
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

		$username = $sessionArray['username_artist']; 

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
		$response['gigSession'] = $gigSession;
		$response['promoter'] = $promoter;
	                        
		$this->load->helper('functions');
		createResponse($response);
	}

	public function mydibs(){
		ob_start();

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
			session_start();
		}
		if(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);
		}
		else
		{
			$this->sessionlogout();
			exit;
		}

		$q2 = "SELECT link FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
		$result_set2 = mysql_query($q2);	
		if (mysql_num_rows($result_set2) == 1) 
		{
	 		$found = mysql_fetch_array($result_set2);
			$artist_id=$found["link"];
		}

		if(isset($sessionArray['username_artist']))
	    {
	    	$SQLs = "SELECT * FROM `".DATABASE."`.`transaction` WHERE artist_id=$artist_id ORDER BY id DESC";
	    }
	 	elseif(isset($sessionArray['username']))
	    {
	        $SQLs = "SELECT * FROM `".DATABASE."`.`transaction` WHERE promoter_id=$artist_id ORDER BY id DESC";
	    }
	    
	    $results = mysql_query($SQLs);
	    
	    if(!$results)
	    {
	    	$gig=""; 
	    	$city=""; 
	    	$formattedDate=""; 
	    	$time=""; 
	    	$statuss=""; 
	    	$promoter=""; 
	    	$promoter_name=""; 
	    	$contact="";;

	    	$dibRow = array($gig, $city, $formattedDate, $time, $statuss, $promoter, $promoter_name, $contact);

			$response['dibHistory'][] = $dibRow;
	    }

	    else
	    {        
	    	while ($a = mysql_fetch_assoc($results))
	    	{
	        	$gig_id=$a["gig_id"];
	        	$id=$a["id"];$gig=$a["gig_name"];$promoter=$a["promoter_id"];$promoter_name=$a["promoter_name"];
	        	$artist=$a["artist_id"];$artist_name=$a["artist_name"];
	        	$link=$a["gig_id"];$statuss=$a["status"];

	        	$SQLe = "SELECT * FROM `".DATABASE."`.`shop` WHERE link=$link";
	        	$resulte = mysql_query($SQLe);
	        	while ($f = mysql_fetch_assoc($resulte))
	        	{
	            	$city=$f["venue_city"];$state=$f["venue_state"];$time=$f["venue_time"];$date=$f["venue_date"];
	        	}
				$formattedDate = date('d-m-Y',strtotime($date));

				$SQLe = "SELECT mobile FROM `".DATABASE."`.`members` WHERE link=$promoter";
            	$resulte = mysql_query($SQLe);
            	$b = mysql_fetch_assoc($resulte);
            	$contact = $b['mobile'];

				$dibRow = array($gig, $city, $formattedDate, $time, $statuss, $promoter, $promoter_name, $contact, $link);

				$response['dibHistory'][] = $dibRow;
			}	
		}

		$this->load->helper('functions');
		createResponse($response);
	}

	public function findGigs()
	{
		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
			session_start();
		}
		if(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);
		}
		else
		{
			$this->sessionlogout();
			exit;
		}

		$todayTime = strtotime(date("Y-m-d"));

		//What is the query string
		if(isset($_POST['searchString']))								//Search string passed in query?
			$searchGigs = $_POST['searchString'];
		else
		{
			$searchGigs = $this->session->userdata('findGigsString');	//Search string present in session?

			if($searchGigs === FALSE)
				$searchGigs = NULL;										//Empty search string
		}


		// Which page to show?
		if(isset($_POST['nPage']) && $_POST['nPage']!=NULL)				//Page passed in query?
			$nPage = $_POST['nPage'];
		else
		{
			$nPage = $this->session->userdata('findGigsPage');			//Page present in session?

			if($nPage === FALSE)										
				$nPage = 1;												//Fresh ask for find gigs
		}

		// City Filter?
		if(isset($_POST['sCity']) && $_POST['sCity']!=NULL)				//City passed in query?
			$sCity = $_POST['sCity'];
		else
		{
			$sCity = $this->session->userdata('findGigsCity');			//City present in session?

			if($sCity === FALSE)										
				$sCity = "all";											//Reset City filter to all
		}

		// Date Filter?
		if(isset($_POST['sDate']) && $_POST['sDate']!=NULL)				//Date passed in query?
			$sDate = $_POST['sDate'];
		else
		{
			$sDate = $this->session->userdata('findGigsDate');			//Date present in session?

			if($sDate === FALSE)										
				$sDate = "all";											//Reset Date filter to all
		}

		// Category Filter?
		if(isset($_POST['sCat']) && $_POST['sCat']!=NULL)				//Category passed in query?
			$sCat = $_POST['sCat'];
		else
		{
			$sCat = $this->session->userdata('findGigsCat');			//Category present in session?

			if($sCat === FALSE)										
				$sCat = "all";											//Reset Category filter to all
		}

		// Budget Filter?
		if(isset($_POST['sBudget']) && $_POST['sBudget']!=NULL)			//Budget passed in query?
			$sBudget = $_POST['sBudget'];
		else
		{
			$sBudget = $this->session->userdata('findGigsBudget');		//Budget present in session?

			if($sBudget === FALSE)										
				$sBudget = "all";										//Reset Budget filter to all
		}

		$que = "SELECT DISTINCT venue_city FROM `".DATABASE."`.`shop` WHERE (`gig` LIKE '%$searchGigs%' OR `desc` LIKE '%$searchGigs%'  OR `venue_city` LIKE '%$searchGigs%'  OR `promoter_name` LIKE '%$searchGigs%') AND status!=2";
		$sea=mysql_query($que);
        while($a = mysql_fetch_assoc($sea))
		{
			$city=$a["venue_city"];
			$response['cityList'][] = $city;
		}


		$que = "SELECT DISTINCT venue_date FROM `".DATABASE."`.`shop` WHERE (`gig` LIKE '%$searchGigs%' OR `desc` LIKE '%$searchGigs%'  OR `venue_city` LIKE '%$searchGigs%'  OR `promoter_name` LIKE '%$searchGigs%') AND status!=2";
		$sea=mysql_query($que);
        while($a = mysql_fetch_assoc($sea))
		{
			$date=$a["venue_date"];
			$response['dateList'][] = $date;
		}

		$que = "SELECT DISTINCT category FROM `".DATABASE."`.`shop` WHERE (`gig` LIKE '%$searchGigs%' OR `desc` LIKE '%$searchGigs%'  OR `venue_city` LIKE '%$searchGigs%'  OR `promoter_name` LIKE '%$searchGigs%') AND status!=2";
		$sea=mysql_query($que);
        while($a = mysql_fetch_assoc($sea))
		{
			$cat=$a["category"];
			$response['catList'][] = $cat;
		}

		$que = "SELECT DISTINCT budget_min FROM `".DATABASE."`.`shop` WHERE (`gig` LIKE '%$searchGigs%' OR `desc` LIKE '%$searchGigs%'  OR `venue_city` LIKE '%$searchGigs%'  OR `promoter_name` LIKE '%$searchGigs%') AND status!=2 ORDER BY budget_min DESC";
		$sea=mysql_query($que);
        while($a = mysql_fetch_assoc($sea))
		{	
			$min=$a["budget_min"];
			$response['budgetList'][] = $min;
		}

		$query = "SELECT COUNT(*) as num FROM `".DATABASE."`.`shop` WHERE (`gig` LIKE '%$searchGigs%' OR `desc` LIKE '%$searchGigs%'  OR `venue_city` LIKE '%$searchGigs%'  OR `promoter_name` LIKE '%$searchGigs%') AND status!=2";
		$que   = "SELECT               * FROM `".DATABASE."`.`shop` WHERE (`gig` LIKE '%$searchGigs%' OR `desc` LIKE '%$searchGigs%'  OR `venue_city` LIKE '%$searchGigs%'  OR `promoter_name` LIKE '%$searchGigs%') AND status!=2";
		if(isset($sCity)   && $sCity!="all")  {$query.=" AND `venue_city` = '$sCity'";  $que.=" AND `venue_city` = '$sCity'";}
		if(isset($sDate)   && $sDate!="all")  {$query.=" AND `venue_date` = '$sDate'";  $que.=" AND `venue_date` = '$sDate'";}
		if(isset($sCat)    && $sCat !="all")  {$query.=" AND `category` LIKE '%$sCat%'"; $que.=" AND `category` LIKE '%$sCat%'";}
		if(isset($sBudget) && $sBudget!="all"){$query.=" AND `budget_min` >= '$sBudget'"; $que.=" AND `budget_min` >= '$sBudget'";}
		$que.= " ORDER BY venue_date DESC";

		$total_pages = mysql_fetch_array(mysql_query($query));
        $total_pages = $total_pages['num']/6;
        $total_pages = ceil($total_pages);

        //Save gigs data in response
        $v=0;
		$sea=mysql_query($que);
        while($a = mysql_fetch_assoc($sea))
        {
            $v=$v+1;
            $id=$a["id"];$gig=$a["gig"];$cat=$a["category"];
            $city=$a["venue_city"];$state=$a["venue_state"];$country=$a["venue_country"];$pincode=$a["venue_pin"];
            $date=$a["venue_date"];$time=$a["venue_time"];$period=$a["period"];$link=$a["link"];
            $budget_min=$a["budget_min"];$budget_max=$a["budget_max"];$image=$a["image"];$status=$a["status"];
            $dated = strtotime($date);$promoter_name=$a["promoter_name"];$pid=$a["promoter"];
            $linker=$link*15999;
			$formattedDate = date('d-m-Y',$dated);

            if($v<=($nPage*6) && $v>($nPage*6)-6)
            {
                $gigStatus=0;										// Gig is open
                $q4 = "SELECT * FROM `".DATABASE."`.`transaction` WHERE gig_id=$link AND status=1";
                $result_set4 = mysql_query($q4);	
                if (mysql_num_rows($result_set4) == 1) 				//Gig is Booked
                {
                    $found = mysql_fetch_array($result_set4);
                    $gigStatus=1;
                }
                else
                {
	            	$q2 = "SELECT link FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
	                $result_set2 = mysql_query($q2);	
	                if (mysql_num_rows($result_set2) == 1) 
	                {
	                        $found = mysql_fetch_array($result_set2);
	                        $artist_id=$found["link"];
	                }

	                $q4 = "SELECT * FROM `".DATABASE."`.`transaction` WHERE gig_id=$link AND artist_id=$artist_id";
	                $result_set4 = mysql_query($q4);
	                if (mysql_num_rows($result_set4) == 1) 
	                {
	                    $found = mysql_fetch_array($result_set4);
	                    $statuss=$found["status"];
	                    
	                    if($statuss==2){$gigStatus = 2;}				//Dib Rejected
	                    elseif($statuss==4){$gigStatus = 4;}			//Dib Pending
	                }
	            	elseif($todayTime > $dated)
					{
						$gigStatus = -1;								//Gig expired
					}
				}

				$gigRow = array($gig, $link, $pid, $promoter_name, $city, $formattedDate, $time, $gigStatus);
				$response['foundGigs'][] = $gigRow;
            }
        }

		//Save data in session
		$sessionData = array(
	          'findGigsPage'  => $nPage,
	          'findGigsString'  => $searchGigs,
	          'findGigsCity'  => $sCity,
	          'findGigsDate'  => $sDate,
	          'findGigsCat'  => $sCat,
	          'findGigsBudget'  => $sBudget
        );
		$this->session->set_userdata($sessionData);

		//Save some page level data in response
		$response['nPage'] = $nPage;
		$response['searchGigs'] = $searchGigs;
		$response['sCity'] = $sCity;
		$response['sDate'] = $sDate;
		$response['sCat'] = $sCat;
		$response['sBudget'] = $sBudget;
		$response['total_pages'] = $total_pages;

		$this->load->helper('functions');
		createResponse($response);
	}

	public function searchProfiles()
	{
		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
			session_start();
		}
		else if(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);
			$actual_type = 'Artist';
		}
		else if(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);
			$actual_type = 'Venue';
		}

		//What is the query string
		if(isset($_POST['searchString']))								//Search string passed in query?
			$searchProfiles = $_POST['searchString'];
		else
		{
			$searchProfiles = $this->session->userdata('searchProfilesString');	//Search string present in session?
		}

		// Which page to show?
		if(isset($_POST['nPage']) && $_POST['nPage']!=NULL)				//Page passed in query?
			$nPage = $_POST['nPage'];
		else
		{
			$nPage = $this->session->userdata('searchProfilesPage');			//Page present in session?

			if($nPage === FALSE)										
				$nPage = 1;												//Fresh ask for find gigs
		}

		
		if($searchProfiles)
		
		{

			$query = "SELECT COUNT(*) as num FROM `".DATABASE."`.`members` WHERE (`name` LIKE '%$searchProfiles%' OR `username` LIKE '%$searchProfiles%' OR `about` LIKE '%$searchProfiles%'  OR `email` LIKE '%$searchProfiles%'  OR `mobile` LIKE '%$searchProfiles%')  AND status!=2";

			$total_pages = mysql_fetch_array(mysql_query($query));

			$total_pages = $total_pages['num']/7;

			$total_pages=ceil($total_pages);

			$v=0;

			$que = "SELECT * FROM `".DATABASE."`.`members` WHERE (`name` LIKE '%$searchProfiles%' OR `username` LIKE '%$searchProfiles%' OR `about` LIKE '%$searchProfiles%'  OR `email` LIKE '%$searchProfiles%'  OR `mobile` LIKE '%$searchProfiles%') AND status!=2";

			$sea=mysql_query($que);

			while($a = mysql_fetch_assoc($sea))

			{

				$v=$v+1;

				if($v<($nPage*7) && $v>($nPage*7)-7)

				{

					$id=$a["id"];$name=$a["name"];$city=$a["city"];$usernam=$a["username"];

					$state=$a["state"];$type=$a["type"];$fb=$a["fb"];$twitter=$a["twitter"];

					$youtube=$a["youtube"];$rever=$a["reverbnation"];$gplus=$a["gplus"];$myspace=$a["myspace"];$link=$a["link"];

					$user=$a["user"];

					if($type=="Promoter" && $user!=""){     $users="images/promoter/$user";$usersa="../images/promoter/$user";; }

					elseif($type=="Artist"  && $user!=""){     $users="images/artist/$user";$usersa="../images/artist/$user"; }

					else{$usersa="images/profile.jpg";}
										
					if(!file_exists($usersa)&& $user==""){$users="images/profile.jpg";}

					else if(!file_exists($usersa) && $user!=""){$users="https://graph.facebook.com/"."$user/picture?type=square";}

					$linker=$link*15999;

					if(isset($username) && $actual_type == 'Venue'){$goto="$link";}

					else if(isset($username) && $actual_type == 'Artist'){$goto="$link";}

					else{$goto=NULL;}

					$profileRow = array($users, $goto, $name, $usernam, $type, $city, $fb, $twitter, $rever, $youtube, $myspace, $gplus);

					$response['foundProfiles'][] = $profileRow;

				}

			}

		}
		
		else
		
		{
		
			$total_pages = 0;
		
		}

		//Save data in session
		$sessionData = array(
	          'searchProfilesPage'  => $nPage,
	          'searchProfilesString'  => $searchProfiles
        );
		$this->session->set_userdata($sessionData);

		//Save some page level data in response
		$response['nPage'] = $nPage;
		$response['searchProfiles'] = $searchProfiles;
		$response['total_pages'] = $total_pages;

		$this->load->helper('functions');
		createResponse($response);
	}

	public function dibAction(){
		ob_start();

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
			session_start();
		}
		if(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);
		}
		else
		{
			$this->sessionlogout();
			exit;
		}
		$this->load->helper('functions');

		$gigLink = $_POST['gigLink'];

		if(!isset($gigLink))
		{
			$response['status']=0;
			createResponse($response);
		}

		if($gigLink)
		{
			{ 
				$q1 = "SELECT * FROM `".DATABASE."`.`shop` WHERE link='$gigLink'";
				$result_set1 = mysql_query($q1);	

				{
				 		$found = mysql_fetch_array($result_set1);
						$promoter_id=$found["promoter"];
						$promoter_name=$found["promoter_name"];
						$gig=$found["gig"];
						$date=$found["venue_date"];
						$formattedDate=date('d-m-Y',strtotime($date));
						$add=$found["venue_add"];
						$city=$found["venue_city"];
						$state=$found["venue_state"];
						$country=$found["venue_country"];
				}

				$q2 = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
				$result_set2 = mysql_query($q2);
				if (mysql_num_rows($result_set2) == 1) 
				{
				 		$found = mysql_fetch_array($result_set2);
						$artist_id=$found["link"];
						$artist_name=$found["name"];
						$artist_email=$found["email"];
				}

				$q3 = "SELECT * FROM `".DATABASE."`.`members` WHERE link=$promoter_id";
				$result_set3 = mysql_query($q3);	
				if (mysql_num_rows($result_set3) == 1) 
				{
				 		$found = mysql_fetch_array($result_set3);
						$promoter_email=$found["email"];
				}
			}

			$q4 = "SELECT * FROM `".DATABASE."`.`transaction` WHERE gig_id=$gigLink AND artist_id=$artist_id";
			$result_set4 = mysql_query($q4);	
			if (mysql_num_rows($result_set4) == 1) 
			{
				$response['status']=0;
				createResponse($response);
			}

			$q2 = "INSERT INTO `".DATABASE."`.`transaction` (`id`, `status`, `artist_id`, `artist_name`, `promoter_id`, `promoter_name`, `gig_id`, `gig_name`, `time`) VALUES('', '4', '$artist_id', '$artist_name', '$promoter_id', '$promoter_name', '$gigLink', '$gig', 'CURRENT_TIMESTAMP')";
			$result_set2 = mysql_query($q2);
			if (!$result_set2)
			{
				die("Database query failed: " . mysql_error());
				$response['status']=0;
				createResponse($response);
			}

			$to = $artist_email;
			$sender = "alerts@tommyjams.com";
			$subject = "Registered Dib for $gig";
			$mess="
			<p style='text-align:left;'>
			Dear $artist_name,<br><br>
			Thank you for registering your dib with TommyJams.<br>
			The dib has been sent to the promoter, and you can monitor the real-time status of your dib via your profile on TommyJams in the Dibs Status section.
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
					<td>Date of Gig</td>
					<td>$formattedDate</td>
				</tr>
			</table>
			</center>";
			$this->load->helper('mail');
    		send_email($to, $sender, $subject, $mess);
			
			$to = "alerts@tommyjams.com";
			send_email($to, $sender, $subject, $mess);

			$to = $promoter_email;
			$subject = "Dib Received for $gig";
			$mess="
			<p style='text-align:left;'>
			Dear $promoter_name,<br><br>
			You have just received a dib for your gig on TommyJams.<br>
			You can monitor the dib and take action via your profile on TommyJams in the My Gigs section.
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
					<td>$artist_name</td>
				</tr>
				<tr>
					<td>Date of Gig</td>
					<td>$formattedDate</td>
				</tr>
			</table>
			</center>";
			send_email($to, $sender, $subject, $mess);

			$to = "alerts@tommyjams.com";
			send_email($to, $sender, $subject, $mess);

			$this->load->helper('functions');
			$response['status']=1;
			error_log("Hello: ".$response['status']);
			createResponse($response);
		}

		$response['status']=1;
		error_log($response['status']);
		createResponse($response);
	}

	public function sessionlogout(){

		ob_start();
		$sessionArray = $this->session->all_userdata();
		
		if (!isset($sessionArray['session_id'])) {
			session_start();
		}

		$username=$sessionArray['username_artist'];
		$this->session->sess_destroy();
		redirect('http://testcodeigniter.azurewebsites.net/index');
		exit;
	}

	public function feedback(){

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
		session_start();
		}

		if(!isset($sessionArray['username_artist']))
		{
			redirect('http://testcodeigniter.azurewebsites.net/index');
			exit;
		}

		$username=$sessionArray['username_artist'];
		$password=md5($sessionArray['password_artist']);

		$data['gig_id'] = $this->uri->segment(3);

		$this->load->view('artist_view', $data);
	}

	public function showGigFeedback()
	{
		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
			session_start();
		}

		if(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);

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

				if($arate!=0)	//Change for promoter
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

			if($loggedInID != $artist_id)	//Change for promoter
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
		$response['role'] = 'a';
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

		if(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);

			$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
			$results = mysql_query($SQLs);
			while ($a = mysql_fetch_assoc($results))
			{
				$loggedInID=$a["link"];
			}

			if(isset($_POST["gig"]) && isset($_POST["arate"]))	//Change for promoter
			{
				$gigLink = $_POST['gigLink'];
				$arate=$_POST['arate'];							//Change for promoter
				$acomment=$_POST['acomment'];					//Change for promoter
				$gig=$_POST['gig'];
				$gigc=$_POST['gigc'];
				$future=$_POST['future'];

				$q2 = "UPDATE `".DATABASE."`.`rating` SET `status` = '1', `artist_rate` = '$arate',`artist_comment` = '$acomment', `artist_dib_rate` = '$gig', `artist_dib_comment` = '$gigc', `artist_future` = '$future' WHERE `gig_id` = '$gigLink' AND `artist_id` = '$loggedInID' "; //Change for promoter
				$result_set2 = mysql_query($q2);
				if (!$result_set2)
				{
					$response['error'] = 1;
					$response['reason'] = 'queryfailed';

					$this->load->helper('functions');
					createResponse($response);
				}

				$q3 = "SELECT * FROM `".DATABASE."`.`rating` WHERE `gig_id` = '$gigLink' AND `artist_id` = '$loggedInID' "; //Change for promoter
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
				$subject = "Gig has been rated by Artist";
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
					$avgsilver = ((($nsilver-1) * $silver) + $arate)/($nsilver);
					
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

