<?php

require "php/phpmailer/class.phpmailer.php";

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$name = htmlspecialchars($name, ENT_COMPAT, 'UTF-8');

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$email = htmlspecialchars($email, ENT_COMPAT, 'UTF-8');

$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
$message = htmlspecialchars($message, ENT_COMPAT, 'UTF-8');

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
	$mail->Subject = '[Pandamonia] New Message from ' . $name;
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