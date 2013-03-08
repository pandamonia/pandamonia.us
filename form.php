<?php

require_once "php/phpmailer/class.phpmailer.php";

$has_name = isset($_POST['name']);
$has_email = isset($_POST['email']);
$has_message = isset($_POST['message']);

if (!($has_name && $has_email && $has_message)) {
	$error = '';
	if (!$has_name) {
		$error .= 'name';
	}
	if (!$has_email) {
		if (strlen($error)) $error .= ', ';
		$error .= 'email';
		$did_add = true;
	}
	if (!$has_message) {
		if (strlen($error)) $error .= ', ';
		$error .= 'message';
	}
	$result = array('error' => 'Invalid fields: ' . $error);
	echo json_encode($result);
	die();
}

$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = filter_var($_POST['message'], FILTER_SANITIZE_SPECIAL_CHARS);

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
	$mail->CharSet = 'utf-8';
	
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