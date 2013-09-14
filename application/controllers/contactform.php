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
			
			$this->load->helper('contactmail');
			send_email($to, $sender, $subject, $body);
			
			/*
			$mail=new PHPMailer();
			$mail->CharSet='UTF-8';
	
			$mail->SetFrom($values['contact-form-mail'],$values['contact-form-name']); 
			$mail->AddReplyTo($values['contact-form-mail'],$values['contact-form-name']); 
	
			$mail->AddAddress(CONTACT_FORM_TO_EMAIL,CONTACT_FORM_TO_NAME);

			$smtp=CONTACT_FORM_SMTP_HOST;
			if(!empty($smtp))
			{
				$mail->IsSMTP();
				$mail->SMTPDebug = 1;
				$mail->SMTPAuth=true; 
				$mail->SMTPSecure=CONTACT_FORM_SMTP_SECURE;
		
				$mail->Port=CONTACT_FORM_SMTP_PORT;
				$mail->Host=CONTACT_FORM_SMTP_HOST;
				$mail->Username=CONTACT_FORM_SMTP_USER;
				$mail->Password=CONTACT_FORM_SMTP_PASSWORD;
			}
	
			$mail->Subject=CONTACT_FORM_SUBJECT;
			$mail->MsgHTML($body); */

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
