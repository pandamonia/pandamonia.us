<?php

require_once "php/phpmailer/class.phpmailer.php";

if (!(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']))) {
	$result = array('error' => "Invalid request");
	echo json_encode($result);
	die();
}

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

$mail = new PHPMailer();

// Tell the class to use SMTP
$mail->IsSMTP();

try {
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->Username = 'support@pandamonia.us';
	$mail->Password = 'haw-od-ag-hein-hoat-ut-by';
	$mail->Subject = "[Pandamonia] New Message from $name";
	
	$mail->SetFrom('support@pandamonia.us', 'Pandamonia Support');
	$mail->AddAddress('support@pandamonia.us', 'Pandamonia Support');
	$mail->AddCC($email, $name);
	$mail->MsgHTML($message);
	$mail->Send();
	
	$result = array("success" => true);
	echo json_encode($result);
} catch (phpmailerException $e) {
	$result = array("error" => $e->errorMessage());
	echo json_encode($result);
} catch (Exception $e) {
	$result = array("error" => $e->getMessage());
	echo json_encode($result);
}

?>