<?php
require '../leone.php';
// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyA9KsHILMYVWrf7Ukfc8tzH4Yh6Ulq7BDg' );
$mytopic = urldecode($_GET['id']);
if ($mytopic != 'ALL')
{
    $mytopic=str_replace('@','-',$mytopic);
}

$registrationIds =  "/topics/".$mytopic;
// prep the bundle
$msg = array
(
	'body' 	=> $String->tis2utf8($_GET['message']),
	'title'		=> urldecode($_GET['title']),
	'subtitle'	=> urldecode($_GET['subtitle']),
	'icon'	=>  'announce',
        'click_action' => 'false',
        'sound' =>  'default',
        'color' => '#03A9F4'
);
$fields = array
(
	'to' 			=> $registrationIds,
	'notification'		=> $msg
);
 
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;
