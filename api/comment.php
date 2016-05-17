<?php
require '../leone.php';
header('Content-Type: application/json; charset=utf-8');
$param_message = (!empty($_REQUEST["message"])) ? $_REQUEST["message"] : "";
$param_from = (!empty($_REQUEST["from"])) ? $_REQUEST["from"] : "";
$param_appid = (!empty($_REQUEST["appid"])) ? $_REQUEST["appid"] : "";
$param_ipaddr = (!empty($_REQUEST["ip"])) ? $_REQUEST["ip"] : "";
$param_rate = (!empty($_REQUEST["rate"])) ? $_REQUEST["rate"] : "";

$param_message = $String->utf82tis($param_message);
$param_from = $String->utf82tis($param_from);
if ($param_rate=='') $param_rate = "0";

if ($param_from!='' && $param_message!='') {
	$SqlUpdate = "insert into tbl_comment (c_appid,c_postby,c_message,c_date,c_rate,c_ipaddr) values ('".$param_appid."','".$param_from."','".$param_message."',now(),'".$param_rate."','".$param_ipaddr."')";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	$DatabaseClass->DBClose();
    $dataarray = array("result"=>"OK","result_desc"=>"");
}else{
	$msg = "กรุณาข้อมูลให้ครบตามที่กำหนดด้วยค่ะ";
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}

$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>