<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends Base{

	public function checkSession(){

		$sessionArray = $this->session->all_userdata();

		if(!isset($sessionArray['session_id'])) {
			session_start();
		}
		elseif(isset($sessionArray['username']))
		{
			$username=$sessionArray['username'];
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

	public function createResponseData($response)
    {
        return(json_encode($response));
    }

	public function aboutus(){
		$this->load->view('links/aboutus');
	}

	public function terms(){
		$this->load->view('links/terms');
	}

	public function careers(){
		$this->load->view('links/careers');
	}

	public function presskit(){

		//error_log("message");
		$this->load->helper('download');

		$username = $this->checkSession();

		$q2 = "SELECT * FROM `".DATABASE."`.`members` WHERE fb_id='$username'";
		$results = mysql_query($q2);
		while ($a = mysql_fetch_assoc($results))
	    {
	    	$response = $a;
	    }

	    $data = $this->createResponseData($response);
	    error_log("User Data: ".$data);

	    $name = 'profile.txt';

	/*	$data = file_get_contents("kit/press_kit.zip"); // Read the file's contents
		$name = 'press_kit.zip';*/

		//$data = 'Here is some text!';
		//$name = 'press_kit.txt';

		force_download($name, $data); 
	}

	public function press(){
		$this->load->view('links/press');
	}

	public function advertise(){
		$this->load->view('links/advertise');
	}

	public function help(){
		$this->load->view('links/help');
	}

	public function contactFunc(){

		$values=array
			(
				'contact-form-name'						=> $_POST['cf_name'],
				'contact-form-mail'						=> $_POST['cf_email'],
				'contact-form-message'					=> $_POST['cf_message']
			);

		$to = "contact@tommyjams.com";
		$sender = "alerts@tommyjams.com";
		$subject = "Query received";

		$this->load->library('contactform/Template');
		$Template=new Template($values,'default.php');
		$body=$Template->output();
			
	    $error = $this->send_email($to, $sender, $subject, $body);

	   	if($error)
	    	$err = 0;
	    else 
	    	$err = 1;

	    $response['error'] = $err;

	    $this->load->helper('functions');
		createResponse($response);
	}
}