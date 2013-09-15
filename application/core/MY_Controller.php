<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
}

class Base extends MY_Controller{

	public function checkUserSession(){

		$sessionArray = $this->session->all_userdata();

		// SessionID Check
		if (!isset($sessionArray['session_id'])){
		session_start();
		}

		// Promoter Session 
		elseif(isset($sessionArray['username'])){
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);
		}

		// Artist Session 
		elseif(isset($sessionArray['username_artist'])){
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);
		}

		// Redirecting to index page, if none of the above cases is true.
		else{
			redirect('/index');
			exit;
		}

		$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
		$results = mysql_query($SQLs);
		
		// Initializing variables.
		// Codeigniter throws "undefined variable" error on un-intialized variables.
		$type = "";
		$user = "";
		$users = "";

		while ($a = mysql_fetch_assoc($results))
		{
			$id=$a["id"];$idaa=$id;$name=$a["name"];$sessionArray['name']=$name;
			$email=$a["email"];$street=$a["add"];$city=$a["city"];$state=$a["state"];
			$country=$a["country"];$pincode=$a["pincode"];$mobile=$a["mobile"];
			$fb=$a["fb"];$twitter=$a["twitter"];$youtube=$a["youtube"];$myspace=$a["myspace"];
			$rever=$a["reverbnation"];$gplus=$a["gplus"];$display=$a["display"];
			$user=$a["user"];$type=$a["type"];$job=$a["job"];$designation=$a["designation"];
			$artistrate=$a["artistrate"];$adminrate=$a["adminrate"];
		}

		// Logged in user's profile image 
		if($type=="Promoter"){ $users="images/promoter/$user"; }
 		elseif($type=="Artist"){ $users="images/artist/$user"; }
		if(!file_exists($users) && $user==""){$users="images/profile.jpg";}
		else if(!file_exists($users) && $user!=""){$users="https://graph.facebook.com/"."$user/picture&type=large";}

		// Loading user's profile view
		if($type=="Promoter"){ $this->load->view('promoter_view'); }
		elseif($type=="Artist"){ $this->load->view('artist_view'); }
	}

	public function profilepage(){

		$sessionArray = $this->session->all_userdata();

		// Initializing variables. 
		// Codeigniter throws "undefined variable" error on un-intialized variables.
		$type = "";
		$user = "";
		$nsilver = "";
		$userRating = "";
		$users = "";
		
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
			else
			{
				error_log('No user Exist');
				exit;
			}
		}

		if($nsilver>0)
			{$userRating=round(($gold/2+$silver/2),1);}
		else
			{$userRating=$gold;}

		if($about=="")
			{$about="Add details for this section by editing your profile";}

		// Logged in user's profile image
		if($type=="Promoter"){     $users="images/promoter/$user";$usersa="/images/promoter/$user";; }
	 	elseif($type=="Artist"){     $users="images/artist/$user";$usersa="/images/artist/$user"; }
		if(!file_exists($usersa) && $user==""){$users="images/profile.jpg";}
		else if(!file_exists($usersa) && $user!=""){$users="https://graph.facebook.com/"."$user/picture?type=large";}

		// Gig Portfolio Details 
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

		$response['userRating'] = $userRating;
		$response['about'] = $about;
		$response['users'] = $users;

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
			redirect('/index');
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
			redirect('/index');
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
        		$config = array('apikey' => '4b1d3dfd9a40c3a47861fa481d644505-us5' );
				$this->load->library('mailchimp/MCAPI', $config, 'mail_chimp');
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
			$status=$a["status"];$link=$a["link"];$image=$a["image"];
			$desc=$a["desc"];$budget_min=$a["budget_min"];
			$budget_max=$a["budget_min"]+$a["budget_min"]*$a["budget_max"]/100;$time=$a["time"];
		}

		if($image=="")
		{
			$image="gigs.jpg";
		}

		$gigs="images/gig/$image";
		$response['gigs'] = $gigs;

		$todayTime = strtotime(date("Y-m-d"));
		$dated = strtotime($date); 

		if(isset($sessionArray['username_artist']))
		{
			$username = $sessionArray['username_artist'];
		}
		elseif(isset($sessionArray['username']))
		{
			$username = $sessionArray['username'];
		} 

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

	public function feedback(){

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])){
		session_start();
		}

		// Promoter Session 
		elseif(isset($sessionArray['username'])){
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);
		}

		// Artist Session 
		elseif(isset($sessionArray['username_artist'])){
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);
		}

		// Redirecting to index page, if none of the above cases is true.
		else{
			redirect('/index');
			exit;
		}

		$data['gig_id'] = $this->uri->segment(3);

		error_log("Gig Id: ".$data['gig_id']);

		if(isset($sessionArray['username'])){ $this->load->view('promoter_view', $data); }
		elseif(isset($sessionArray['username_artist'])){ $this->load->view('artist_view', $data); }
	}

	public function showGigFeedback()
	{
		$sessionArray = $this->session->all_userdata();

		if(!isset($sessionArray['session_id'])){
			session_start();
		}

		if(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
			$password=md5($sessionArray['password']);
			$response['role'] = 'p';
		}
		elseif(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);
			$response['role'] = 'a';
		}
		elseif((!isset($sessionArray['username'])) && (!isset($sessionArray['username_artist'])))
		{
			$response['error'] = 1;
			$response['reason'] = 'nologin';

			$this->load->helper('functions');
			createResponse($response);
		}	

		if((isset($sessionArray['username'])) || (isset($sessionArray['username_artist'])))	
		{
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

				if(isset($sessionArray['username']))
				{
					if($prate!=0)	//Change for promoter
					{
						$response['error'] = 1;
						$response['reason'] = 'already';
						$response['eventDate'] = $edate;

						$this->load->helper('functions');
						createResponse($response);	
					}
				}
				elseif(isset($sessionArray['username_artist']))
				{
					if($arate!=0)	
					{
						$response['error'] = 1;
						$response['reason'] = 'already';
						$response['eventDate'] = $edate;

						$this->load->helper('functions');
						createResponse($response);	
				}	}

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

			if(($loggedInID != $promoter_id) || ($loggedInID != $artist_id))	
			{
				$response['error'] = 1;
				$response['reason'] = 'ineligible';
				$response['gig_name'] = $gig_name;
				$response['eventDate'] = $edate;

				$this->load->helper('functions');
				createResponse($response);
			}					
		}

		$response['error'] = 0;
		$response['reason'] = 'fine';
		$response['gig_id'] = $gig_id;
		$response['gig_name'] = $gig_name;
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
		}
		elseif(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
			$password=md5($sessionArray['password_artist']);
		}
		elseif((!isset($sessionArray['username'])) && (!isset($sessionArray['username_artist'])))
		{
			$response['error'] = 1;
			$response['reason'] = 'nologin';

			$this->load->helper('functions');
			createResponse($response);
		}	

		if((isset($sessionArray['username'])) || (isset($sessionArray['username_artist'])))
		{	
			$SQLs = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
			$results = mysql_query($SQLs);
			while ($a = mysql_fetch_assoc($results))
			{
				$loggedInID=$a["link"];
			}

			if(isset($_POST["gig"]))	//Change for promoter
			{
				if(isset($_POST["prate"]))
				{	
					$gigLink = $_POST['gigLink'];
					$prate=$_POST['prate'];							//Change for promoter
					$pcomment=$_POST['pcomment'];					//Change for promoter
					$gig=$_POST['gig'];
					$gigc=$_POST['gigc'];
					$future=$_POST['future'];

					$q2 = "UPDATE `".DATABASE."`.`rating` SET `status` = '1', `promoter_rate` = '$prate',`promoter_comment` = '$pcomment', `promoter_gig_rate` = '$gig', `promoter_gig_comment` = '$gigc', `promoter_future` = '$future' WHERE `gig_id` = '$gigLink' AND `promoter_id` = '$loggedInID' "; 
					$result_set2 = mysql_query($q2);
					if (!$result_set2)
					{
						$response['error'] = 1;
						$response['reason'] = 'queryfailed';

						$this->load->helper('functions');
						createResponse($response);
					}

					$q3 = "SELECT * FROM `".DATABASE."`.`rating` WHERE `gig_id`='$gigLink' AND `promoter_id`='$loggedInID' "; 
				}
				elseif(isset($_POST["arate"]))
				{

					$gigLink = $_POST['gigLink'];
					$arate=$_POST['arate'];							
					$acomment=$_POST['acomment'];					
					$gig=$_POST['gig'];
					$gigc=$_POST['gigc'];
					$future=$_POST['future'];

					$q2 = "UPDATE `".DATABASE."`.`rating` SET `status` = '1', `artist_rate` = '$arate',`artist_comment` = '$acomment', `artist_dib_rate` = '$gig', `artist_dib_comment` = '$gigc', `artist_future` = '$future' WHERE `gig_id` = '$gigLink' AND `artist_id` = '$loggedInID' "; 
					$result_set2 = mysql_query($q2);
					if (!$result_set2)
					{
						$response['error'] = 1;
						$response['reason'] = 'queryfailed';

						$this->load->helper('functions');
						createResponse($response);
					}

					$q3 = "SELECT * FROM `".DATABASE."`.`rating` WHERE `gig_id` = '$gigLink' AND `artist_id` = '$loggedInID' ";
				}	
				
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

				if(isset($sessionArray['username'])){
					$subject = "Gig has been rated by Promoter";
				}
				elseif (isset($sessionArray['username_artist'])){
					$subject = "Gig has been rated by Artist";
				}

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

					if(isset($sessionArray['username'])){
						$avgsilver = ((($nsilver-1) * $silver) + $prate)/($nsilver);
					}
					elseif (isset($sessionArray['username_artist'])){
						$avgsilver = ((($nsilver-1) * $silver) + $arate)/($nsilver);
					}
					
					$q3 = "UPDATE `".DATABASE."`.`members` SET `silver`='$avgsilver',`nsilver`='$nsilver' WHERE link=$promoter_id";
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

		$response['error'] = 0;
		$response['reason'] = 'rated';

		$this->load->helper('functions');
		createResponse($response);
	}

	public function sessionlogout(){

		$sessionArray = $this->session->all_userdata();
		
		if (!isset($sessionArray['session_id'])) {
			session_start();
		}

		$this->session->sess_destroy();
		//$index = echo base_url("index");
		redirect(base_url().'/index');
		exit;
	}
}
?>