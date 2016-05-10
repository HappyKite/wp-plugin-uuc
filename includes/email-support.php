<?php

if ( !isset( $_POST['submit'] ) ) {
	return;
}

$name = $_POST['name-field'];
$customer_email = $_POST['email-field'];
$subject = $_POST['subject-field'];
$message = $_POST['message-field'];

//Validation
if ( empty( $name ) || empty( $customer_email ) ) {
	$error = 'Please enter your Name and Email';
	return_with_error( $error );
}


function return_with_error( $error ) {
	$admin_page = get_admin_url() . 'tools.php?page=uuc-options';

	header( "'Location: ' . $admin_page " );
}

?>