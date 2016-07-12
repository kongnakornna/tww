<?php
include '../leone.php';
include '../admin/controller/partner.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$partner = new partner();
$payment = new payment();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_pcode = (!empty($_REQUEST["pcode"])) ? $_REQUEST["pcode"] : "";

if ($param_pcode=='' || $param_email=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $havepartner = $partner->havepartner($param_pcode);
    if ($havepartner) {
		$result = $member->inapplogout($param_pcode,$param_email);
		$dataarray = array("result"=>"OK","result_desc"=>"");
	}else{
		$msg = "คุณไม่ได้รับอนุญาติให้บริการค่ะ";
       	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>