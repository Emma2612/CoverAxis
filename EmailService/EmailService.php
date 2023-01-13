<?php

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Request-Method: POST");
header('content-type: application/json; charset=utf-8');

$responseObject = [];
$requestDetails = $_POST;

if(empty($requestDetails)){
	$responseObject["success"] = false;
    $responseObject["message"] = "Invalid data!";
	echo json_encode($responseObject);die;
}

$mail = new PHPMailer();

//$mail->SMTPDebug = 3;                               	// Enable verbose debug output

$mail->isSMTP();                                      	// Set mailer to use SMTP
$mail->Host = 'smtp.sendgrid.net';  					// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               	// Enable SMTP authentication
$mail->Username = 'apikey';                 			// SMTP username
$mail->Password = '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';                           // SMTP password
$mail->SMTPSecure = 'tls';                            	// Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    	// TCP port to connect to
$mail->Priority = 1;									// MS Outlook custom header
														// May set to "Urgent" or "Highest" rather than "High"
$mail->AddCustomHeader("X-MSMail-Priority: High");		// Not sure if Priority will also set the Importance header:
$mail->AddCustomHeader("Importance: High");

$mail->From = 'shaynish@netcompartners.com';
$mail->FromName = 'Zapproach';							//Email Name
$mail->addAddress('shaynish@netcompartners.com');     	// Add a recipient

$mail->Subject = 'Notification';						//Email Subject

#region Email UI

$userName = (empty($requestDetails['full_name'])) ? $requestDetails['first_name'] .' '. $requestDetails['last_name'] : $requestDetails['full_name'];
$emailDetails = (empty($requestDetails['full_name'])) ? '' :
	'<h5>Company Name: '.$requestDetails['company'].'</h5>
	<h5>Service: '.$requestDetails['service'].'</h5>';

$mail->Body = '
<html>
<head>
<title></title>
</head>
<body>
	<p><strong>'.$userName.'</strong> has contacted zapproach with the below message:</p>
	<h5>Email Address: '.$requestDetails['email'].'</h5>
	'.$emailDetails.'
	<p>Message: 
	<q>'.$requestDetails['message'].'</q>
	</p>
</body>
</html>
';
#endregion
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    $responseObject["success"] = false;
    $responseObject["message"] = "An error occured while sending notification!";
} else {
    $responseObject["success"] = true;
    $responseObject["message"] = "Notification has been sent!";
}

echo json_encode($responseObject);die;
?>