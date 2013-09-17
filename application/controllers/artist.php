<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Artist extends Base{

	public function checkSession(){

		$sessionArray = $this->session->all_userdata();

		if(!isset($sessionArray['session_id'])) {
			session_start();
		}
		elseif(isset($sessionArray['username_artist']))
		{
			$username=$sessionArray['username_artist'];
		}
		else
		{
			$this->sessionlogout();
			exit;
		}
		return($username);
	}

	public function mydibs(){
		
		$username = $this->checkSession();

		$q2 = "SELECT link FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
		$result_set2 = mysql_query($q2);	
		if (mysql_num_rows($result_set2) == 1) 
		{
	 		$found = mysql_fetch_array($result_set2);
			$artist_id=$found["link"];
		}

	    $SQLs = "SELECT * FROM `".DATABASE."`.`transaction` WHERE artist_id=$artist_id ORDER BY id DESC";
	 
	    $results = mysql_query($SQLs);
	    
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
			$error = 0;
		}	

		if(!isset($error))
		{
			$error = 1;
		}	

		$response['error'] = $error;
		$this->load->helper('functions');
		createResponse($response);
	}

	public function findGigs()
	{
		$username = $this->checkSession();

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

	public function dibAction(){

		$username = $this->checkSession();

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
    		$this->send_email($to, $sender, $subject, $mess);
			
			$to = "alerts@tommyjams.com";
			$this->send_email($to, $sender, $subject, $mess);

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
			$this->send_email($to, $sender, $subject, $mess);

			$to = "alerts@tommyjams.com";
			$this->send_email($to, $sender, $subject, $mess);

			$this->load->helper('functions');
			$response['status']=1;
			createResponse($response);
		}

		$response['status']=1;
		error_log($response['status']);
		createResponse($response);
	}

	public function sessionlogout(){

		$sessionArray = $this->session->all_userdata();
		
		if (!isset($sessionArray['session_id'])) {
			session_start();
		}

		$this->session->sess_destroy();
		redirect(base_url().'index');  // using '/index' doesn't work.
		exit;
	}
}
?>

