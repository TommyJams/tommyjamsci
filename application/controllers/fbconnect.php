<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fbconnect extends CI_Controller{

  function parse_signed_request($signed_request, $secret) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
          error_log('Unknown algorithm. Expected HMAC-SHA256');
          return null;
        }

        // check sig
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
          error_log('Bad Signed JSON signature!');
          return null;
        }

        return $data;
    }

    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    function verify_fields($f,$sf) {
        //$fields = json_encode($sf);
      //print_r ($fields);
      //print_r ($f);
        return (strcmp($fields,$f) === 0);
    }

    function check_registration($response, $fb_fields) {
          if ($response && isset($response["registration_metadata"]["fields"])) {
              $verified = $this->verify_fields($response["registration_metadata"]["fields"], $fb_fields);

              if (!$verified) { // fields don't match!
                   echo 'Registration metadata failed. Fields dont match.';
                   return false;
              } 
              else { // we verified the fields, insert the Data to the DB
                   echo 'Registration metadata passed!';
                   return true;
              }
          }
         echo 'Response not found.';
         return false;
    }

	public function registerMethod(){

		ob_start();
		// Path to PHP-SDK
		require 'src/facebook.php';
    $sessionArray = $this->session->all_userdata();
		/*define('FACEBOOK_APP_ID', '566516890030362');
		define('FACEBOOK_SECRET', '731fb276b0e0e1a8a77ecbdf72e2591b'); */

		//define('FACEBOOK_APP_ID', '204029036428158'); //pick from config
		//define('FACEBOOK_SECRET', '74203bd7fc3f0100d2c02ad74b28b308'); 

		$facebook = new Facebook(array(
  		/*'appId'  => '345757728821408',
  		'secret' => '42aeca9ddfaf5cb977f2d136a24dcbd1',*/
  		'appId'  => FACEBOOK_APP_ID,
  		'secret' => FACEBOOK_SECRET,
		));

		$fb_fields="[{'name':'name'},{'name':'email'},{'name':'location'},{'name':'birthday'},{'name':'usertype','description':'User Type','type':'select','options':{'artist':'Artist','venue':'Venue','promoter':'Promoter'},'default':'artist'},{'name':'org','description':'Band/Organisation Name','type':'text'},{'name':'phone','description':'Phone Number','type':'text'},]";
 
		// See if there is a user from a cookie
		$user = $facebook->getUser();

		if ($user) {
  			try {
    			// Proceed knowing you have a logged in user who's authenticated.
    			$user_profile = $facebook->api('/me');
  			} catch (FacebookApiException $e) {
    			error_log('FacebookApiException: '.$e);
    			$user = null;
  			}
		}
  		$params = array(
  		'scope' => 'read_stream, friends_likes, user_birthday, user_about_me, user_website, user_photos, user_location, user_hometown, user_interests, email',
		);
 
 		if ($user) {
  			$logoutUrl = $facebook->getLogoutUrl();
		} 
		else {
  			$loginUrl = $facebook->getLoginUrl($params);
		}
  			
  			$data1['fb_fields']="[{'name':'name'},{'name':'email'},{'name':'location'},{'name':'birthday'},{'name':'usertype','description':'User Type','type':'select','options':{'artist':'Artist','venue':'Venue','promoter':'Promoter'},'default':'artist'},{'name':'org','description':'Band/Organisation Name','type':'text'},{'name':'phone','description':'Phone Number','type':'text'},]";
  			$data1['appId']= FACEBOOK_APP_ID;
        $data2['iframe']=$this->load->view('registration1_view', $data1, TRUE);

        $registrationParam = $this->uri->segment(3);

        //error_log('noregister:'.$registrationParam);
        
  			if($registrationParam=='noregister'){
          $data2['val']=1;
			 	  $this->load->view('fbConnect1_view', $data2);
        }
        elseif ($registrationParam=='fbregistered') //User registered just now
        {
            error_log('fbregistered');
            //enter into database
            if ($_REQUEST) 
            {
              //echo '<p>signed_request contents:</p>';
              $response = $this->parse_signed_request($_REQUEST['signed_request'], FACEBOOK_SECRET);
              //echo '<pre>';
              //print_r ($response);
              //echo '</pre>';
             // error_log('fbregistered:'.$response);
              //$verification = check_registration($response,$fb_fields);
              error_log('fbregistered:'.$response);
              //error_log('fbregistered:'.$verification);
              if($response)
              { 
                $fbid=$response["user_id"];

                //  $this->load->database('databaseCheck');
               // include("connect.php");
                $query_check1 = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id = '$fbid'";
                $result_check1 = mysql_query($query_check1);  

                //if user is logged in on facebook but has never registered on tommyjams
                if(mysql_num_rows($result_check1) != 0)
                {
                  $data['val']=2;
                  $data['mess']=$this->load->view('registration2_view', NULL, TRUE);
                  $this->load->view('fbConnect1_view', $data);

                  /*print ("
                    <br><br>
                    You are already registered with us. Try logging in again. In case of any issues, please contact us.
                    <br><br><br>
                    <center><a href='index.php' style='width:120px; height:20px; background:#ffcc00;'>Continue</a></center>
                  ");*/
                }
                else
                {
                  $email=$response["registration"]["email"];
                  $password=rand(111111,9999999);
                  //$password=$response["registration"]["password"];
                  $password=md5($password);
                  $username=mysql_real_escape_string($response["registration"]["name"]);
                  //error_log('username:'.$username);
                  $city_country=$response["registration"]["location"]["name"];
                  $split=explode(",", $city_country ); //Eg. Split "Bangalore, India" into "Bangalore" and "India"
                  if (isset($split[2])) //Eg. "Bankok, Krung Thep, Thailand"
                  {
                    $city=addslashes($split[0]);
                    $state=trim($split[1]);
                    $state=addslashes($state);
                    $country=trim($split[2]);
                    $country=addslashes($country);
                  }
                  else //Eg. "Bangalore, India"
                  {
                    $city=addslashes($split[0]);
                    $state="";
                    $country=trim($split[1]);
                    $country=addslashes($country);
                  }
                  $you=$fbid;
                  $birth=$response["registration"]["birthday"];
                  $fb=addslashes('http://www.facebook.com/').$fbid;
                  $phone=$response["registration"]["phone"];
                  $organization=mysql_real_escape_string($response["registration"]["org"]);
                  //error_log('organization:'.$organization);
                  $actual_type=$response["registration"]["usertype"];
                  if($actual_type=='promoter'){$what="Promoter";}
                  elseif($actual_type=='venue'){$what="Promoter";}
                  elseif($actual_type=='artist'){$what="Artist";}
                  else{$what="Artist";}

                  //print_r($user_profile);
                  $this->load->helper('fieldsCheck');
                  $gender=get_key($user_profile, "gender");
                  
                  $this->load->helper('fieldsCheck');
                  $fb_username=get_key($user_profile, "username");

                  $this->load->helper('fieldsCheck');
                  $about=get_key($user_profile, "bio");

                  $about=addslashes($about);

                  /*
                  $emp=$user_profile["work"]["0"]["employer"]["name"];
                  $emp=addslashes($emp);
                  $emp_position=$user_profile["work"]["0"]["position"]["name"];
                  $emp_position=addslashes($emp_position);
                  $student="Student";
                  $student=$user_profile["education"]["0"]["school"]["name"];
                  $student=addslashes($student);
                  if($emp!=""){$job="Work as"; $organization=$emp;}else{$job="Studying"; $organization=$student;}
                  */
                  
                  //include("connect.php");
                  /*
                  $SQLs = "SELECT id FROM `".DATABASE."`.`members`";
                  $results = mysql_query($SQLs);
                  while ($a = mysql_fetch_assoc($results))
                  {
                    $id=$a["id"];
                  }
                  $id=$id+1;
                  $ida=$id*15993;
                  $link="$ida";
                  */

                  $ip=$_SERVER['REMOTE_ADDR'];
                  
               /*   $query = "INSERT INTO `".DATABASE."`.`members` (`id`, `type`, `actual_type`, `dob`, `name`, `username`, `fb_username`,`password`, `email`, `mobile`, `fb_id`, `city`, `state`,`country`, `about`, `gender`, `fb`, `status`, `job`, `user`, `ip`, `time`)
                                     VALUES (NULL, '$what', '$actual_type', '$birth', '$organization', '$username', '$fb_username', '$password', '$email', '$phone', '$fbid', '$city', '$state', '$country', '$about', '$gender', '$fb', '1', '$job', '$fbid', '$ip', CURRENT_TIMESTAMP)";
*/
                  $query = "INSERT INTO `".DATABASE."`.`members` (`id`, `type`, `actual_type`, `dob`, `name`, `username`, `fb_username`,`password`, `email`, `mobile`, `fb_id`, `city`, `state`,`country`, `about`, `gender`, `fb`, `status`, `user`, `ip`, `time`)
                                     VALUES (NULL, '$what', '$actual_type', '$birth', '$organization', '$username', '$fb_username', '$password', '$email', '$phone', '$fbid', '$city', '$state', '$country', '$about', '$gender','$fb', '1', '$fbid', '$ip', CURRENT_TIMESTAMP)";

                  $ress = mysql_query($query);
                  if (!$ress)
                  {
                    echo 'Database query failed:'. mysql_error();
                  }
                  else
                  {
                    $data1['organization']=$organization;
                    $data1['username']=$username;
                    $data1['email']=$email;
                    $data1['city']=$city;

                    $data['val']=3;
                    $data['mess']=$this->load->view('registration3_view', $data1, TRUE);
                    $this->load->view('fbConnect1_view', $data);

                    /*print ("
                    <br><br>
                    You are successfully registered
                    <br><br><br>
                    <table border=0>
                      <tr><td width=150>Band/Organisation</td><td>$organization</td></tr>
                      <tr><td width=150>User Name</td><td>$username</td></tr>
                      <tr><td>Email</td><td>$email</td></tr>
                      <tr><td>City</td><td>$city</td></tr>
                    </table>
                    <br><br><br>
                    <center><a href='fbconnect.php?registered=yes' style='width:120px; height:20px; background:#ffcc00;'>Continue</a></center>
                    ");*/

                    /************* This code is for MailChimp Integration ****************/
                    //require_once('../plugin/newsletter-form/MCAPI.class.php');

                    // API Key: http://admin.mailchimp.com/account/api/
                    //$mcapi = new MCAPI('4b1d3dfd9a40c3a47861fa481d644505-us5');
                    $config = array(
                              'apikey' => '4b1d3dfd9a40c3a47861fa481d644505-us5' );

                    $this->load->library('mailchimp/MCAPI', $config, 'mail_chimp');

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
                    $merge_vars = array('NAME'=>$organization,
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
                      //$errorMsg = $mcapi->errorMessage;

                      $to = "alerts@tommyjams.com";
                      $sender = "alerts@tommyjams.com";
                      $subject = "Mailchimp FBConnect failure: $email, Error: $errorMsg";
                      $message = "$email could not be added/updated in the current mailchimp list on fb registration. Please try manually. Error being faced: $errorMsg";
                      //include("include/mail.php");
                      $this->load->helper('mail');
                      send_email($to, $sender, $subject, $message);
                    }
                                    
                    $to = "alerts@tommyjams.com";
                    $sender = "alerts@tommyjams.com";
                    $subject = "$email joined fbconnect";
                    $message = "$email joined fbconnect";
                    //include("include/mail.php"); 
                    $this->load->helper('mail');
                    send_email($to, $sender, $subject, $message);
                  } 
                  
                  $q_link = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id = '$fbid'";
                  $result_set_link = mysql_query($q_link);
                  
                  if (!$result_set_link)
                    die("Database query failed: " . mysql_error());

                  if (mysql_num_rows($result_set_link) == 1)
                  {
                    $found_user = mysql_fetch_array($result_set_link);
                    $id=$found_user["id"];
                    $ida=$id*15993;
                    $link="$ida";
                    $query_insert = "UPDATE `".DATABASE."`.`members` SET link='$link' WHERE id='$id'";
                    $res_insert = mysql_query($query_insert);
                    if (!$res_insert)
                      echo 'Database query failed:'. mysql_error();
                  }
                } 
              }
              else
              {
                echo 'Something went wrong during the Facebook Registration. Please re-register.';
              }
            }
            else
            {
              echo 'Something went wrong during the Facebook Registration. Please re-register.';
            }
          }   

          elseif ($registrationParam=='preregistered') //Existing user
          {
            /*$data['val']=4;
            $data['mess']=$this->load->view('registration4_view', NULL, TRUE);
            $this->load->view('fbConnect1_view', $data);*/
            
            if($sessionArray['username'])
            {
              //header("Location: promoter.php?success=1");
              //header("Location: promoter");
              redirect('http://testcodeigniter.azurewebsites.net/promoter');
              exit;
            }
            elseif($sessionArray['username_artist'])
            {
              //header("Location: artist.php?success=1");
              //header("Location: artist");
              redirect('http://testcodeigniter.azurewebsites.net/artist');
              exit;
            }
            else
            {
              if ($user)
              {
                $fbid=$user_profile["id"];
                /*$email=$user_profile["email"];
                $username=$user_profile["username"];
                $password=rand(111111,9999999);
                $name=$user_profile["name"];
                $city=$user_profile["location"]["name"];
                $city=addslashes($city);
                $you=$user;
                $birth=$user_profile["birthday"];
                $fb=$user_profile["link"];
                $gender=$user_profile["gender"];
                $about=$user_profile["bio"];
                $about=addslashes($about);
                $emp=$user_profile["work"]["0"]["employer"]["name"];
                $emp=addslashes($emp);
                $emp_position=$user_profile["work"]["0"]["position"]["name"];
                $emp_position=addslashes($emp_position);
                $student="Student";
                $student=$user_profile["education"]["0"]["school"]["name"];
                $student=addslashes($student);
                if($emp!=""){$job="Work as"; $organization=$emp;}else{$job="Studying"; $organization=$student;}
                if($_GET["what"]==1){$what="Promoter";}else{$what="Artist";}*/
                // include("connect.php");
                
                $q1 = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id = '$fbid' AND status=1";
                $result_set1 = mysql_query($q1);  

                if (!$result_set1)
                  die("Database query failed: " . mysql_error());

                if (mysql_num_rows($result_set1) == 1)
                {
                  $found_admin = mysql_fetch_array($result_set1);
                  $type=$found_admin["type"];
                  
                  $q2 = "UPDATE `".DATABASE."`.`members` SET loginTime=now() WHERE fb_id = '$fbid'";
                  mysql_query($q2);
                  
                  if($type=="Promoter")
                  {
                    $newdata = array(
                                  'username'  => $fbid,
                                  'password'  => $found_admin["password"]
                                  );
                    $this->session->set_userdata($newdata);
                    //$_SESSION['username'] = $fbid;
                    //$_SESSION['password'] = $found_admin["password"];
                    {   
                      //header("Location: promoter.php?success=1");
                      //header("Location: promoter");
                      redirect('http://testcodeigniter.azurewebsites.net/promoter');

                      exit;
                    }
                  }

                  elseif($type=="Artist")
                  {
                    $newdata = array(
                                  'username_artist'  => $fbid,
                                  'password_artist'  => $found_admin["password"]
                                  );
                    $this->session->set_userdata($newdata);
                    //$_SESSION['username_artist'] = $fbid;
                    //$_SESSION['password_artist'] = $found_admin["password"];
                    {
                      //header("Location: artist.php?success=1");
                      //header("Location: artist");
                      //$back_to = 'http://testcodeigniter.azurewebsites.net/artist';
                      redirect('http://testcodeigniter.azurewebsites.net/artist');
                      exit;
                    }
                  }
                }
                else
                {
                  //header("Location: index");
                  redirect('http://testcodeigniter.azurewebsites.net/index');
                  exit;
                }
              }
              else
              {
                //header("Location: index");
                redirect('http://testcodeigniter.azurewebsites.net/index');
                exit;
              }
            } 
          }
          
          else
          {
            //default behaviour when landing on fbconnect.php $this->session->userdata('session_id');
            if($sessionArray['username'])
            {
              //header("Location: promoter.php?success=1");
              //header("Location: promoter");
              redirect('http://testcodeigniter.azurewebsites.net/promoter');
              exit;
            }
            elseif($sessionArray['username_artist'])
            {
              //header("Location: artist.php?success=1");
              //header("Location: artist");
              redirect('http://testcodeigniter.azurewebsites.net/promoter');
              exit;
            }
            else
            {
              //header("Location: index.php");
              //header("Location: index");
              redirect('http://testcodeigniter.azurewebsites.net/index');
              exit;
            }           
          }
 

            	
  	}
} 	
?>

