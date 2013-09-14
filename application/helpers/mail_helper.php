<?php
//ini_set("SMTP","ssl://smtp.gmail.com" ); 
//ini_set('sendmail_from', 'testpromoter.tommy@gmail.com');
//ini_set('smtp_port', '587');
//ini_set('extension','php_openssl.dll');

function send_email($to, $sender, $subject, $mess){

	$message = "
	<html>
	<head>
	<title>$subject</title>
	</head>
	<body>
	<div style='background:#000; padding:10px;'>
		<table style='text-align:center; width: 100%; padding:50px; padding-top:20px;'>
			<tr style='margin-top:20px;'>
				<img src='http://www.tommyjams.com/beta/images/tjlogo_small.png'>
			</tr>
			<tr style='margin-top:50px; background:#ffcc00; padding:10px;'>
				$mess
			</tr>
			<!--<tr>
				<font color=white size=2>To unsubscribe <a href='update.php?un=true'>click here
			</tr>-->
		</table>
	</div>
	</body>
	</html>
	";

	//	$headers = "MIME-Version: 1.0" . "\r\n";
	//	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

		$CI =& get_instance();
    	$CI->load->library('phpmailer/PHPMailer');
    //	require_once("phpmailer/class.phpmailer.php");
    	$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.live.com';
		$mail->Port = 25;
		$mail->Username = 'alerts@tommyjams.com';
		$mail->Password = '1tommyblah';           
		$mail->SetFrom($sender, "TommyJams Admin");
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
/*
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
// More headers
$headers .= 'From: tommyjams.official@gmail.com' . "\r\n";

mail($to,$subject,$message,$headers);*/
?>