<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$myCompanyName = "Cover Axis";
$myCompanyEmail = "uat@zsolu.com";
$myCompanyEmailPassword = "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";

$myPersonalEmail = "emma@zapproach.com";

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

if(isset($_POST)) {

	$mail = new PHPMailer(true);

	$mail->SMTPDebug = 2;

	$mail->isSMTP();
	$mail->Host = 'smtp.sendgrid.net';
	$mail->SMTPAuth = true;
	$mail->Username = "apikey";
	$mail->Password = "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";
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;

	// getting all data sent from ajax
	$comp_name=$_POST['comp_name'];
	$phone=$_POST['phone'];
	$address=$_POST['address'];
	$form_email=$_POST['form_email'];
	$form_message=$_POST['form_message'];

	$email_template='contact_email.html';
	$message = file_get_contents($email_template);
	$message = str_replace('%comp_name%', $comp_name, $message);
	$message = str_replace('%phone%', $phone, $message);
	$message = str_replace('%address%', $address, $message);
	$message = str_replace('%form_email%', $form_email, $message);
	$message = str_replace('%form_message%', $form_message, $message);

	$mail->setFrom("uat@zsolu.com","Cover Axis" );
	$mail->addAddress("emma@zapproach.com"); //switch to support@coveraxis.com

	$mail->isHTML(true);
	$mail->Subject = 'New Contact Enquiry From ' . $comp_name;
	$mail->MsgHTML($message);
	// $mail->Body = "Company Name : ".$comp_name. "
	// 				<br>Phone Number: ".$phone. "
	// 				<br>Address: ".$address. "
	// 				<br>E-mail: ".$form_email. "				
	// 				<br>Message: ".$form_message ;

	try {
		$mail->send();
		echo 'Your message was sent successfully!';
	} catch (Exception $e) {
		echo "Your message could not be sent! PHPMailer Error: {$mail->ErrorInfo}";
	}
	
}

?>
