<?php

function a2_obfuscate($link)
{
	$result = '';
	$chars = preg_split('//', $link, -1, PREG_SPLIT_NO_EMPTY);
	
	foreach ($chars as $char)
	{
		$ord = ord($char);
		switch (mt_rand(0, 3))
		{
			case 0:
				$result = $result . '&#000' . $ord . ';';
				break;
			
			case 1:
				$result = $result . '&#' . $ord . ';';
				break;
			
			case 2:
				$ord = base_convert($ord, 10, 16);
				$result = $result . '&#x' . $ord . ';';
				break;
			
			case 3:
				$result = $result . $char;
				break;
		}
	}
	
	return $result;
}

header("Content-Type: text/plain");
echo a2_obfuscate(urldecode($_GET['string']));

/*

		<ul id="social">
			<li><a href="<?php echo a2_obfuscate('aim:goim?screenname=a2%40pandamonia.us'); ?>">
				<img src="images/social/aim_16.png" alt="AIM" class="aim" />
			</a></li>
			<li><a href="<?php echo a2_obfuscate('mailto:a2@pandamonia.us'); ?>">
				<img src="images/social/email_16.png" alt="Email" class="email" />
			</a></li>
			<li><a href="<?php echo a2_obfuscate('http://www.facebook.com/alex.akers'); ?>">
				<img src="images/social/facebook_16.png" alt="Facebook" class="facebook" />
			</a></li>
			<li><a href="<?php echo a2_obfuscate('sms:a2@pandamonia.us'); ?>">
				<img src="images/social/apple_16.png" alt="iMessage" class="imessage" />
			</a></li>
			<li><a href="<?php echo a2_obfuscate('http://www.linkedin.com/in/alexsanderakers'); ?>">
				<img src="images/social/linkedin_16.png" alt="LinkedIn" class="linkedin" />
			</a></li>
			<li><a href="<?php echo a2_obfuscate('http://twitter.com/a2'); ?>">
				<img src="images/social/twitter_16.png" alt="Twitter" class="twitter" />
			</a></li>
			<li><a href="<?php echo a2_obfuscate('skype:pandamonia289?call'); ?>">
				<img src="images/social/skype_16.png" alt="Skype" class="skype" />
			</a></li>
		</ul>

*/

?>