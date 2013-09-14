<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Newsletter extends CI_Controller{
	
		public function validateData(){
	
			$this->load->helper('functions');
			$response=array('error'=>0,'info'=>null);

			$values=array
			(
				'newsletter-form-mail'		=> $_POST['newsletter-form-mail']
			);
	
			if(isGPC()) 
				$values=array_map('stripslashes',$values);
	
			/**************************************************************************/
	
			if(!validateEmail($values['newsletter-form-mail']))
			{
 				$response['error']=1;	
				$response['info'][]=array('fieldId'=>'newsletter-form-mail','message'=>NEWSLETTER_FORM_MSG_INVALID_DATA_MAIL);
				createResponse($response);
			}
	
			/**************************************************************************/
	
			if(($handle=fopen(NEWSLETTER_FORM_DATA_FILE_PATH,'a+'))===false)
			{
 				$response['error']=1;	
				$response['info'][]=array('fieldId'=>'newsletter-form-send','message'=>NEWSLETTER_FORM_MSG_FILE_ERROR);
				createResponse($response);		
			}
	
			/**************************************************************************/
	
			if(($emails=@split("\n",fread($handle,filesize(NEWSLETTER_FORM_DATA_FILE_PATH))))===false)
			{
 				$response['error']=1;	
				$response['info'][]=array('fieldId'=>'newsletter-form-send','message'=>NEWSLETTER_FORM_MSG_FILE_ERROR);
				createResponse($response);		
			}
	
			/**************************************************************************/
	
			$values['newsletter-form-mail']=strtolower($values['newsletter-form-mail']);
			if(in_array($values['newsletter-form-mail'],$emails))
			{
  				$response['error']=1;		
				$response['info'][]=array('fieldId'=>'newsletter-form-mail','message'=>NEWSLETTER_FORM_MSG_MAIL_EXIST);
				createResponse($response);	
			}
	
			/**************************************************************************/
	
			if(fwrite($handle,$values['newsletter-form-mail']."\n")===false)
			{
  				$response['error']=1;		
				$response['info'][]=array('fieldId'=>'newsletter-form-send','message'=>NEWSLETTER_FORM_MSG_FILE_ERROR);
				createResponse($response);		
			}
    		else
    		{
        		/************* This code is for MailChimp Integration ****************/
        		$config = array(
	    				'apikey' => '4b1d3dfd9a40c3a47861fa481d644505-us5' );

				$this->load->library('mailchimp/MCAPI', $config, 'mail_chimp');

        		// API Key: http://admin.mailchimp.com/account/api/
        		// $api = new MCAPI('4b1d3dfd9a40c3a47861fa481d644505-us5');

        		// List's Id: http://admin.mailchimp.com/lists/
        		$list_id = "a29827c7a6";

        		// Email to be subscribed
        		$email = $values['newsletter-form-mail'];
		
				// List Parameters
				$email_type = 'html';
				$double_optin=true;
				$update_existing=false;
				$replace_interests=true;
				$send_welcome=true;
				$listType='Fan';
				$merge_vars = array(
									'GROUPINGS'=>array(
										array('name'=>'User Type', 'groups'=>$listType)
										)
									);

        		if($this->mail_chimp->listSubscribe($list_id, $email, $merge_vars, $email_type, $double_optin, $update_existing, $replace_interests, $send_welcome) === false) 
        		{
            		//'Error: ' . $api->errorMessage;
            		$response['error']=1;
            		$response['info'][]=array('fieldId'=>'newsletter-form-send','message'=>NEWSLETTER_FORM_MSG_API_FAILURE);
            		createResponse($response);
        		}
				
				else
				{
					$to = "alerts@tommyjams.com";
					$sender = "alerts@tommyjams.com";
					$subject = "$email joined mailing list as a fan";
					$message = "$email joined mailing list as a fan"; 
					
					$this->load->helper('mail');
           			send_email($to, $sender, $subject, $message);
				}  
			} 

			/**************************************************************************/
	
			$response['error']=0;	
			$response['info'][]=array('fieldId'=>'newsletter-form-send','message'=>NEWSLETTER_FORM_SEND_MSG_OK);
			createResponse($response);		
	
			/**************************************************************************/	
			/**************************************************************************/
		}
	}	
?>