<?php

define("WEBMASTER_EMAIL", 'kulthemes@gmail.com');

$error = false;
$fields = array( 'email02' );

foreach ( $fields as $field ) {
	if ( empty($_POST[$field]) || trim($_POST[$field]) == "" )
		$error = true;
}

if ( !$error ) {

	$email = trim($_POST['email']);

	$mail = @mail(WEBMASTER_EMAIL, "You have a new message. Subsribe email",
		 "From: " . $email . "\r\n"
		."Reply-To: " . $email . "\r\n"
		."X-Mailer: PHP/" . phpversion());

	if ( $mail ) {
		echo 'Success';
	} else {
		echo $error;
	}
}

?>