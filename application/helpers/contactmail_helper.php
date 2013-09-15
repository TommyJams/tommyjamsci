<?php

function send_email($to, $sender, $subject, $body){

	$message = "
	<html>
	<head>
	<title>$subject</title>
	</head>
	<body>
		$body
	</body>
	</html>
	";

	//	$headers = "MIME-Version: 1.0" . "\r\n";
	//	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

    //	require_once("phpmailer/class.phpmailer.php");
    	$CI =& get_instance();
    	$CI->load->library('phpmailer/PHPMailer');
    	$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = SMTP_CRYPTO; // secure transfer enabled REQUIRED for GMail
		$mail->Host = SMTP_HOST;
		$mail->Port = SMTP_PORT;
		$mail->Username = SMTP_USERNAME;
		$mail->Password = SMTP_PASSWORD;           
		$mail->SetFrom($sender, SMTP_SENDER);
		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AddAddress($to);
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else {
			$error = 'Message sent!';
			return true;
		}
    	console.log('$error'); 
	}
?>