<?php
include '../leone.php';
include '../admin/controller/imei.php';
header('Content-Type: application/json; charset=utf-8');
$imei = new imei();
$param_imeino = (!empty($_REQUEST["imeino"])) ? $_REQUEST["imeino"] : "";
$imeidata = $imei->getcheckregister($param_imeino);
if ($imeidata=='N') {		
	$dataarray = array("result"=>"OK","result_desc"=>"","imeino"=>$param_imeino);
}else if ($imeidata=='0') {	
    $msg = "ไม่พบ Imei นี้ในระบบ";
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"imeino"=>$param_imeino);
}else{
    $msg = "บัญชีนี้ ได้ทำรายการไปแล้ว";
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"imeino"=>$param_imeino);
}

$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>