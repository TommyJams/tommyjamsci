<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller{

	public function betalandingpage(){

		$sessionArray = $this->session->all_userdata();

		if (!isset($sessionArray['session_id'])) {
			session_start();
		}

		if(isset($sessionArray['username'])) {
		header("Location: promoter");	
		exit;
		}

		elseif(isset($sessionArray['username_artist'])) {
		header("Location: artist");
		exit;
		} 
		
		$this->load->view('betapage_view');
	}
}
?>