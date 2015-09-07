<?php 

require_once('CMBase.php');

$api_key = $_POST["cm_api_key"];
$client_id = null;
$campaign_id = null;
$list_id = $_POST['cm_list_id'];
$cm = new CampaignMonitor( $api_key, $client_id, $campaign_id, $list_id );

//This is the actual call to the method, passing email address, name.
$result = $cm->subscriberAdd($_POST["cm_email"], $_POST["cm_name"]);

if($result['Result']['Code'] == 0)
	echo 'Success';
else
	echo 'Error : ' . $result['Result']['Message'];

?>