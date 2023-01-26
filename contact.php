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
	$mail->Host = 'smtp.sendgrid.net';
	$mail->SMTPAuth = true;
	$mail->Username = "apikey";
	$mail->Password = "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";
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;

	$email_template='contact_email.html';
	$message = file_get_contents($email_template);
	$message = str_replace('%comp_name%', $comp_name, $message);
	$message = str_replace('%phone%', $phone, $message);
	$message = str_replace('%address%', $address, $message);
	$message = str_replace('%form_email%', $form_email, $message);
	$message = str_replace('%form_message%', $form_message, $message);

	$mail->setfrom("shaynish@netcompartners.com","Cover Axis" );
	$mail->addaddress("emma@zapproach.com"); 
    $mail->isHTML(true);
	$mail->Subject = 'New Contact Enquiry From ' . $comp_name;

	$mail->MsgHTML($message);
	// $mail->body="TEST MESSAGE";

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
   
