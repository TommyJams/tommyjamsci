<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Contactform extends CI_Controller{
	
		public function validateDetails(){
			
			$this->load->helper('functions');
			//	require_once("phpmailer/class.phpmailer.php");
			//require_once("class/Template.class.php");
			$this->load->library('contactform/Template');

			$response=array('error'=>0,'info'=>null);

			$values=array
			(
				'contact-form-name'						=> $_POST['contact-form-name'],
				'contact-form-mail'						=> $_POST['contact-form-mail'],
				'contact-form-message'					=> $_POST['contact-form-message']
			);
	
			/**************************************************************************/
	
			if(isEmpty($values['contact-form-name']))
			{
				$response['error']=1;
				$response['info'][]=array('fieldId'=>'contact-form-name','message'=>CONTACT_FORM_MSG_INVALID_DATA_NAME);
			}
	
			if(!validateEmail($values['contact-form-mail']))
			{
 				$response['error']=1;	
				$response['info'][]=array('fieldId'=>'contact-form-mail','message'=>CONTACT_FORM_MSG_INVALID_DATA_MAIL);
			}
	
			if(isEmpty($values['contact-form-message']))
			{
				$response['error']=1;
				$response['info'][]=array('fieldId'=>'contact-form-message','message'=>CONTACT_FORM_MSG_INVALID_DATA_MESSAGE);
			}	
	
			if($response['error']==1) createResponse($response);
	
			/**************************************************************************/

			if(isGPC()) $values=array_map('stripslashes',$values);
	
			$values=array_map('htmlspecialchars',$values);
	
			$Template=new Template($values,'default.php');
			$body=$Template->output(); 

			$to = "contact@tommyjams.com";
			$sender = "alerts@tommyjams.com";
			$subject = "TommyJams Landing Page: Contact form";
			
			/*
			//Using phpMailer
			$this->load->helper('contactmail');
			send_email($to, $sender, $subject, $body);*/

			//Using codeigniter mail library
			$this->load->library('email');
			$this->email->from($sender, 'TommyJams Admin');
			$this->email->to($to); 
			$this->email->subject($subject);
			$this->email->message($body);

			$this->email->send();

		/*	if(!$mail->Send())
			{
 				$response['error']=1;	
				$response['info'][]=array('fieldId'=>'contact-form-send','message'=>CONTACT_FORM_SEND_MSG_ERROR);
				createResponse($response);		
			} */

			$response['error']=0;
			$response['info'][]=array('fieldId'=>'contact-form-send','message'=>CONTACT_FORM_SEND_MSG_OK);
			createResponse($response);		
		}	
	}
?>
