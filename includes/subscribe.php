<?php

$api_key = $_POST["api_key"];
$list_id = $_POST['list_id'];

include( 'mailchimp.php' );
$MailChimp = new \drewm\MailChimp( $api_key );
$subscriber = $MailChimp->call( 'lists/subscribe', array(
	'id' => $list_id, 
	'email' => array( 'email' => $_POST['email'] ) 
));

if ( ! empty( $subscriber['leid'] ) ) {
   echo "Success";
}
else
{
    echo "Failure";
}

?>