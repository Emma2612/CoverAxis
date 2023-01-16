<<<<<<< HEAD

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
=======
<?php
// Output messages
$responses = [];
// Check if the form was submitted
if (isset($_POST['companyname'], $_POST['phone'], $_POST['address'], $_POST['email'], $_POST['message'])) {
	// Validate email adress
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$responses[] = 'Email is not valid!';
	}
	// Make sure the form fields are not empty
	if (empty($_POST['companyname']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['email']) || empty($_POST['message'])) {
		$responses[] = 'Please complete all fields!';
	} 
	// If there are no errors
	if (!$responses) {
		// Where to send the mail? It should be your email address
		$to      = 'trainee2@zapproach.com';
		// Send mail from which email address?
		$from = 'noreply@example.com';
		// Mail subject
		$subject = 'New Contact Request from '.$_POST['companyname'];
		// Mail message
		$message = $_POST['msg'];
		// Mail headers
		$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $_POST['email'] . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		// Try to send the mail
		if (mail($to, $subject, $message, $headers)) {
			// Success
			$responses[] = 'Message sent!';		
		} else {
			// Fail
			$responses[] = 'Message could not be sent! Please check your mail server settings!';
		}
	}
}
?>
>>>>>>> 5f117149a21fa710ec182b7ace6231e30106feb3
