<?php
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL,"http://52.74.245.167:8000/api/twz/callback?status=OK&ref=twz1234&msg=");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);	 
print $server_output;

?>