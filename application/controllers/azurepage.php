<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Azurepage extends CI_Controller{

	public function index(){
		// echo "You are in index";
		// $this->addstuff();
		 $this->azurelanding();
	}


	public function azurelanding(){
		// echo "this is you";
		$this->load->view('azure_view');
	}

}
?>