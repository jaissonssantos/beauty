<?php

define("WEBMASTER_EMAIL", 'congressojuridicoacre@gmail.com');

$error = false;
$fields = array( 'name','email', 'phone', 'message' );

foreach ( $fields as $field ) {
	if ( empty($_POST[$field]) || trim($_POST[$field]) == "" )
		$error = true;
}

if ( !$error ) {

	$name    = stripslashes($_POST['name']);
	$email   = trim($_POST['email']);
	$phone   = stripslashes($_POST['phone']);
	$message = stripslashes($_POST['message']);

	$mail = @mail(WEBMASTER_EMAIL, "Você tem uma nova messagem!",
		 "De: " . $name . " <" . $email . ">\r\n" . "Telefone:" . "<" . $phone . ">"
		."Para: " . $email . "\r\n"
		."Conteúdo: " . $message . "\r\n"
		."Enviado por Congresso Jurídico Acre | Versão PHPMailer:" . phpversion());

	if ( $mail ) {
		echo 'Success';
	} else {
		echo $error;
	}
}

?>