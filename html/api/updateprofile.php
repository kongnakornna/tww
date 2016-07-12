<?php
require '../leone.php';
header('Content-Type: application/json; charset=utf-8');
require '../admin/controller/imei.php';
require '../admin/controller/member.php';
require '../admin/controller/payment.php';
$imei = new imei();
$member = new member();
$payment = new payment();

$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";
$param_address = (!empty($_REQUEST["address"])) ? $_REQUEST["address"] : "";
$param_phone = (!empty($_REQUEST["phone"])) ? $_REQUEST["phone"] : "";
$param_bank = (!empty($_REQUEST["bank"])) ? $_REQUEST["bank"] : "";
$param_bankcode = (!empty($_REQUEST["bankcode"])) ? $_REQUEST["bankcode"] : "";

$param_fname = $String->utf82tis($param_fname);
$param_address = $String->utf82tis($param_address);
if ($param_fname=='' || $param_email=='' || $param_province=='') {
	$msg = "กรุณาข้อมูลให้ครบตามที่กำหนดด้วยค่ะ";
    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
	$SqlCheck = "update tbl_member set m_mobile='".$param_phone."',m_fullname='".$param_fname."',m_province='".$param_province."',m_address='".$param_address."',m_bankid='".$param_bank."',m_bankcode='".$param_bankcode."'  where m_email='".trim($param_email)."'";
	$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
	$msg = "ปรับปรุงข้อมูลเรียบร้อยค่ะ";
    $dataarray = array("result"=>"OK","result_desc"=>$String->tis2utf8($msg));
}
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>