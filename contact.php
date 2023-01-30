<?php
header('Content-Type: application/json');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

if(isset($_POST)) {

	// getting all data sent from ajax
	$comp_name=$_POST['comp_name'];
	$phone=$_POST['phone'];
	$address=$_POST['address'];
	$form_email=$_POST['form_email'];
	$form_message=$_POST['form_message'];

	// Validate the form fields
	if (empty($comp_name) || empty($phone) || empty($address) || empty($form_email) || empty($form_message)) {
	    echo 'Error: Please fill out all required fields!';
	    exit;
	}
	
	if (!filter_var($form_email, FILTER_VALIDATE_EMAIL)) {
	    echo 'Error: Invalid email address!';
	    exit;
	}
	
	$mail = new PHPMailer(true);

	$mail->isSMTP();
	$mail->Host = 'mail.smtp2go.com';
	$mail->SMTPAuth = true;
	$mail->Username = "donotreply@coveraxis.com";
	$mail->Password = "kWTVPlPQZIm5hady";
	$mail->SMTPSecure = 'tls';
	$mail->Port = 2525;

	// $email_template='contact_email.html';
	// $message = file_get_contents($email_template);
	// $message = str_replace('%comp_name%', $comp_name, $message);
	// $message = str_replace('%phone%', $phone, $message);
	// $message = str_replace('%address%', $address, $message);
	// $message = str_replace('%form_email%', $form_email, $message);
	// $message = str_replace('%form_message%', $form_message, $message);

	$mail->setfrom("donotreply@coveraxis.com","Cover Axis" );
	$mail->addaddress("support@coveraxis.com"); //change to support@coveraxis.com
    $mail->isHTML(true);
	$mail->Subject = 'New Contact Enquiry From ' . $comp_name;

	// $mail->MsgHTML($message);
	$mail->Body=	'<strong>Company Name: </strong>' . $comp_name .'
					<br><strong>Phone Number: </strong>' .$phone.'
					<br><strong>Address: </strong>' .$address.'
					<br><strong>Email Address: </strong>' .$form_email.'
					<br><strong>Message: </strong>' .$form_message;

	try {
		$mail->send();
		$success = true;
		echo json_encode(['status' => 'success']);
	} catch (Exception $e) {
		$success = false;
		echo json_encode(['status' => 'error']);
	}
	
};

?>
   
