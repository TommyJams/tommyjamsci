<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller{

	public function betalandingpage(){
		// echo "this is you";

		ob_start();

		$sessionArray = $this->session->all_userdata();

		//$session_id = $this->session->userdata('session_id');
		if (!isset($sessionArray['session_id'])) {
			session_start();
		}

		// $this->session->userdata('username')
		if(isset($sessionArray['username'])) {
		//header("Location: promoter.php?success=1");
		header("Location: promoter");	
		exit;
		}

		elseif(isset($sessionArray['username_artist'])) {
		//header("Location: artist.php?success=1");
		header("Location: artist");
		exit;
		} 
		
		$this->load->view('betapage_view');
	}
}
?>