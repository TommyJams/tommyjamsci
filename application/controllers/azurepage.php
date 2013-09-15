<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Azurepage extends CI_Controller{

	public function index(){
		 $this->azurelanding();
	}

	public function azurelanding(){
		$this->load->view('azure_view');
	}
}
?>