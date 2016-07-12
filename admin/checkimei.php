<?php
require '../leone.php';
require './controller/imei.php';
header('Content-Type: text/html; charset=utf-8');
$param_no = (!empty($_REQUEST["no"])) ? $_REQUEST["no"] : "";
$answer = "FAIL";
$imei = new imei();

$valid = $imei->getcheck($param_no);
if($valid){
   $answer = "OK";
}

print $answer;
?>