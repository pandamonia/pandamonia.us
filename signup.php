<?php

$ua = $_SERVER['HTTP_USER_AGENT'];
if (strpos($ua, 'iPhone') === false && strpos($ua, 'iPad') === false && strpos($ua, 'iPod') === false && !isset($_GET['force'])) {
	header('Location: http://eepurl.com/cifzH', true, 303);
	die();
}

require_once 'MCAPI.class.php';

$errors = array();
$success = false;

if (isset($_POST['check'])) {
	$fname = trim($_POST['fname']);
	$fname = filter_var($fname, FILTER_SANITIZE_STRING);
	if (strlen($fname) === 0)
		$errors[] = 'Invalid First Name: ';
	
	$lname = trim($_POST['lname']);
	$lname = filter_var($lname, FILTER_SANITIZE_STRING);
	if (strlen($lname) === 0)
		$errors[] = 'Invalid Last Name: ';
	
	$email = trim($_POST['email']);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	if (strlen($email) === 0 || !filter_var($email, FILTER_VALIDATE_EMAIL))
		$errors[] = 'Invalid Email Address: ' . $email;
	
	if (count($errors) === 0) {
		define('MC_API', 'fb2036f974dc6c01a179a1c15faa8202-us1');
		define('MC_LIST_ID', '4c78582198');
		
		$api = new MCAPI(MC_API);
		$merge_vars = array('FNAME' => $fname,
							'LNAME' => $lname);
		
		$retVal = $api->listSubscribe(MC_LIST_ID, $email, $merge_vars);
		
		if ($api->errorCode) {
			$msg  = $api->errorMessage;
			$code = $api->errorCode;
			
			$errors[] = "$msg (MC $code)";
		} else {
			$success = true;
		}
	}
}

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'ipad') !== false) { ?>
	<meta name="viewport" content="minimum-scale=1.0, width=506, maximum-scale=0.6667, user-scalable=no" />
	<style type="text/css">
		body {
			padding: 20px;
		}
	</style>
<?php } else { ?>
	<meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" />
<?php } ?>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-touch-fullscreen" content="yes" />
	<title>Subscribe to Pandamonia Updates</title>	
	<link href="iwebkit/css/style.css" rel="stylesheet" media="screen" type="text/css" />
	<script src="iwebkit/javascript/functions.js" type="text/javascript"></script>
	<script type="text/javascript">var success = <?php echo $success ? 'true' : 'false'; ?>;</script>
</head>
<body>
<?php if (false /* stripos($_SERVER['HTTP_USER_AGENT'], 'ipad') === false */) { ?>
	<div id="topbar">
		<div id="title">Subscribe to Updates</div>
	</div>
<?php } // if (stripos($_SERVER['HTTP_USER_AGENT'], 'ipad') !== false) ?>
	<div id="content">
<?php if (count($errors) > 0) { ?>
		<ul class="pageitem">
			<li class="textbox">
				<span class="header"><?php echo (count($errors) == 1) ? 'There was 1 error.' : 'There were ' . count($errors) . ' errors.'; ?></span>
<?php foreach ($errors as $error) {
	echo "\t\t\t\t" . "<p>{$error}</p>" . "\r";
} // foreach ($errors as $error) ?>
			</li>
		</ul>
<?php } // if (count($errors) > 0) ?>
<?php if ($success) { ?>
		<ul class="pageitem">
			<li class="textbox">
				<span class="header">Thanks a bunch!</span>
				<p>Thanks for subscribing, <?= $fname?>! Don&rsquo;t forget to check your email to confirm your subscription.</p>
			</li>
		</ul>
<?php } // (if (success) ?>
		<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
			<input type="hidden" name="check" value="true" />
			<fieldset>
				<span class="graytitle">Information</span>
				<ul class="pageitem">
					<li class="smallfield">
						<span class="name">&nbsp;First Name:</span>
						<input type="text" name="fname" value="<?php if (isset($fname)) echo filter_var($fname, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_ENCODE_HIGH); ?>" placeholder="Arthur" style="text-align: right; padding-right: 10px;" <?php if ($success) echo 'disabled="true "'; ?>/>
					</li>
					<li class="smallfield">
						<span class="name">&nbsp;Last Name:</span>
						<input type="text" name="lname" value="<?php if (isset($lname)) echo filter_var($lname, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_ENCODE_HIGH); ?>" placeholder="Dent" style="text-align: right; padding-right: 10px;" <?php if ($success) echo 'disabled="true "'; ?>/>
					</li>
					<li class="smallfield">
						<span class="name">&nbsp;Email:</span>
						<input type="email" name="email" value="<?php if (isset($email)) echo filter_var($email, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_ENCODE_HIGH); ?>" placeholder="arthur@dent.com" style="text-align: right; padding-right: 10px;" <?php if ($success) echo 'disabled="true "'; ?>/>
					</li>
				</ul>
				<ul class="pageitem">
					<li class="button">
						<input type="submit" name="submit" value="Submit" id="submit" <?php if ($success) echo 'disabled="true "'; ?>/>
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
</body>
</html>