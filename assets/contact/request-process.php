<?php

define("WEBMASTER_EMAIL", 'kulthemes@gmail.com');

$error = false;
$fields = array( 'discuss','name', 'phone', 'email' );

foreach ( $fields as $field ) {
	if ( empty($_POST[$field]) || trim($_POST[$field]) == "" )
		$error = true;
}

if ( !$error ) {

	$discuss = stripslashes($_POST['discuss']);
	$name = stripslashes($_POST['name']);
	$phone = stripslashes($_POST['phone']);
	$email = trim($_POST['email']);

	$mail = @mail(WEBMASTER_EMAIL, "You have a new message.", $discuss,
		 "From: " . $name . " <" . $email . ">\r\n" . "Phone:" . "<" . $phone . ">"
		."Reply-To: " . $email . "\r\n"
		."X-Mailer: PHP/" . phpversion());

	if ( $mail ) {
		echo 'Success';
	} else {
		echo $error;
	}
}

?>