
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$myCompanyName = "CompanyName";
$myCompanyEmail = "noreply@CompanyName.com";
$myCompanyEmailPassword = "CompanyEmailPassword";

$myPersonalEmail = "personalEmail@gmail.com";

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

if(isset($_POST['submit'])) {

	$mail = new PHPMailer(true);

	//$mail->SMTPDebug = 0;

	$mail->Host = 'smtp.mboxhosting.com';
	$mail->SMTPAuth = true;
	$mail->Username = $myCompanyEmail;
	$mail->Password = $myCompanyEmailPassword;
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;

	$mail->setFrom($myCompanyEmail, $myCompanyName);
	$mail->addAddress($myPersonalEmail);
	$mail->addReplyTo($_POST['email'], $_POST['name']);

	$mail->isHTML(true);
	$mail->Subject = 'My Subject';
	$mail->Body = $_POST['message'];

	try {
		$mail->send();
		echo 'Your message was sent successfully!';
	} catch (Exception $e) {
		echo "Your message could not be sent! PHPMailer Error: {$mail->ErrorInfo}";
	}
	
} else {
	echo "There is a problem with the document!";
}

?>
