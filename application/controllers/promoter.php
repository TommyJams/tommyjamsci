<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promoter extends Base{

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
}
?>	
