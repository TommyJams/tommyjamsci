<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Obom extends CI_Controller{

	public function obomLandingPage(){
		// echo "this is you";
		$this->load->view('obom_view');
	}
}
?>